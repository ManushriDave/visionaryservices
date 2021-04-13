<?php

namespace App\Services;

use App\Enums\ProfileUpdateType;
use App\Models\NiftyResource;
use App\Repositories\NiftyGigRepository;
use Exception;
use Illuminate\Support\Facades\Log;

class NiftyGigService
{
    private FileService $fileSvc;
    private NiftyGigRepository $niftyGigRepo;

    /**
     * NiftyGigService constructor.
     * @param FileService $fileSvc
     * @param NiftyGigRepository $niftyGigRepo
     */
    public function __construct(
        FileService $fileSvc,
        NiftyGigRepository $niftyGigRepo
    ) {
        $this->fileSvc = $fileSvc;
        $this->niftyGigRepo = $niftyGigRepo;
    }

    public function checkSize($id, float $total_size): bool
    {
        $nifty = $this->niftyGigRepo->get($id);
        if ($nifty) {
            $resources = $nifty->resources;
            $current_size = 0;
            if ($resources) {
                foreach ($resources as $resource) {
                    $current_size += $resource->size;
                }

                if (($current_size + $total_size) > 10) {
                    return false;
                }
            }
        }
        return true;
    }

    public function updateResources($id, array $data)
    {
        $update_type = intval($data['update_type']);
        unset($data['update_type']);
        if ($update_type === ProfileUpdateType::ADD_RESOURCES) {
            foreach ($data['resources'] as $resource) {
                NiftyResource::create([
                    'nifty_gig_id' => $id,
                    'file'         => $resource['path'],
                    'size'         => $resource['size'],
                ]);
            }
        }
        if ($update_type === ProfileUpdateType::REMOVE_RESOURCES) {
            try {
                $resource = NiftyResource::find($data['resource_id']);
                $this->fileSvc->destroy($resource->file);
                $resource->delete();
            } catch (Exception $e) {
                Log::error($e->getMessage());
                flash('Something Went Wrong!')->error();
            }
        }
    }

    public function store(array $data)
    {
        return $this->niftyGigRepo->store($data);
    }
}
