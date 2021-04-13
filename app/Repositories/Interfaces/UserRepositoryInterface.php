<?php

namespace App\Repositories\Interfaces;

use App\Models\User;

interface UserRepositoryInterface
{
    public function get(int $user_id): User;

    public function getClients();

    public function getAdmins();

    public function getPendingBookings(int $user_id);

    public function getOnGoingTasks(int $user_id);

    public function getAllBookings(int $user_id);

    public function getInvoices(int $user_id);

    public function getPayments(int $user_id);
}
