<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Coupon
 * @mixin Eloquent
 */
class Coupon extends Model
{
    use HasFactory;

    protected $guarded = [];
}
