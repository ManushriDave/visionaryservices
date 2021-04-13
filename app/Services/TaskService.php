<?php

namespace App\Services;

use App\Models\Task;
use App\Repositories\TaskRepository;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;

class TaskService
{
    /**
     * @var TaskRepository
     */
    private $taskRepo;

    /**
     * TaskService constructor.
     * @param TaskRepository $taskRepo
     */
    public function __construct(TaskRepository $taskRepo)
    {
        $this->taskRepo = $taskRepo;
    }

    public function getAll(): Collection
    {
        return $this->taskRepo->getAll();
    }

    public function storeTask(array $all): bool
    {
        try {
            Task::create($all);
            return true;
        } catch (QueryException $e) {
            Log::error($e->getMessage());
            return false;
        }
    }

    public function get($id): Task
    {
        return $this->taskRepo->get($id);
    }

    public function update($id, array $array): bool
    {
        try {
            $task = $this->get($id);
            $task->update($array);
            return true;
        } catch (QueryException $e) {
            Log::error($e->getMessage());
            return false;
        }
    }

    public function delete($id): bool
    {
        try {
            $this->get($id)->delete();
            return true;
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return false;
        }
    }
}
