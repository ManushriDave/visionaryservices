<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * Class Appointment
 * @mixin    Eloquent
 * @property int user_id
 * @property int id
 * @property mixed created_at
 * @property BelongsTo user
 * @property mixed nifty_assistant
 * @property string date
 * @property array|mixed timeline
 * @property mixed appointment_tasks
 * @property mixed approx_duration
 * @property mixed nifty_service
 */
class Appointment extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'status'          => 'integer',
        'timeline'        => 'array',
        'approx_duration' => 'integer',
        'total'           => 'integer',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo('App\Models\User');
    }

    public function review(): hasOne
    {
        return $this->hasOne(Review::class);
    }

    public function appointment_tasks(): HasMany
    {
        return $this->hasMany('App\Models\AppointmentTask');
    }

    public function nifty_service(): BelongsTo
    {
        return $this->belongsTo('App\Models\NiftyService');
    }

    public function nifty_assistant()
    {
        return $this->nifty_service ? $this->nifty_service->nifty_assistant : null;
    }

    public function documents(): HasMany
    {
        return $this->hasMany(AppointmentDocument::class);
    }

    public function payment(): HasOne
    {
        return $this->hasOne('App\Models\Payment');
    }

    public function getTasks(): string
    {
        $string = '';
        $appointment_tasks = $this->appointment_tasks;
        foreach ($appointment_tasks as $appointment_task) {
            $string .= $appointment_task->task->name.', ';
        }
        return rtrim($string, ', ');
    }
}
