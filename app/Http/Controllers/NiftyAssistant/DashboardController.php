<?php

namespace App\Http\Controllers\NiftyAssistant;

use App\Contracts\Controller;
use App\Enums\AppointmentStatus;
use App\Services\NiftyAssistantService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class DashboardController extends Controller
{
    private NiftyAssistantService $niftyAssistantSvc;

    /**
     * DashboardController constructor.
     * @param NiftyAssistantService $niftyAssistantSvc
     */
    public function __construct(NiftyAssistantService $niftyAssistantSvc)
    {
        $this->niftyAssistantSvc = $niftyAssistantSvc;
    }

    public function index()
    {
        $nifty_assistant = auth()->guard('niftyassistant')->user();
        $tasks = $this->niftyAssistantSvc->getTasksByStatus($nifty_assistant->id);
        $earned_amount = $this->niftyAssistantSvc->getEarnedAmount($nifty_assistant->id);

        return view('niftyassistant.dashboard.index', [
            'completed_tasks' => $tasks->where('status', AppointmentStatus::COMPLETED),
            'pending_tasks'   => $tasks->where('status', AppointmentStatus::PENDING),
            'accepted_tasks'  => $tasks->where('status', AppointmentStatus::ACCEPTED),
            'earned_amount'   => $earned_amount,
            'nifty_assistant' => $nifty_assistant,
        ]);
    }

    public function agreement(Request $request)
    {
        $this->niftyAssistantSvc->signAgreement($request->except('_token'));
        return redirect(route('niftyassistant.index'));
    }
}
