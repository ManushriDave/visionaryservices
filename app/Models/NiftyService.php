<?php

namespace App\Models;

use App\Enums\Currency;
use Eloquent;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Class NiftyService
 * @mixin Eloquent
 */
class NiftyService extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $appends = ['cost_string'];

    public function tasks(): HasMany
    {
        return $this->hasMany('App\Models\Appointment');
    }

    public function nifty_assistant(): BelongsTo
    {
        return $this->belongsTo('App\Models\NiftyAssistant');
    }

    public function assistant_type(): BelongsTo
    {
        return $this->belongsTo('App\Models\AssistantType');
    }

    public function getCostStringAttribute(): string
    {
        return $this->cost . ' ' . Currency::default . ' / ' . $this->unit;
    }
}
