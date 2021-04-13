<?php

namespace App\Services;

use App\Repositories\EmirateRepository;

class EmirateService
{
    /**
     * @var EmirateRepository
     */
    private EmirateRepository $emirateRepo;

    /**
     * LocationService constructor.
     * @param EmirateRepository $emirateRepo
     */
    public function __construct(EmirateRepository $emirateRepo)
    {
        $this->emirateRepo = $emirateRepo;
    }

    public function getAll()
    {
        return $this->emirateRepo->getAll();
    }

    public function getAppointmentsLocationsGraph(): array
    {
        $emirates = $this->getAll();
        $data = [];
        foreach ($emirates as $emirate) {
            $appointments = $emirate->appointments->count();
            $data[] = [
                'label' => $emirate->name,
                'value' => $appointments,
            ];
        }
        return $data;
    }
}
