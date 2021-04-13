<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Collection;

/**
 * Class AssistantType
 * @mixin Eloquent
 * @property mixed cost_per_hour
 * @property Collection tasks
 */
class AssistantType extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function tasks(): HasMany
    {
        return $this->hasMany('App\Models\Task');
    }

    public function gigs(): HasMany
    {
        return $this->hasMany(NiftyGig::class);
    }

    public function nifties($status = null, $services = false): Collection
    {
        $nifties = collect();
        foreach ($this->gigs as $gig) {
            $nifty = $gig->nifty;
            if ($services) {
                if ($nifty->services->count() > 0) {
                    continue;
                }
            }
            $nifties->push($nifty);
        }
        return $nifties->where('status', $status);
    }
}
