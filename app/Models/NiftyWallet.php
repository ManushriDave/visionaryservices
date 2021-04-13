<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class UserNiftyWallet
 * @mixin \Eloquent
 */
class NiftyWallet extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'transactions' => 'array'
    ];

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
}
