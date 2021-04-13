<?php

namespace App\Http\Controllers\Api;

use App\Contracts\Controller;
use App\Enums\NiftyStatus;
use App\Models\AssistantType;
use App\Services\AssistantTypeService;
use App\Services\NiftyAssistantService;
use Illuminate\Support\Collection;

class AssistantTypeController extends Controller
{
    private AssistantTypeService $assistantTypeSvc;
    private NiftyAssistantService $niftyAssistantSvc;

    /**
     * AssistantTypeController constructor.
     * @param AssistantTypeService $assistantTypeSvc
     * @param NiftyAssistantService $niftyAssistantSvc
     */
    public function __construct(
        AssistantTypeService $assistantTypeSvc,
        NiftyAssistantService $niftyAssistantSvc
    ) {
        $this->assistantTypeSvc = $assistantTypeSvc;
        $this->niftyAssistantSvc = $niftyAssistantSvc;
    }

    public function index(): Collection
    {
        return $this->assistantTypeSvc->getAll();
    }

    public function show($id)
    {
        return $this->assistantTypeSvc->get($id);
    }

    public function tasks($id): Collection
    {
        return $this->assistantTypeSvc->get($id)->tasks;
    }
}
