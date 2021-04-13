<?php

namespace App\Services;

use App\Models\NiftyService;
use App\Repositories\NiftyServiceRepository;
use Auth;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;

class NiftyServiceService
{
    private NiftyServiceRepository $niftyServiceRepo;
    private NiftyGigService $niftyGigSvc;

    /**
     * NiftyServiceService constructor.
     * @param NiftyGigService $niftyGigSvc
     * @param NiftyServiceRepository $niftyServiceRepo
     */
    public function __construct(NiftyGigService $niftyGigSvc, NiftyServiceRepository $niftyServiceRepo)
    {
        $this->niftyGigSvc = $niftyGigSvc;
        $this->niftyServiceRepo = $niftyServiceRepo;
    }

    public function get($id): NiftyService
    {
        return $this->niftyServiceRepo->get($id);
    }

    public function getNiftyServices(int $id): Collection
    {
        return $this->niftyServiceRepo->getNiftyServices($id);
    }

    public function store(array $data): bool
    {
        $nifty = Auth::user();
        if (!$nifty->gig->contains('assistant_type_id', $data['assistant_type_id'])) {
            $this->niftyGigSvc->store([
                'nifty_assistant_id' => Auth::id(),
                'assistant_type_id'  => $data['assistant_type_id']
            ]);
        }
        try {
            NiftyService::create($data);
            return true;
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return false;
        }
    }

    public function update($id, array $array): bool
    {
        try {
            $niftyService = $this->get($id);
            $niftyService->update($array);
            return true;
        } catch (QueryException $e) {
            Log::error($e->getMessage());
            return false;
        }
    }

    public function destroy(int $id): bool
    {
        try {
            $this->get($id)->delete();
            return true;
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return false;
        }
    }
}
