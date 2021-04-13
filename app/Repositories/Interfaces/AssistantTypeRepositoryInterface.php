<?php

namespace App\Repositories\Interfaces;

use App\Models\AssistantType;
use Illuminate\Support\Collection;

interface AssistantTypeRepositoryInterface
{
    public function getAll(): Collection;

    public function getWhere(): Collection;

    public function get(int $id);
}
