<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class NiftySpeciality
 * @mixin Eloquent
 */
class NiftySpeciality extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function task(): BelongsTo
    {
        return $this->belongsTo('App\Models\Task');
    }

    public function nifty_assistant(): BelongsTo
    {
        return $this->belongsTo('App\Models\NiftyAssistant');
    }
}
