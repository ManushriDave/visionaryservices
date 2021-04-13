<?php

namespace App\Http\Controllers\Admin;

use App\Contracts\Controller;
use App\Enums\NiftyStatus;
use App\Services\AssistantTypeService;
use App\Services\FileService;
use App\Services\NiftyAssistantService;
use App\Services\NiftyRankService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class NiftyAssistantController extends Controller
{
    /**
     * @var NiftyAssistantService
     */
    private NiftyAssistantService $niftyAssistantSvc;
    private NiftyRankService $niftyRankSvc;
    private FileService $fileSvc;
    private AssistantTypeService $assistantTypeSvc;

    /**
     * NiftyAssistantController constructor.
     *
     * @param AssistantTypeService $assistantTypeSvc
     * @param NiftyAssistantService $niftyAssistantSvc
     * @param NiftyRankService $niftyRankSvc
     * @param FileService $fileSvc
     */
    public function __construct(
        AssistantTypeService $assistantTypeSvc,
        NiftyAssistantService $niftyAssistantSvc,
        NiftyRankService $niftyRankSvc,
        FileService $fileSvc
    ) {
        $this->niftyAssistantSvc = $niftyAssistantSvc;
        $this->niftyRankSvc = $niftyRankSvc;
        $this->assistantTypeSvc = $assistantTypeSvc;
        $this->fileSvc = $fileSvc;
    }

    public function index()
    {
        $approved_nifty_assistants = $this->niftyAssistantSvc->getByStatus(NiftyStatus::APPROVED);
        $pending_nifty_assistants = $this->niftyAssistantSvc->getByStatus(NiftyStatus::PENDING);
        $on_hold_nifty_assistants = $this->niftyAssistantSvc->getByStatus(NiftyStatus::ON_HOLD);
        $rejected_nifty_assistants = $this->niftyAssistantSvc->getByStatus(NiftyStatus::REJECTED);

        return view('admin.nifty_assistants.index', [
            'approved_nifty_assistants' => $approved_nifty_assistants,
            'pending_nifty_assistants'  => $pending_nifty_assistants,
            'on_hold_nifty_assistants'  => $on_hold_nifty_assistants,
            'rejected_nifty_assistants' => $rejected_nifty_assistants,
        ]);
    }

    public function create()
    {
        return view('admin.nifty_assistants.create');
    }

    public function show($id)
    {
        $assistant_types = $this->assistantTypeSvc->getAll();
        $nifty_assistant = $this->niftyAssistantSvc->get($id, true);
        if (!$nifty_assistant) {
            flash('Nifty Not Found!')->error();
            return redirect(route('admin.nifty_assistants.index'));
        }
        $ranks = $this->niftyRankSvc->getAll();
        return view('admin.nifty_assistants.show', [
            'nifty_assistant' => $nifty_assistant,
            'assistant_types' => $assistant_types,
            'ranks'           => $ranks,
        ]);
    }

    public function update($id, Request $request): RedirectResponse
    {
        $data = $request->except(['_token', '_method']);

        if ($request->has('approve')) {
            $update = $this->niftyAssistantSvc->approveAssistant($id);
        } elseif ($request->has('reject')) {
            if (!$request->input('reason')) {
                flash('Please specify a reasons!')->error();
                $update = false;
            } else {
                $update = $this->niftyAssistantSvc->rejectAssistant($id, $request->input('reason'));
            }
        } elseif ($request->has('on_hold')) {
            if (!$request->input('reason')) {
                flash('Please specify a reasons!')->error();
                $update = false;
            } else {
                $update = $this->niftyAssistantSvc->holdAssistant($id, $request->input('reason'));
            }
        } else {
            $update = $this->niftyAssistantSvc->update($id, $data);
        }

        if (!$update) {
            flash('Something went wrong!')->error();
        } else {
            flash('Action performed successfully!')->success();
        }
        return back();
    }

    public function download(Request $request): BinaryFileResponse
    {
        return $this->fileSvc->download($request->input('filename'));
    }

    public function destroy($id): RedirectResponse
    {
        $this->niftyAssistantSvc->deleteNifty($id);
        return back();
    }
}
