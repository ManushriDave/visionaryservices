<?php

namespace App\Services;

use App\Models\PackageType;
use App\Repositories\PackageTypeRepository;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;

class PackageTypeService
{
    private $packageTypeRepo;

    /**
     * PackageTypeService constructor.
     * @param $packageTypeRepo
     */
    public function __construct(PackageTypeRepository $packageTypeRepo)
    {
        $this->packageTypeRepo = $packageTypeRepo;
    }

    public function getAll(): Collection
    {
        return $this->packageTypeRepo->getAll();
    }

    public function get(int $id)
    {
        return $this->packageTypeRepo->get($id);
    }

    public function store(array $array): bool
    {
        try {
            PackageType::create($array);
            return true;
        } catch (QueryException $e) {
            Log::error($e->getMessage());
            return false;
        }
    }

    public function update(array $array, int $id)
    {
        try {
            $package = $this->get($id);
            $package->update($array);
            return true;
        } catch (QueryException $e) {
            Log::error($e->getMessage());
            return false;
        }
    }

    public function destroy(int $id)
    {
        try {
            $package = $this->get($id);
            $package->delete();
            return true;
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return false;
        }
    }
}
