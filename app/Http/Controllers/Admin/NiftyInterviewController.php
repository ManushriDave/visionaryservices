<?php

namespace App\Http\Controllers\Admin;

use App\Contracts\Controller;
use App\Repositories\NiftyAssistantRepository;
use App\Repositories\NiftyInterviewRepository;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class NiftyInterviewController extends Controller
{
    private NiftyInterviewRepository $niftyInterviewRepo;
    private NiftyAssistantRepository $niftyAssistantRepo;

    /**
     * NiftyInterviewController constructor.
     * @param NiftyAssistantRepository $niftyAssistantRepo
     * @param NiftyInterviewRepository $niftyInterviewRepo
     */
    public function __construct(
        NiftyAssistantRepository $niftyAssistantRepo,
        NiftyInterviewRepository $niftyInterviewRepo
    ) {
        $this->niftyAssistantRepo = $niftyAssistantRepo;
        $this->niftyInterviewRepo = $niftyInterviewRepo;
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->except('_token');
        $this->niftyInterviewRepo->create($data);
        flash('Interview Saved!')->success();
        return back();
    }

    public function update(Request $request, $id): RedirectResponse
    {
        $data = $request->except('_token', '_method');
        $this->niftyInterviewRepo->update($id, $data);
        flash('Interview Updated!')->success();
        return back();
    }
}
