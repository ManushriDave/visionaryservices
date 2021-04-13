<?php

namespace App\Repositories\Interfaces;

use App\Models\NiftyService;
use Illuminate\Support\Collection;

interface NiftyServiceRepositoryInterface
{
    public function getNiftyServices($id): Collection;

    public function get($id): NiftyService;
}
