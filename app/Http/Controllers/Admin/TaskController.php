<?php

namespace App\Http\Controllers\Admin;

use App\Contracts\Controller;
use App\Services\AssistantTypeService;
use App\Services\TaskService;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    private $taskSvc;
    private $assistantTypeSvc;

    /**
     * TaskController constructor.
     *
     * @param AssistantTypeService $assistantTypeSvc
     * @param TaskService $taskSvc
     */
    public function __construct(
        AssistantTypeService $assistantTypeSvc,
        TaskService $taskSvc
    ) {
        $this->taskSvc = $taskSvc;
        $this->assistantTypeSvc = $assistantTypeSvc;
    }

    public function index($id)
    {
        $tasks = $this->assistantTypeSvc->get($id)->tasks;
        $assistant_type = $this->assistantTypeSvc->get($id);
        return view('admin.tasks.index', [
            'tasks'          => $tasks,
            'assistant_type' => $assistant_type,
        ]);
    }

    public function create($id)
    {
        $assistant_type = $this->assistantTypeSvc->get($id);
        return view('admin.tasks.create', [
            'assistant_type'  => $assistant_type,
        ]);
    }

    public function edit($id)
    {
        $task = $this->taskSvc->get($id);
        return view('admin.tasks.edit', [
            'task' => $task,
        ]);
    }

    public function update($id, Request $request)
    {
        $task = $this->taskSvc->update($id, $request->except('_token', '_method'));
        if (!$task) {
            flash('Something went wrong!')->error();
        } else {
            flash('Task Edited Successfully!')->success();
        }
        return redirect(route('admin.tasks.index', $request->input('assistant_type_id')));
    }

    public function store(Request $request)
    {
        $store = $this->taskSvc->storeTask($request->except('_token'));

        if (!$store) {
            flash('Something went wrong!')->error();
            return redirect()->back();
        }

        return redirect(route('admin.tasks.index', $request->input('assistant_type_id')));
    }

    public function destroy($id)
    {
        $delete = $this->taskSvc->delete($id);
        if (!$delete) {
            flash('An Appointment is associated with this Task')->error();
        }
        return redirect()->back();
    }
}
