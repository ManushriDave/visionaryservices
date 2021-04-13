<?php

namespace App\Services;

use App\Models\NiftyHomeData;
use App\Repositories\NiftyHomeDataRepository;
use Exception;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;

class NiftyHomeDataService
{
    private $niftyHomeDataRepo;

    /**
     * NiftyHomeDataService constructor.
     * @param $niftyHomeDataRepo
     */
    public function __construct(NiftyHomeDataRepository $niftyHomeDataRepo)
    {
        $this->niftyHomeDataRepo = $niftyHomeDataRepo;
    }

    public function getAll(): Collection
    {
        return $this->niftyHomeDataRepo->getAll();
    }

    public function get($id): NiftyHomeData
    {
        return $this->niftyHomeDataRepo->get($id);
    }

    public function update($id, array $data): bool
    {
        try {
            $this->get($id)->update($data);
            return true;
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return false;
        }
    }
}
