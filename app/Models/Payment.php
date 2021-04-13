<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class Payment
 * @mixin Eloquent
 */
class Payment extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function appointment(): BelongsTo
    {
        return $this->belongsTo('App\Models\Appointment');
    }
}
