<?php

namespace App\Repositories;

use App\Enums\AppointmentStatus;
use App\Models\NiftyAssistant;
use App\Repositories\Interfaces\NiftyAssistantRepositoryInterface;
use Exception;
use Illuminate\Support\Collection;

/**
 * Class NiftyAssistantRepository
 * @package App\Repositories
 */
class NiftyAssistantRepository implements NiftyAssistantRepositoryInterface
{
    /**
     * @param $status
     * @return Collection
     */

    public function getByStatus($status): Collection
    {
        return NiftyAssistant::where('status', $status)->get();
    }

    public function getAll(): Collection
    {
        return NiftyAssistant::all();
    }

    public function get(int $id)/*: NiftyAssistant|bool*/
    {
        try {
            return NiftyAssistant::find($id);
        } catch (Exception $e) {
            return false;
        }
    }

    public function checkIfExists(String $email): bool
    {
        if (NiftyAssistant::where('email', $email)->exists()) {
            return true;
        }
        return false;
    }

    /**
     * Get Bookings of Nifty Assistant.
     *
     * @param int $id
     *
     * @return Collection
     */
    public function getAllTasks(int $id): Collection
    {
        return $this->get($id)->allTasks();
    }

    /**
     * Get Pending Tasks for Nifty Assistant
     *
     * @param int $id
     *
     * @return Collection
     */
    public function getPendingTasks(int $id): Collection
    {
        $tasks = $this->get($id)->allTasks();
        $status = AppointmentStatus::PENDING;
        return $tasks->where('status', $status);
    }

    /**
     * Get Completed Tasks of Nifty Assistant.
     *
     * @param int $id
     *
     * @return Collection
     */
    public function getCompletedTasks(int $id): Collection
    {
        $tasks = $this->get($id)->allTasks();
        $status = AppointmentStatus::COMPLETED;
        return $tasks->where('status', $status);
    }

    /**
     * Get Ongoing Tasks of Nifty Assistant.
     *
     * @param int $id
     *
     * @return Collection
     */
    public function getOnGoingTasks(int $id): Collection
    {
        $tasks = $this->get($id)->allTasks();

        $status = AppointmentStatus::ONGOING;

        return $tasks->where('status', $status);
    }

    /**
     * Get Accepted Tasks of Nifty Assistant.
     *
     * @param int $id
     *
     * @return Collection
     */
    public function getAcceptedTasks(int $id): Collection
    {
        $tasks = $this->get($id)->allTasks();

        $status = AppointmentStatus::ACCEPTED;

        return $tasks->where('status', $status);
    }

    public function getTasksByStatus(int $id, $status = null): Collection
    {
        $tasks = $this->get($id)->allTasks();
        if ($status) {
            return $tasks->where('status', $status);
        }
        return $tasks;
    }
}
