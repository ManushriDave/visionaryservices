<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Class NiftyGig
 * @mixin Eloquent
 * @property mixed nifty
 * @property mixed assistant_type
 */
class NiftyGig extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $appends = ['services'];

    public function resources(): hasMany
    {
        return $this->hasMany(NiftyResource::class);
    }

    public function nifty(): BelongsTo
    {
        return $this->belongsTo(NiftyAssistant::class, 'nifty_assistant_id');
    }

    public function assistant_type(): BelongsTo
    {
        return $this->belongsTo(AssistantType::class, 'assistant_type_id');
    }

    public function getServicesAttribute()
    {
        return $this->nifty->services->where('assistant_type_id', $this->assistant_type->id);
    }
}
