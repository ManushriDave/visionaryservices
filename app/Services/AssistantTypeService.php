<?php

namespace App\Services;

use App\Enums\NiftyStatus;
use App\Models\AssistantType;
use App\Repositories\AssistantTypeRepository;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class AssistantTypeService
{
    private AssistantTypeRepository $assistantTypeRepo;

    /**
     * AssistantTypeService constructor.
     *
     * @param AssistantTypeRepository $assistantTypeRepo
     */
    public function __construct(AssistantTypeRepository $assistantTypeRepo)
    {
        $this->assistantTypeRepo = $assistantTypeRepo;
    }

    public function getAll(): Collection
    {
        $name_your_nifty = false;
        $collection = collect([]);
        $assistant_types = $this->assistantTypeRepo->getAll();
        foreach ($assistant_types->reverse() as $i => $assistant_type) {
            $sorted_gigs = collect();
            foreach ($assistant_type->gigs as $gig) {
                if ($gig->nifty->status == NiftyStatus::APPROVED) {
                    $sorted_gigs->push($gig);
                }
            }
            $assistant_type->sorted_gigs = $sorted_gigs;

            if (Str::contains($assistant_type->name, ['name', 'your', 'nifty'])) {
                $name_your_nifty = true;
                $collection->push($assistant_type);
            } else {
                if ($name_your_nifty) {
                    $collection->prepend($assistant_type);
                } else {
                    $collection->push($assistant_type);
                }
            }
        }

        return $collection;
    }

    public function get($id)
    {
        $assistant_type = $this->assistantTypeRepo->get($id);
        if ($assistant_type) {
            $sorted_gigs = collect();
            foreach ($assistant_type->gigs as $gig) {
                if ($gig->nifty->status == NiftyStatus::APPROVED) {
                    $sorted_gigs->push($gig);
                }
            }
            $assistant_type->sorted_gigs = $sorted_gigs;
        }
        return $assistant_type;
    }

    public function store(array $data): void
    {
        try {
            AssistantType::create($data);
            flash('Assistant Type Created!')->success();
        } catch (QueryException $e) {
            flash('Something Went Wrong! Contact Yash :p')->error();
            Log::error($e->getMessage());
        }
    }

    public function update($id, array $data): void
    {
        try {
            $this->assistantTypeRepo->get($id)->update($data);
            flash('Assistant Type Updated!')->success();
        } catch (QueryException $e) {
            Log::error($e->getMessage());
            flash('Something Went Wrong! Contact Yash :p')->error();
        }
    }

    public function delete($id): void
    {
        try {
            $this->assistantTypeRepo->get($id)->delete();
            flash('Assistant Type Deleted!')->success();
        } catch (Exception $e) {
            Log::error($e->getMessage());
            flash('Something Went Wrong or an appointment is associated with this assistant type!')->error();
        }
    }

    public function getAppointmentsGraph(): array
    {
        $assistant_types = $this->getAll();
        $data = [];
        foreach ($assistant_types as $assistant_type) {
            $appointments = 0;
            $nifties = $assistant_type->nifties(NiftyStatus::APPROVED, true);
            foreach ($nifties as $nifty) {
                $services = $nifty->services;
                foreach ($services as $service) {
                    $appointments += $service->tasks->count();
                }
            }
            $data[] = [
                'label' => $assistant_type->name,
                'value' => $appointments,
            ];
        }
        return $data;
    }
}
