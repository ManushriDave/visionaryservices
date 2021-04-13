<?php

namespace App\Repositories\Interfaces;

use Illuminate\Support\Collection;

interface PaymentRepositoryInterface
{
    public function getAll($limit): Collection;

    public function get($id): Collection;
}
