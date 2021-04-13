<?php

namespace App\Http\Controllers\Api;

use App\Contracts\Controller;
use App\Services\TaskService;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    private $taskSvc;

    /**
     * TaskController constructor.
     * @param $taskSvc
     */
    public function __construct(TaskService $taskSvc)
    {
        $this->taskSvc = $taskSvc;
    }

    public function index()
    {
        return $this->taskSvc->getAll();
    }
}
