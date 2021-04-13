<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Class Task
 * @mixin Eloquent
 * @property mixed specialities
 */
class Task extends Model
{
    protected $guarded = [];

    use HasFactory;

    public function assistant_type(): BelongsTo
    {
        return $this->belongsTo('App\Models\AssistantType');
    }

    public function specialities(): HasMany
    {
        return $this->hasMany('App\Models\NiftySpeciality');
    }
}
