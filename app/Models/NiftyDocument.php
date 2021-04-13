<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class NiftyFile
 * @mixin Eloquent
 */
class NiftyDocument extends Model
{
    use HasFactory;

    protected $guarded = [];
}
