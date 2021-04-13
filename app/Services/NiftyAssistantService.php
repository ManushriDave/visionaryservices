<?php

namespace App\Services;

use App\Enums\AppointmentStatus;
use App\Enums\Currency;
use App\Enums\Gender;
use App\Enums\NiftyStatus;
use App\Mail\ContactMail;
use App\Mail\NiftyAssistantApproved;
use App\Mail\NiftyRegistered;
use App\Mail\NiftyRejected;
use App\Mail\NiftyOnHold;
use App\Models\AssistantType;
use App\Models\NiftyAgreement;
use App\Models\NiftyAssistant;
use App\Models\NiftyDocument;
use App\Models\NiftyEmirate;
use App\Models\NiftyGig;
use App\Models\NiftyPrivate;
use App\Models\NiftySpeciality;
use App\Models\OtherTask;
use App\Repositories\Interfaces\AppointmentRepositoryInterface;
use App\Repositories\Interfaces\NiftyAssistantRepositoryInterface;
use App\Repositories\Interfaces\TaskRepositoryInterface;
use Carbon\Carbon;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class NiftyAssistantService
{
    /**
     * @var NiftyAssistantRepositoryInterface
     */
    private NiftyAssistantRepositoryInterface $niftyAssistantRepo;
    private AppointmentRepositoryInterface $appointmentsRepo;
    private TaskRepositoryInterface $taskRepo;

    /**
     * NiftyAssistantService constructor.
     * @param AppointmentRepositoryInterface $appointmentsRepo
     * @param NiftyAssistantRepositoryInterface $niftyAssistantRepo
     * @param TaskRepositoryInterface $taskRepo
     */
    public function __construct(
        AppointmentRepositoryInterface $appointmentsRepo,
        NiftyAssistantRepositoryInterface $niftyAssistantRepo,
        TaskRepositoryInterface $taskRepo
    ) {
        $this->niftyAssistantRepo = $niftyAssistantRepo;
        $this->taskRepo = $taskRepo;
        $this->appointmentsRepo = $appointmentsRepo;
    }

    public function getByStatus($status): Collection
    {
        return $this->niftyAssistantRepo->getByStatus($status);
    }

    public function getAll(): Collection
    {
        return $this->niftyAssistantRepo->getAll();
    }

    public function getTasksByStatus($id, $status = null): Collection
    {
        return $this->niftyAssistantRepo->getTasksByStatus($id, $status);
    }

    public function getEarnedAmount($id): float
    {
        $nifty_assistant = $this->get($id);
        $tasks = $nifty_assistant->allTasks();
        $total = 0;
        foreach ($tasks as $task) {
            $task_total = $task->payment->total;
            $total += $task_total - ($nifty_assistant->rank->commission * $task_total / 100);
        }
        return round($total, 2);
    }

    public function getTimeline(): array
    {
        $timeline = [];
        $nifty_assistants = $this->getAll();
        foreach ($nifty_assistants as $nifty_assistant) {
            $string = 'A Nifty Assistant was approved : '.$nifty_assistant->first_name.' '.$nifty_assistant->last_name;
            array_push($timeline, [
                'created_at' => $nifty_assistant->created_at,
                'string'     => $string,
                'link'       => route('admin.nifty_assistants.show', $nifty_assistant->id),
            ]);
        }
        return $timeline;
    }

    public function store(array $request_data): bool
    {
        try {
            $request_data['dob'] = Carbon::createFromFormat('m/d/Y', $request_data['dob'])->format('Y-m-d');

            if (array_key_exists('other_tasks', $request_data)) {
                $other_tasks = $request_data['other_tasks'];
                unset($request_data['other_tasks']);
            }

            $speciality_tasks = $request_data['speciality_tasks'];
            unset($request_data['speciality_tasks']);

            $nifty_emirates = [];

            if (array_key_exists('nifty_emirates', $request_data)) {
                $nifty_emirates = $request_data['nifty_emirates'];
                unset($request_data['nifty_emirates']);
            }

            $known_languages = '';
            foreach ($request_data['known_languages'] as $language) {
                $known_languages .= $language.', ';
            }
            $request_data['known_languages'] = rtrim($known_languages, ', ');

            $nifty_private = [];

            foreach ($request_data as $key => $value) {
                if (strpos($key, 'private_') > -1) {
                    $exp_key = explode('_', $key);
                    if ($exp_key[0] == 'private') {
                        $nifty_private[str_replace('private_', '', $key)] = $value;
                        unset($request_data[$key]);
                    }
                }
            }

            if (array_key_exists('assistant_type_ids', $request_data)) {
                $assistant_type_ids = $request_data['assistant_type_ids'];
                unset($request_data['assistant_type_ids']);
            }

            $nifty_assistant = NiftyAssistant::create($request_data);

            if (count($nifty_private) > 0) {
                $nifty_private['nifty_assistant_id'] = $nifty_assistant->id;
                NiftyPrivate::create($nifty_private);
            }

            if (isset($other_tasks)) {
                $other_tasks_array = explode(',', $other_tasks);
                if (is_array($other_tasks_array)) {
                    foreach (explode(',', $other_tasks) as $task) {
                        OtherTask::create([
                            'task'               => $task,
                            'nifty_assistant_id' => $nifty_assistant->id,
                        ]);
                    }
                }
            }

            foreach ($speciality_tasks as $task) {
                if ($task === '0') {
                    continue;
                }
                NiftySpeciality::create([
                    'nifty_assistant_id' => $nifty_assistant->id,
                    'task_id'            => $task,
                ]);
            }

            if (count($nifty_emirates) > 0) {
                foreach ($nifty_emirates as $nifty_emirate) {
                    NiftyEmirate::create([
                        'emirate_id'         => $nifty_emirate,
                        'nifty_assistant_id' => $nifty_assistant->id,
                    ]);
                }
            }

            if (isset($assistant_type_ids)) {
                foreach ($assistant_type_ids as $assistant_type_id) {
                    NiftyGig::create([
                        'nifty_assistant_id' => $nifty_assistant->id,
                        'assistant_type_id'  => $assistant_type_id,
                    ]);
                }
            }

            // Mail::to($request_data['email'])
            //     ->send(new NiftyRegistered($nifty_assistant));

            // foreach (config('mail.contact') as $email) {
            //     $data['name'] = 'Visionary Services System';
            //     $data['email'] = $request_data['email'];
            //     $data['subject'] = 'New Nifty Registered!';
            //     $data['message'] = 'A new Nifty has registered. Check from admin panel';
            //     Mail::to($email)->send(new ContactMail($data));
            // }

            return true;
        } catch (QueryException $e) {
            Log::error($e->getMessage());
            return false;
        }
    }

    public function approveAssistant(int $id): bool
    {
        $nifty_assistant = $this->get($id, false);

        // Generate Password for Approved Assistant
        $password = Str::random(8);

        $nifty_assistant->update([
            'status'   => NiftyStatus::APPROVED,
            'password' => Hash::make($password),
        ]);

        flash('Password for this account is : '.$password)->info();

        return true;
    }

    public function rejectAssistant(int $id, string $reason): bool
    {
        try {
            $nifty_assistant = $this->get($id, false);
            // $nifty_assistant->delete();

            $nifty_assistant->update([
                'status' => NiftyStatus::REJECTED,
            ]);
            Mail::to($nifty_assistant->email)
                ->send(new NiftyRejected($reason));

            return true;
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return false;
        }
    }

    public function holdAssistant(int $id, string $reason): bool
    {
        $nifty_assistant = $this->get($id, false);

        $nifty_assistant->update([
            'status' => NiftyStatus::ON_HOLD,
        ]);

        Mail::to($nifty_assistant->email)
            ->send(new NiftyOnHold($reason));

        return true;
    }

    public function get(int $id, bool $sort = true)
    {
        $nifty = $this->niftyAssistantRepo->get($id);
        if (!$sort) {
            return $nifty;
        }
        return $this->sortNifty($nifty);
    }

    public function checkIfExists(String $email): bool
    {
        return $this->niftyAssistantRepo->checkIfExists($email);
    }

    public function update($id, array $data): bool
    {
        if (count($data) > 0) {
            $nifty_assistant = $this->get($id, false);
            if (array_key_exists('nifty_specialities', $data)) {
                $processed = [];
                foreach ($data['nifty_specialities'] as $speciality) {
                    if (!in_array((int) $speciality, $nifty_assistant->specialities_array(), true)) {
                        NiftySpeciality::create([
                            'nifty_assistant_id' => $nifty_assistant->id,
                            'task_id'            => AssistantType::find($speciality)->tasks->first()->id,
                        ]);
                    }
                    $processed[] = (int) $speciality;
                }

                foreach ($nifty_assistant->specialities_array() as $speciality) {
                    if (!in_array($speciality, $processed, true)) {
                        foreach (AssistantType::find($speciality)->tasks as $task) {
                            try {
                                NiftySpeciality::where([
                                    ['task_id', $task->id],
                                    ['nifty_assistant_id', $id],
                                ])->delete();
                            } catch (Exception $e) {
                                Log::error($e->getMessage());
                                return false;
                            }
                        }
                    }
                }
                unset($data['nifty_specialities']);
            }
            $nifty_assistant->update($data);
        }
        return true;
    }

    public function getGenderGraph(): array
    {
        $nifty_assistants = $this->getAll();
        $males = 0;
        $females = 0;
        foreach ($nifty_assistants as $nifty_assistant) {
            if ($nifty_assistant->gender == Gender::Male) {
                $males += 1;
            } else {
                $females += 1;
            }
        }
        return [[
            'label' => 'Men',
            'value' => $males,
        ], [
            'label' => 'Women',
            'value' => $females,
        ]];
    }

    public function getNationalityGraph(): array
    {
        $nifty_assistants = $this->getAll();
        $data = [];
        $labels = [];
        $values = [];
        foreach ($nifty_assistants as $nifty_assistant) {
            if (in_array($nifty_assistant->nationality, $labels, true)) {
                $key = array_search($nifty_assistant->nationality, $labels, true);
                $values[$key] += 1;
            } else {
                $labels[] = $nifty_assistant->nationality;
                $values[] = 1;
            }
        }
        for ($i = 0; $i < count($labels); $i++) {
            $data[] = [
                'label' => $labels[$i],
                'value' => $values[$i],
            ];
        }
        return $data;
    }

    public function getAgeGraph(): array
    {
        $nifty_assistants = $this->getAll();
        $data = [];
        $labels = [];
        $values = [];
        foreach ($nifty_assistants as $nifty_assistant) {
            $age = Carbon::parse($nifty_assistant->dob)->age;
            if (in_array($age, $labels, true)) {
                $key = array_search($age, $labels, true);
                $values[$key] += 1;
            } else {
                $labels[] = $age;
                $values[] = 1;
            }
        }
        for ($i = 0; $i < count($labels); $i++) {
            $data[] = [
                'label' => $labels[$i].' years',
                'value' => $values[$i],
            ];
        }
        return $data;
    }

    public function getNiftySkillsGraph(): array
    {
        $nifty_assistants = $this->getAll();
        $data = [];
        $labels = [];
        $values = [];
        foreach ($nifty_assistants as $nifty_assistant) {
            $specialities = $nifty_assistant->specialities;
            foreach ($specialities as $speciality) {
                if ($speciality->task) {
                    $label = $speciality->task->name;
                    if (in_array($label, $labels, true)) {
                        $key = array_search($label, $labels, true);
                        $values[$key] += 1;
                    } else {
                        $labels[] = $label;
                        $values[] = 1;
                    }
                }
            }
        }
        for ($i = 0; $i < count($labels); $i++) {
            $data[] = [
                'label' => $labels[$i],
                'value' => $values[$i],
            ];
        }
        return $data;
    }

    public function topNifty()
    {
        $appointments = $this->appointmentsRepo->getAll();

        if ($appointments->count() > 0) {
            $nifty_revenues = $this->getNiftiesRevenues($appointments);

            $nifty_assistant_ids = $nifty_revenues[0];
            $nifty_assistant_revenues = $nifty_revenues[1];

            if (count($nifty_assistant_ids) > 1) {
                $maximum_revenue = max($nifty_assistant_revenues);
                $maximum_revenue_key = array_search($maximum_revenue, $nifty_assistant_revenues, true);

                $selected_nifty_assistant = $nifty_assistant_ids[$maximum_revenue_key];

                return $this->get($selected_nifty_assistant);
            }
            return null;
        } else {
            return null;
        }
    }

    public function getTopNifties($limit = null): Collection
    {
        $appointments = $this->appointmentsRepo->getAll();

        $selected_nifty_assistants = collect([]);

        $nifty_revenues = $this->getNiftiesRevenues($appointments);

        $nifty_assistant_ids = $nifty_revenues[0];
        $nifty_assistant_revenues = $nifty_revenues[1];

        if (count($nifty_assistant_ids) > 1) {
            if ((!$limit) || (count($nifty_assistant_ids) < $limit)) {
                $limit = count($nifty_assistant_ids);
            }

            for ($i = 1; $i < $limit; $i++) {
                $maximum_revenue = max($nifty_assistant_revenues);

                $maximum_revenue_key = array_search($maximum_revenue, $nifty_assistant_revenues, true);

                $nifty_assistant_id = $nifty_assistant_ids[$maximum_revenue_key];

                $selected_nifty_assistants->push($this->get($nifty_assistant_id));

                unset($nifty_assistant_ids[$maximum_revenue_key]);
                unset($nifty_assistant_revenues[$maximum_revenue_key]);
            }
        }
        return $selected_nifty_assistants;
    }

    public function getBottomNifties($limit = null): Collection
    {
        $appointments = $this->appointmentsRepo->getAll();

        $selected_nifty_assistants = collect([]);

        $nifty_revenues = $this->getNiftiesRevenues($appointments);

        $nifty_assistant_ids = $nifty_revenues[0];
        $nifty_assistant_revenues = $nifty_revenues[1];

        if (count($nifty_assistant_ids) > 1) {
            if ((!$limit) || (count($nifty_assistant_ids) < $limit)) {
                $limit = count($nifty_assistant_ids);
            }

            for ($i = 0; $i < $limit; $i++) {
                $maximum_revenue = min($nifty_assistant_revenues);

                $maximum_revenue_key = array_search($maximum_revenue, $nifty_assistant_revenues, true);

                $nifty_assistant = $nifty_assistant_ids[$maximum_revenue_key];

                $selected_nifty_assistants->push($this->get($nifty_assistant));

                unset($nifty_assistant_ids[$maximum_revenue_key]);
                unset($nifty_assistant_revenues[$maximum_revenue_key]);
            }
        }
        return $selected_nifty_assistants;
    }

    private function getNiftiesRevenues(Collection $appointments): array
    {
        $nifty_assistant_ids = [];
        $nifty_assistant_revenues = [];

        foreach ($appointments as $appointment) {
            if ($appointment->payment) {
                $nifty_commission = $appointment->payment->nifty_commission;
                $nifty_assistant_id = $appointment->nifty_assistant_id;

                if (in_array($nifty_assistant_id, $nifty_assistant_ids, true)) {
                    $key = array_search($nifty_assistant_id, $nifty_assistant_ids, true);
                    $nifty_assistant_revenues[$key] += $nifty_commission;
                } else {
                    $nifty_assistant_ids[] = $nifty_assistant_id;
                    $nifty_assistant_revenues[] = $nifty_commission;
                }
            }
        }

        return [
            $nifty_assistant_ids,
            $nifty_assistant_revenues
        ];
    }

    public function search(array $data): array
    {
        $task_ids = $data['task_ids'];

        $nifty_assistants = collect();

        foreach ($task_ids as $task_id) {
            $specialities = $this->taskRepo->get($task_id)->specialities;
            foreach ($specialities as $speciality) {
                $nifty = $speciality->nifty_assistant;
                if (
                    !$nifty_assistants->contains('id', $nifty->id)
                    && $nifty->status == NiftyStatus::APPROVED
                    && $nifty->services->count() > 0
                ) {
                    $nifty_assistants->push($nifty);
                }
            }
        }

        // Get Available Nifty Assistants
        $available_assistants = [];

        foreach ($nifty_assistants as $nifty_assistant) {
            array_push($available_assistants, $this->sortNifty($nifty_assistant));
        }

        return $available_assistants;
    }

    public function sortNifty($nifty_assistant)
    {
        $services = $nifty_assistant->services;
        foreach ($services as $service) {
            $service['cost_string'] = $service->cost . ' ' . Currency::default . ' / ' . $service->unit;
            $service['cost'] = $service->cost;
            $service['unit'] = $service->unit;
        }
        $nifty_assistant['services'] = $services;
        return $nifty_assistant;
    }

    public function check(array $data): bool
    {
        $approx_duration = $data['approx_duration'];

        // Get Date & Time of Appointment

        $date = $data['date'];
        $time = Carbon::parse($data['time'])->format('H:i');

        $task_start_time = intval(explode(':', $time)[0]);

        $task_end_time = $task_start_time + $approx_duration;

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
            'Saturday',
        ];

        // Get Day Index for the Appointment Day
        $index = array_search($day, $days, true);

        $continue = true;

        $nifty_assistant = $this->get($data['id']);

        // Decode JSON data from DB
        $availability_days = json_decode($nifty_assistant->availability, true);

        if (!array_key_exists($index, $availability_days)) {
            $continue = false;
        }

        if ($continue) {
            $periods = $availability_days[$index];

            // Check if Assistant works on that day.
            if (count($periods) > 0) {
                // Get Start Time & End Time of Nifty Assistant Duty
                $start_time = $periods[0];
                $end_time = $periods[count($periods) - 1];

                if ($start_time <= $task_start_time && $end_time >= $task_end_time) {

                    // Check if Nifty has at least one service.
                    if ($nifty_assistant->services->count() < 1) {
                        $continue = false;
                    }

                    if ($continue) {
                        // Now check if Nifty has some other task?
                        $nifty_tasks = $this->getTasksByStatus($nifty_assistant->id, AppointmentStatus::PENDING);
                        if ($nifty_tasks->count() > 0) {
                            foreach ($nifty_tasks as $nifty_task) {
                                if (Carbon::parse($nifty_task->date) === Carbon::parse($date)) {
                                    if ($nifty_task->time >= $task_start_time && $nifty_task->time <= $task_end_time) {
                                        $continue = false;
                                    }
                                }
                            }
                        }
                        // If appointment time is between start time and end time of assistant, push it to array.
                        if ($continue) {
                            return true;
                        }
                    }
                }
            }
        }
        return false;
    }

    public function signAgreement(array $data): void
    {
        $signature = str_replace('data:image/png;base64,', '', $data['signature']);
        $signature = str_replace(' ', '+', $signature);
        $imageName = Str::random(10) . '.png';
        $store = Storage::put('nifty_signatures/'.$imageName, base64_decode($signature, true));
        if ($store) {
            $data['signature'] = 'nifty_signatures/'.$imageName;
            $data['nifty_assistant_id'] = \Auth::id();
            NiftyAgreement::create($data);
        }
    }

    public function signatures(): Collection
    {
        return NiftyAgreement::all();
    }

    public function getSignature($id)
    {
        return NiftyAgreement::find($id);
    }

    public function deleteNifty($id)
    {
        try {
            $this->niftyAssistantRepo->get($id)->delete();
            flash('Nifty Deleted Successfully!')->success();
        } catch (Exception $e) {
            Log::error($e->getMessage());
            flash('Nifty Deletion Failed!')->error();
        }
    }
}
