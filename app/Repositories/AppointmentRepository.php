<?php

namespace App\Repositories;

use App\Models\Appointment;
use App\Repositories\Interfaces\AppointmentRepositoryInterface;
use Illuminate\Support\Collection;

class AppointmentRepository implements AppointmentRepositoryInterface
{
    public function getAll(): Collection
    {
        return Appointment::all();
    }

    public function get(int $id): Appointment
    {
        return Appointment::find($id);
    }

    public function getByStatus($status): Collection
    {
        return Appointment::where('status', $status)->get();
    }
}
