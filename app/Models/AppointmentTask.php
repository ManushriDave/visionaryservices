<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class AppointmentTask
 * @mixin Eloquent
 * @property mixed task
 */
class AppointmentTask extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function appointment(): BelongsTo
    {
        return $this->belongsTo('App\Models\Appointment');
    }

    public function task(): BelongsTo
    {
        return $this->belongsTo('App\Models\Task');
    }
}
