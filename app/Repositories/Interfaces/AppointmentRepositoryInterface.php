<?php

namespace App\Repositories\Interfaces;

use App\Models\Appointment;
use Illuminate\Support\Collection;

interface AppointmentRepositoryInterface
{
    public function getAll(): Collection;

    public function get(int $id): Appointment;

    public function getByStatus($status): Collection;
}
