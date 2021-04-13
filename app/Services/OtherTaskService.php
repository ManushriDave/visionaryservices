<?php

namespace App\Services;

use App\Models\OtherTask;
use Exception;
use Log;

class OtherTaskService
{
    private $taskSvc;

    /**
     * OtherTaskService constructor.
     * @param $taskSvc
     */
    public function __construct(TaskService $taskSvc)
    {
        $this->taskSvc = $taskSvc;
    }

    public function update($id, $data)
    {
        $task = OtherTask::find($id);
        if (array_key_exists('approve', $data)) {
            $this->taskSvc->storeTask([
                'name'              => $task->task,
                'assistant_type_id' => $data['assistant_type_id'],
            ]);
            flash('Task Added!')->success();
        }
        try {
            $task->delete();
            flash('Task Deleted!')->success();
        } catch (Exception $e) {
            Log::error($e->getMessage());
            flash('Something Went Wrong!');
        }
    }
}
