<?php

namespace App\Repositories;

use App\Models\Payment;
use App\Repositories\Interfaces\PaymentRepositoryInterface;
use Illuminate\Support\Collection;

class PaymentRepository implements PaymentRepositoryInterface
{
    public function getAll($limit): Collection
    {
        if ($limit) {
            return Payment::take($limit)->get();
        }
        return Payment::all();
    }

    public function get($id): Collection
    {
        return Payment::find($id);
    }
}
