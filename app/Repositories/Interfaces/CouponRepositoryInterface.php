<?php

namespace App\Repositories\Interfaces;

use App\Models\Coupon;
use Illuminate\Support\Collection;

interface CouponRepositoryInterface
{
    public function getAll(): Collection;

    public function create($data): void;

    public function get(int $id): Coupon;
}
