<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class NiftyCalendar extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function nifty_assistant(): BelongsTo
    {
        return $this->belongsTo(NiftyAssistant::class);
    }
}
