<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NiftyInterview extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function getDateAttribute($value): string
    {
        return Carbon::parse($value)->format('l d F Y - H:i');
    }

    public function setDateAttribute($value)
    {
        $this->attributes['date'] = Carbon::createFromFormat('l d F Y - H:i', $value)->toDateTimeString();
    }
}
