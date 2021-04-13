<?php

namespace App\Repositories\Interfaces;

use Illuminate\Support\Collection;

/**
 * Class NiftyAssistantRepository
 * @package App\Repositories
 */
interface NiftyAssistantRepositoryInterface
{
    /**
     * @param $status
     * @return Collection
     */
    public function getByStatus($status): Collection;

    public function getAll(): Collection;

    public function get(int $id);

    public function checkIfExists(string $email): bool;

    /**
     * Get Bookings by Status of Nifty Assistant.
     *
     * @param int $id
     * @param int $status
     *
     * @return Collection
     */
    public function getTasksByStatus(int $id, int $status): Collection;

    /**
     * Get Bookings of Nifty Assistant.
     *
     * @param int $id
     *
     * @return Collection
     */
    public function getAllTasks(int $id): Collection;

    /**
     * Get Pending Tasks for Nifty Assistant
     *
     * @param int $id
     *
     * @return Collection
     */
    public function getPendingTasks(int $id): Collection;

    /**
     * Get Completed Tasks of Nifty Assistant.
     *
     * @param int $id
     *
     * @return Collection
     */
    public function getCompletedTasks(int $id): Collection;

    /**
     * Get Ongoing Tasks of Nifty Assistant.
     *
     * @param int $id
     *
     * @return Collection
     */
    public function getOnGoingTasks(int $id): Collection;

    /**
     * Get Accepted Tasks of Nifty Assistant.
     *
     * @param int $id
     *
     * @return Collection
     */
    public function getAcceptedTasks(int $id): Collection;
}
