<?php

namespace App\Http\Controllers\NiftyAssistant;

use App\Contracts\Controller;
use App\Services\AppointmentService;
use App\Services\NiftyAssistantService;
use Auth;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    private $appointmentSvc;
    private $niftyAssistantSvc;

    /**
     * TaskController constructor.
     * @param AppointmentService $appointmentSvc
     * @param NiftyAssistantService $niftyAssistantSvc
     */
    public function __construct(
        AppointmentService $appointmentSvc,
        NiftyAssistantService $niftyAssistantSvc
    ) {
        $this->appointmentSvc = $appointmentSvc;
        $this->niftyAssistantSvc = $niftyAssistantSvc;
    }

    public function index()
    {
        $tasks = $this->niftyAssistantSvc->getTasksByStatus(Auth::id());
        return view('niftyassistant.tasks.index', [
            'tasks' => $tasks,
        ]);
    }

    public function show($id)
    {
        $task = $this->appointmentSvc->get($id);
        return view('niftyassistant.tasks.show', [
            'task' => $task,
        ]);
    }

    public function update($id, Request $request)
    {
        if ($request->has('reject')) {
            $this->appointmentSvc->rejectAppointment($id);
            $message = 'Task Rejected!';
        } else {
            $this->appointmentSvc->acceptAppointment($id);
            $message = 'Task Accepted!';
        }
        flash($message)->success();
        return redirect(route('niftyassistant.tasks.index'));
    }
}
