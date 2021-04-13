<?php

namespace App\Services;

/*use App\Enums\AppointmentStatus;*/

use App\Enums\AppointmentStatus;
use App\Enums\NotificationType;
use App\Models\Appointment;
use App\Models\AppointmentDocument;
use App\Models\AppointmentTask;
use App\Models\Payment;
use App\Repositories\Interfaces\AppointmentRepositoryInterface;
use App\Repositories\Interfaces\AssistantTypeRepositoryInterface;
use App\Repositories\Interfaces\NiftyAssistantRepositoryInterface;
use Carbon\Carbon;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class AppointmentService
{
    private AppointmentRepositoryInterface $appointmentRepo;
    private NiftyAssistantRepositoryInterface $niftyAssistantRepo;
    private AssistantTypeRepositoryInterface $assistantTypeRepo;
    private NotificationService $notificationSvc;

    /**
     * @param AppointmentRepositoryInterface $appointmentRepo
     * @param NiftyAssistantRepositoryInterface $niftyAssistantRepo
     * @param AssistantTypeRepositoryInterface $assistantTypeRepo
     * @param NotificationService $notificationSvc
     */
    public function __construct(
        AppointmentRepositoryInterface $appointmentRepo,
        NiftyAssistantRepositoryInterface $niftyAssistantRepo,
        AssistantTypeRepositoryInterface $assistantTypeRepo,
        NotificationService $notificationSvc
    ) {
        $this->appointmentRepo = $appointmentRepo;
        $this->niftyAssistantRepo = $niftyAssistantRepo;
        $this->assistantTypeRepo = $assistantTypeRepo;
        $this->notificationSvc = $notificationSvc;
    }

    public function get(int $id): Appointment
    {
        return $this->appointmentRepo->get($id);
    }

    public function getAll(): Collection
    {
        return $this->appointmentRepo->getAll();
    }

    public function getPending(): Collection
    {
        return $this->appointmentRepo->getByStatus(AppointmentStatus::PENDING);
    }

    public function getTimeline(): array
    {
        $timeline = [];
        $appointments = $this->getAll();
        foreach ($appointments as $appointment) {
            $string = 'New Appointment placed by '.$appointment->user->name;
            array_push($timeline, [
                'created_at' => $appointment->created_at,
                'string'     => $string,
                'link'       => route('admin.appointments.show', $appointment->id),
            ]);
        }
        return $timeline;
    }

    public function storeAppointment(array $all): bool
    {
        try {
            if (array_key_exists('autocomplete_search', $all)) {
                unset($all['autocomplete_search']);
            }

            if (array_key_exists('assistant_type_id', $all)) {
                unset($all['assistant_type_id']);
            }

            $task_ids = $all['task_ids'];
            unset($all['task_ids']);

            if (array_key_exists('documents', $all)) {
                $documents = $all['documents'];
                unset($all['documents']);
            }

            if (array_key_exists('vehicle_needed', $all)) {
                $all['vehicle_needed'] = true;
            }

            $appointment = Appointment::create($all);

            foreach ($task_ids as $task_id) {
                AppointmentTask::create([
                    'task_id'        => $task_id,
                    'appointment_id' => $appointment->id,
                ]);
            }

            if (isset($documents)) {
                foreach ($documents as $document) {
                    $document['appointment_id'] = $appointment->id;
                    AppointmentDocument::create($document);
                }
            }

            Payment::create([
                'payment_id'      => 'TEST123',
                'appointment_id'  => $appointment->id,
                'advance_payment' => rand(2, 99),
                'total'           => rand(2, 99),
            ]);

            $this->notificationSvc->notifyAdmin(NotificationType::AppointmentPlaced, $appointment);
            return true;
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return false;
        }
    }

    public function rejectAppointment($id): array
    {
        $appointment = $this->get($id);
        $nifty_assistant = $appointment->nifty_service->nifty_assistant;

        $timeline_text = $nifty_assistant->getName();
        $timeline_text .= ' (ID: <a href="'.route('admin.nifty_assistants.show', $nifty_assistant->id).'">'.$nifty_assistant->id.'</a>)';
        $timeline_text .= ' REJECTED Task!';

        $data = [
            'nifty_service_id'   => null,
            'timeline'           => $timeline_text,
        ];

        $update = $this->update($id, $data);
        if (!$update) {
            flash('Task Rejection Failed!')->error();
        }
        return $data;
    }

    public function acceptAppointment($id): array
    {
        $appointment = $this->get($id);
        $nifty_assistant = $appointment->nifty_service->nifty_assistant;

        $data = [
            'timeline' => $nifty_assistant->getName().' ACCEPTED Task!',
            'status'   => 1,
        ];

        $update = $this->update($id, $data);
        if (!$update) {
            flash('Task Accepting Failed!')->error();
        }
        return $data;
    }

    public function update(int $id, array $data): bool
    {
        try {
            $appointment = $this->appointmentRepo->get($id);

            if (array_key_exists('timeline', $data)) {
                if (is_array($appointment->timeline)) {
                    $timeline = $appointment->timeline;
                } else {
                    $timeline = [];
                }

                $timeline[] = $data['timeline'];
                $data['timeline'] = $timeline;
            }

            if (array_key_exists('document_files', $data)) {
                unset($data['document_files']);
            }

            if (array_key_exists('documents', $data)) {
                foreach ($data['documents'] as $document) {
                    $document['appointment_id'] = $appointment->id;
                    AppointmentDocument::create($document);
                }
                unset($data['documents']);
            }

            if (array_key_exists('task_ids', $data)) {
                $task_ids = $data['task_ids'];
                AppointmentTask::where('appointment_id', $id)->delete();
                foreach ($task_ids as $task_id) {
                    AppointmentTask::create([
                        'task_id'        => $task_id,
                        'appointment_id' => $appointment->id,
                    ]);
                }
                unset($data['task_ids']);
            }

            if (array_key_exists('nifty_assistant_id', $data)) {
                $nifty = $this->niftyAssistantRepo->get($data['nifty_assistant_id']);
                $assistant_type_id = $appointment->appointment_tasks->first()->task->assistant_type_id;
                if (! $nifty->cheapestService($assistant_type_id)) {
                    flash('This Assistant does not provide the Selected Tasks!')->error();

                    return false;
                }
                $data['nifty_service_id'] = $nifty->cheapestService($assistant_type_id)->id;
                unset($data['nifty_assistant_id']);
            }

            if (count($data) > 0) {
                $appointment->update($data);
            }

            return true;
        } catch (QueryException | Exception $e) {
            Log::error($e->getMessage());
            return false;
        }
    }

    /*public function assignNiftyAssistant($appointment): void
    {
        // Get Date & Time of Appointment
        $date = $appointment->date;
        $time = explode(':', $appointment->time)[0];

        // Get Appointment Day
        $day = Carbon::parse($date)->format('l');

        // Create Days Array
        $days = [
            'Sunday',
            'Monday',
            'Tuesday',
            'Wednesday',
            'Thursday',
            'Friday',
            'Saturday'
        ];

        // Get Day Index for the Appointment Day
        $index = array_search($day, $days, true);

        // Get Approved Nifty Assistant
        $nifty_assistants = $this->niftyAssistantRepo->getByStatus(AppointmentStatus::ACCEPTED);

        // Get Available Nifty Assistants
        $available_assistants = [];

        foreach ($nifty_assistants as $nifty_assistant) {
            // Decode JSON data from DB
            $availability_days = json_decode($nifty_assistant->availability);

            $periods = $availability_days[$index]->periods;

            // Check if Assistant works on that day.
            if (count($periods) > 0) {
                // Get Start Time & End Time of Nifty Assistant Duty
                $start_time = $periods[0]->start;
                $end_time = $periods[0]->end;

                // Check if time contains "p" and convert it to PM
                if (strpos($start_time, 'p') > 0) {
                    $start_time = str_replace('p', ' PM', $start_time);
                    $start_time = date("H:i", strtotime($start_time));
                    $start_time = explode(':', $start_time)[0];
                }

                // Check if time contains "p" and convert it to PM
                if (strpos($end_time, 'p') > 0) {
                    $end_time = str_replace('p', ' PM', $end_time);
                    $end_time = date("H:i", strtotime($end_time));
                    $end_time = explode(':', $end_time)[0];
                }

                // Check if appointment time is between start time and end time of assistant .
                if ($time > $start_time && $time <= $end_time) {
                    // If yes, push it to array.
                    array_push($available_assistants, $nifty_assistant->id);
                }
            }
        }

        if (count($available_assistants) > 0) {
            $nifty_assistant_id = $available_assistants[array_rand($available_assistants)];
            $timeline[] = 'System assigned Nifty Assistant : <a href="'.route("admin.nifty_assistants.show", $nifty_assistant_id).'">'.$nifty_assistant_id.'</a> to this Task.';

            $this->update($appointment->id, [
                'nifty_assistant_id' => $nifty_assistant_id,
                'timeline'           => $timeline,
            ]);
        }
    }*/

    public function destroy($id): void
    {
        try {
            $this->get($id)->delete();
            flash('Booking Cancelled successfully!')->success();
        } catch (Exception $e) {
            flash('Booking Cancellation error!')->error();
            Log::error($e->getMessage());
        }
    }

    public function getAssistantsPendingPayouts(): int
    {
        $appointments = $this->getPending();
        $total = 0;
        foreach ($appointments as $appointment) {
            $total += $appointment->total / 2;
        }
        return $total;
    }
}
