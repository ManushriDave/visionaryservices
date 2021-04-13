<?php

namespace App\Http\Controllers\Api;

use App\Contracts\Controller;
use App\Enums\ApproxDuration;
use App\Repositories\NiftyGigRepository;
use App\Services\FileService;
use App\Services\NiftyAssistantService;
use Carbon\Carbon;
use Illuminate\Http\Request;

class NiftyAssistantController extends Controller
{
    /**
     * @var NiftyAssistantService
     */
    private NiftyAssistantService $niftyAssistantSvc;
    private FileService $fileSvc;
    private NiftyGigRepository $niftyGigRepo;

    /**
     * NiftyAssistantController constructor.
     *
     * @param NiftyAssistantService $niftyAssistantSvc
     * @param NiftyGigRepository $niftyGigRepo
     * @param FileService $fileSvc
     */
    public function __construct(
        NiftyAssistantService $niftyAssistantSvc,
        NiftyGigRepository $niftyGigRepo,
        FileService $fileSvc
    ) {
        $this->niftyAssistantSvc = $niftyAssistantSvc;
        $this->niftyGigRepo = $niftyGigRepo;
        $this->fileSvc = $fileSvc;
    }

    public function show($id)
    {
        return $this->niftyAssistantSvc->get($id);
    }

    public function gig($id)
    {
        return $this->niftyGigRepo->get($id);
    }

    public function store(Request $request)
    {
        $request->validate([
            'cv_file'                => 'file',
            'avatar_file'            => 'file|mimes:jpeg,jpg,png,gif',
            'freelance_licence_file' => 'file',
            'gender'                 => 'required',
            'speciality_tasks'       => 'required',
            'lat'                    => 'required',
            'long'                   => 'required',
        ]);
        $request_data = $request->all();

        if ($this->niftyAssistantSvc->checkIfExists($request_data['email'])) {
            return response(['errors' => ['A Nifty Assistant with this Email ID already exists!']], 419);
        }

        // Finally Store to Database.
        return $this->niftyAssistantSvc->store($request_data);
    }

    public function search(Request $request): array
    {
        $request->validate([
            'task_ids' => 'required',
            'lat'      => 'required',
            'long'     => 'required',
        ]);

        return $this->niftyAssistantSvc->search($request->except('_token'));
    }

    public function check(Request $request): bool
    {
        $request->validate([
            'date'             => 'required',
            'time'             => 'required',
            'approx_duration'  => 'required',
        ]);

        return $this->niftyAssistantSvc->check($request->except('_token'));
    }
}
