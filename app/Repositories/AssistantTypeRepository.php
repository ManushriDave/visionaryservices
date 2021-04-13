<?php

namespace App\Repositories;

use App\Enums\NiftyStatus;
use App\Models\AssistantType;
use App\Repositories\Interfaces\AssistantTypeRepositoryInterface;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

class AssistantTypeRepository implements AssistantTypeRepositoryInterface
{
    public function getAll(): Collection
    {
        return AssistantType::with(['tasks', 'gigs.nifty.services', 'gigs.resources'])->get();
    }

    public function getWhere(): Collection
    {
        return AssistantType::with(['tasks', 'gigs.nifty.services', 'gigs.resources'])
            ->whereHas('gigs.nifty', function (Builder $query) {
                return $query->where([
                    'status' => NiftyStatus::APPROVED,
                ]);
            })->get();
    }

    public function get($id)
    {
        return $this->getAll()->where('id', $id)->first();
    }
}
