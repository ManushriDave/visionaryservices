<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class NiftyHomeData
 * @mixin \Eloquent
 */
class NiftyHomeData extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function assistant_type()
    {
        return $this->belongsTo('App\Models\AssistantType');
    }
}
