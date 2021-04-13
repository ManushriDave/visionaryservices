<?php

namespace App\Repositories\Interfaces;

use App\Models\NiftyHomeData;
use Illuminate\Support\Collection;

interface NiftyHomeDataRepositoryInterface
{
    public function getAll(): Collection;

    public function get($id): NiftyHomeData;
}
