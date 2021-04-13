<?php

namespace App\Services;

use App\Enums\NotificationType;
use App\Notifications\AppointmentPlaced;
use App\Repositories\UserRepository;
use Exception;
use Illuminate\Support\Facades\Log;

class NotificationService
{
    private $userRepo;

    /**
     * NotificationService constructor.
     * @param $userRepo
     */
    public function __construct(UserRepository $userRepo)
    {
        $this->userRepo = $userRepo;
    }

    public function notifyAdmin($type, $model)
    {
        try {
            $admins = $this->userRepo->getAdmins();
            foreach ($admins as $admin) {
                if ($type === NotificationType::AppointmentPlaced) {
                    $admin->notify(new AppointmentPlaced($model));
                }
            }
            return true;
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return false;
        }
    }
}
