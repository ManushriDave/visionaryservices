<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Storage;

/**
 * Class NiftyResource
 * @mixin Eloquent
 */
class NiftyResource extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function getFileAttribute($value): string
    {
        return config('app.url').Storage::url($value);
    }
}
