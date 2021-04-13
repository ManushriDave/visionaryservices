<?php

namespace App\Services;

use App\Models\NiftyRank;
use App\Repositories\NiftyRankRepository;
use Exception;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;

class NiftyRankService
{
    private $niftyRankRepo;

    /**
     * NiftyRankService constructor.
     * @param $niftyRankRepo
     */
    public function __construct(NiftyRankRepository $niftyRankRepo)
    {
        $this->niftyRankRepo = $niftyRankRepo;
    }

    public function getAll(): Collection
    {
        return $this->niftyRankRepo->getAll();
    }

    public function get($id): NiftyRank
    {
        return $this->niftyRankRepo->get($id);
    }
    
    public function store(array $data): bool
    {
        try {
            NiftyRank::create($data);
            return true;
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return false;
        }
    }

    public function update($id, array $data): bool
    {
        try {
            $nifty_rank = $this->niftyRankRepo->get($id);
            $nifty_rank->update($data);
            return true;
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return false;
        }
    }
}
