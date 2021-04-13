<?php

namespace App\Repositories;

use App\Enums\AppointmentStatus;
use App\Models\User;
use App\Repositories\Interfaces\UserRepositoryInterface;

class UserRepository implements UserRepositoryInterface
{
    public function get(int $user_id): User
    {
        return User::find($user_id);
    }

    public function getClients()
    {
        return User::where('is_admin', 0)->get();
    }

    public function getAdmins()
    {
        return User::where('is_admin', 1)->get();
    }

    private function sortBookings($bookings, $status)
    {
        foreach ($bookings as $i => $booking) {
            // Check if status passed is in array format.
            if (is_array($status)) {
                // Set Booking Not Found Count to 0.
                $counts = 0;
                foreach ($status as $si => $s) {
                    if ($booking->status !== $status[$si]) {
                        // Increase Booking Not Found Count to 1.
                        $counts += 1;
                    }
                }
                // Get Actual Length of status array.
                $actual_count = count($status);

                // Check if Actual count and not found count are equal.
                if ($counts === $actual_count) {
                    /* If yes, then remove it from bookings array because
                    they dont have any of the passed status. */
                    unset($bookings[$i]);
                }
            } else {
                if ($booking->status !== $status) {
                    unset($bookings[$i]);
                }
            }
        }
        return $bookings;
    }

    public function getPendingBookings(int $user_id)
    {
        $bookings = $this->get($user_id)->appointments;
        $status = [AppointmentStatus::PENDING, AppointmentStatus::ACCEPTED];
        return $this->sortBookings($bookings, $status);
    }

    public function getOnGoingTasks(int $user_id)
    {
        $bookings = $this->get($user_id)->appointments;

        $status = AppointmentStatus::ONGOING;

        return $this->sortBookings($bookings, $status);
    }

    public function getAllBookings(int $user_id)
    {
        return $this->get($user_id)->appointments;
    }

    public function getInvoices(int $user_id)
    {
        return $this->get($user_id)->invoices;
    }

    public function getPayments(int $user_id)
    {
        return $this->get($user_id)->payments();
    }
}
