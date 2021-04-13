<?php

namespace App\Repositories;

use App\Models\NiftyHomeData;
use App\Repositories\Interfaces\NiftyHomeDataRepositoryInterface;
use Illuminate\Support\Collection;

class NiftyHomeDataRepository implements NiftyHomeDataRepositoryInterface
{
    public function getAll(): Collection
    {
        return NiftyHomeData::all();
    }

    public function get($id): NiftyHomeData
    {
        return NiftyHomeData::find($id);
    }
}
