<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Review
 * @mixin Eloquent
 * @property mixed rating
 */
class Review extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function positive(): int
    {
        return $this->rating >= 4;
    }

    public function negative(): int
    {
        return $this->rating < 4;
    }
}
