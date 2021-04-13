<?php

namespace App\Http\Controllers\Admin;

use App\Contracts\Controller;
use App\Enums\NiftyStatus;
use App\Services\AssistantTypeService;
use App\Services\NiftyAssistantService;
use App\Services\TaskService;
use App\Services\AppointmentService;
use App\Services\UserService;
use Illuminate\Http\Request;

class AppointmentController extends Controller
{
    /**
     * @var AppointmentService
     */
    private $appointmentSvc;
    private $userSvc;
    private $taskSvc;
    private $assistantTypeSvc;
    private $niftyAssistantSvc;

    /**
     * @param AssistantTypeService $assistantTypeSvc
     * @param AppointmentService $appointmentSvc
     * @param TaskService $taskSvc
     * @param UserService $userSvc
     * @param NiftyAssistantService $niftyAssistantSvc
     */
    public function __construct(
        AssistantTypeService $assistantTypeSvc,
        AppointmentService $appointmentSvc,
        TaskService $taskSvc,
        UserService $userSvc,
        NiftyAssistantService $niftyAssistantSvc
    ) {
        $this->appointmentSvc = $appointmentSvc;
        $this->assistantTypeSvc = $assistantTypeSvc;
        $this->niftyAssistantSvc = $niftyAssistantSvc;
        $this->taskSvc = $taskSvc;
        $this->userSvc = $userSvc;
    }

    public function index()
    {
        $appointments = $this->appointmentSvc->getAll();
        return view('admin.appointments.index', [
            'appointments' => $appointments,
        ]);
    }

    public function create()
    {
        $assistant_types = $this->assistantTypeSvc->getAll();
        $tasks = $this->taskSvc->getAll();
        $users = $this->userSvc->getClients();
        return view('admin.appointments.create', [
            'assistant_types' => $assistant_types,
            'tasks'           => $tasks,
            'users'           => $users,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'integer',
            'task_id' => 'integer',
        ]);

        $store = $this->appointmentSvc->storeAppointment($request->except('_token'));

        if (!$store) {
            flash('Something went wrong!')->error();
            return redirect()->back();
        }

        return redirect(route('admin.appointments.index'));
    }

    public function show($id)
    {
        $appointment = $this->appointmentSvc->get($id);
        $nifty_assistants = $this->niftyAssistantSvc->getByStatus(NiftyStatus::APPROVED);
        return view('admin.appointments.show', [
            'appointment'      => $appointment,
            'nifty_assistants' => $nifty_assistants,
        ]);
    }

    public function update($id, Request $request)
    {
        $update = $this->appointmentSvc->update($id, $request->except('_token', '_method'));
        if ($update) {
            flash('Appointment Updated')->success();
        } else {
            flash('Appointment Update Failed!')->error();
        }
        return redirect()->back();
    }
}
