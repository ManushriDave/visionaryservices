<?php

namespace App\Repositories;

use App\Models\Emirate;
use App\Repositories\Interfaces\EmirateRepositoryInterface;

class EmirateRepository implements EmirateRepositoryInterface
{
    public function getAll()
    {
        return Emirate::all();
    }
}
