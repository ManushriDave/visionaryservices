<?php

namespace App\Repositories;

use App\Models\NiftyService;
use App\Repositories\Interfaces\NiftyServiceRepositoryInterface;
use Illuminate\Support\Collection;

class NiftyServiceRepository implements NiftyServiceRepositoryInterface
{
    public function getNiftyServices($id): Collection
    {
        return NiftyService::where('nifty_assistant_id', $id)->get();
    }

    public function get($id): NiftyService
    {
        return NiftyService::find($id);
    }
}
