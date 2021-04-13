<?php

namespace App\Http\Controllers\Frontend;

use App\Contracts\Controller;
use App\Enums\Updater;
use App\Services\AppointmentService;
use App\Services\AssistantTypeService;
use App\Services\EmirateService;
use App\Services\FileService;
use App\Services\TaskService;
use App\Services\UserService;
use Auth;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class BookingController extends Controller
{
    private $appointmentSvc;
    private $userSvc;
    private $taskSvc;
    private $assistantTypeSvc;
    private $fileSvc;
    private $emirateSvc;

    /**
     * BookingController constructor.
     * @param AppointmentService $appointmentSvc
     * @param AssistantTypeService $assistantTypeSvc
     * @param TaskService $taskSvc
     * @param UserService $userSvc
     * @param FileService $fileSvc
     * @param EmirateService $emirateSvc
     */
    public function __construct(
        AppointmentService $appointmentSvc,
        AssistantTypeService $assistantTypeSvc,
        TaskService $taskSvc,
        UserService $userSvc,
        FileService $fileSvc,
        EmirateService $emirateSvc
    ) {
        $this->appointmentSvc = $appointmentSvc;
        $this->assistantTypeSvc = $assistantTypeSvc;
        $this->taskSvc = $taskSvc;
        $this->userSvc = $userSvc;
        $this->fileSvc = $fileSvc;
        $this->emirateSvc = $emirateSvc;
    }

    public function index()
    {
        $user_id = Auth::id();
        $bookings = $this->userSvc->getAllBookings($user_id);
        return view('frontend.bookings.index', [
            'bookings' => $bookings,
        ]);
    }

    public function show($id)
    {
        $booking = $this->appointmentSvc->get($id);
        if ($booking->user_id != Auth::id()) {
            return redirect(route('frontend.bookings.index'));
        }
        return view('frontend.bookings.show', [
            'booking' => $booking,
        ]);
    }

    public function edit($id)
    {
        $booking = $this->appointmentSvc->get($id);
        $assistant_types = $this->assistantTypeSvc->getAll();
        $emirates = $this->emirateSvc->getAll();
        if ($booking->user_id != Auth::id()) {
            return redirect(route('frontend.bookings.index'));
        }
        return view('frontend.bookings.edit', [
            'booking'         => $booking,
            'assistant_types' => $assistant_types,
            'emirates'        => $emirates,
        ]);
    }

    public function update($id, Request $request)
    {
        $data = $request->except('_token', '_method');

        $data['status'] = 0;

        if ($request->has('action')) {
            if ($request->input('action') === Updater::rejectNiftyAssistant) {
                $data['timeline'] = 'Client Rejected Nifty Assistant!';
                $data['nifty_assistant_id'] = null;
            } else {
                $data['timeline'] = 'Client Accepted Nifty Assistant!';
            }
            unset($data['action']);
        } else {
            $data['timeline'] = 'Client Updated Task!';
        }

        if ($request->hasFile('document_files')) {
            $documents = [];
            foreach ($request->file('document_files') as $i => $file) {
                $path = $this->fileSvc->uploadFile($file, 'appointment_documents');
                array_push($documents, [
                    'name' => 'Document - '.$i,
                    'path' => $path,
                ]);
            }
            $data['documents'] = $documents;
            unset($data['document_files']);
        }

        $update = $this->appointmentSvc->update($id, $data);

        if ($update) {
            flash('Booking Updated')->success();
        } else {
            flash('Booking Update Failed!')->error();
        }
        return redirect()->back();
    }

    public function create()
    {
        $tasks = $this->taskSvc->getAll();
        $assistant_types = $this->assistantTypeSvc->getAll();
        $emirates = $this->emirateSvc->getAll();

        return view('frontend.bookings.create', [
            'tasks'           => $tasks,
            'assistant_types' => $assistant_types,
            'emirates'        => $emirates,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'task_ids' => 'array',
        ]);

        $data = $request->except('_token');
        $data['user_id'] = Auth::id();

        if ($request->hasFile('document_files')) {
            $documents = [];
            foreach ($request->file('document_files') as $i => $file) {
                $path = $this->fileSvc->uploadFile($file, 'appointment_documents');
                array_push($documents, [
                    'name' => 'Document - '.$i,
                    'path' => $path,
                ]);
            }
            $data['documents'] = $documents;
            unset($data['document_files']);
        }

        $store = $this->appointmentSvc->storeAppointment($data);

        if (!$store) {
            flash('Something went wrong!')->error();
            return redirect()->back();
        }
        flash('Booking Successful!')->success();

        return redirect(route('frontend.bookings.index'));
    }

    public function download(Request $request): BinaryFileResponse
    {
        return $this->fileSvc->download($request->input('file'));
    }

    public function destroy($id)
    {
        $this->appointmentSvc->destroy($id);
        return redirect(route('frontend.bookings.index'));
    }
}
