<?php

namespace App\Repositories;

use App\Models\NiftyRank;
use App\Repositories\Interfaces\NiftyRankRepositoryInterface;
use Illuminate\Support\Collection;

class NiftyRankRepository implements NiftyRankRepositoryInterface
{
    public function getAll(): Collection
    {
        return NiftyRank::all();
    }

    public function get($id): NiftyRank
    {
        return NiftyRank::find($id);
    }
}
