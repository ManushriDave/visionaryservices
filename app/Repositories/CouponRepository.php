<?php

namespace App\Repositories;

use App\Models\Coupon;
use App\Repositories\Interfaces\CouponRepositoryInterface;
use Illuminate\Support\Collection;

class CouponRepository implements CouponRepositoryInterface
{
    public function getAll(): Collection
    {
        return Coupon::all();
    }

    public function create($data): void
    {
        Coupon::create($data);
    }

    public function get(int $id): Coupon
    {
        return Coupon::find($id);
    }
}
