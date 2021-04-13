<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class NiftyEmirate
 * @mixin Eloquent
 */
class NiftyEmirate extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function emirate(): BelongsTo
    {
        return $this->belongsTo('App\Models\Emirate');
    }
}
