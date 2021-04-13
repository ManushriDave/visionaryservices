<?php

namespace App\Repositories;

use App\Models\NiftyInterview;
use Carbon\Carbon;

class NiftyInterviewRepository
{
    public function create(array $data)
    {
        return NiftyInterview::create($data);
    }

    public function find($id)
    {
        return NiftyInterview::find($id);
    }

    public function update(int $id, array $data)
    {
        return $this->find($id)->update($data);
    }
}
