<?php

namespace App\Repositories;

use App\Models\NiftyGig;

class NiftyGigRepository
{
    public function getAll()
    {
        return NiftyGig::with('nifty')->get();
    }

    public function getWhere(array $array)
    {
        return NiftyGig::with(['nifty', 'assistant_type', 'resources'])->where($array)->get();
    }

    public function update(int $id, array $data): bool
    {
        return NiftyGig::find($id)->update($data);
    }

    public function get($gig_id)
    {
        return $this->getWhere(['id' => $gig_id])->first();
    }

    public function store(array $data)
    {
        return NiftyGig::create($data);
    }
}
