<?php

namespace App\Services;

use App\Enums\ProfileUpdateType;
use App\Models\NiftyAvailability;
use App\Models\NiftyResource;
use Carbon\Carbon;
use Exception;
use Hash;
use Illuminate\Support\Facades\Log;

class NiftyProfileService
{
    private $niftyAssistantSvc;
    private $fileSvc;

    /**
     * NiftyProfileService constructor.
     * @param NiftyAssistantService $niftyAssistantSvc
     * @param FileService $fileSvc
     */
    public function __construct(
        NiftyAssistantService $niftyAssistantSvc,
        FileService $fileSvc
    ) {
        $this->niftyAssistantSvc = $niftyAssistantSvc;
        $this->fileSvc = $fileSvc;
    }

    public function update(int $id, array $data): void
    {
        $update_type = intval($data['update_type']);
        unset($data['update_type']);

        foreach ($data as $key => $value) {
            if (!$value) {
                unset($data[$key]);
            }
        }

        if ($update_type === ProfileUpdateType::AVAILABILITY) {
            $this->updateAvailability($id, $data);
        }

        if ($update_type === ProfileUpdateType::NORMAL) {
            if (array_key_exists('password', $data)) {
                $data['password'] = Hash::make($data['password']);
            }
            $this->niftyAssistantSvc->update($id, $data);
        }
        flash('Profile Updated!')->success();
    }

    private function updateAvailability(int $id, array $data)
    {
        $added_ids = [];
        for ($day = 0; $day <= 6; $day++) {
            if (array_key_exists('day_'.$day, $data)) {
                foreach ($data['day_'.$day.'_start_time'] as $i => $start_time) {
                    $times_array = [];
                    $times_array['from_time'] = $start_time;
                    $times_array['to_time'] = $data['day_'.$day.'_end_time'][$i];

                    $diff_in_minutes = Carbon::parse($times_array['from_time'])->diffInMinutes($times_array['to_time']);
                    if ($diff_in_minutes < 60) {
                        flash('Minimum Time Difference should be 1 hour')->error();
                        return;
                    }

                    $times_array['day'] = days_array()[$day];
                    $times_array['nifty_assistant_id'] = $id;
                    $availability = NiftyAvailability::create($times_array);
                    $added_ids[] = $availability->id;
                }
            }
        }
        $this->niftyAssistantSvc->get($id, false)->availability->whereNotIn('id', $added_ids)->each->delete();
    }
}
