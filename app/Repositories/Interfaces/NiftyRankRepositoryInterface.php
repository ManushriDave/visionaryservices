<?php

namespace App\Repositories\Interfaces;

use App\Models\NiftyRank;
use Illuminate\Support\Collection;

interface NiftyRankRepositoryInterface
{
    public function getAll(): Collection;

    public function get($id): NiftyRank;
}
