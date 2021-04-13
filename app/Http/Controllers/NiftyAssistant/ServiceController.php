<?php

namespace App\Http\Controllers\NiftyAssistant;

use App\Contracts\Controller;
use App\Repositories\AssistantTypeRepository;
use App\Services\NiftyServiceService;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Auth;

class ServiceController extends Controller
{
    protected NiftyServiceService $niftyServiceSvc;
    private AssistantTypeRepository $assistantTypeRepo;

    public function __construct(
        AssistantTypeRepository $assistantTypeRepo,
        NiftyServiceService $niftyServiceSvc
    ) {
        $this->niftyServiceSvc = $niftyServiceSvc;
        $this->assistantTypeRepo = $assistantTypeRepo;
    }
    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View|Response
     */
    public function index()
    {
        $services = $this->niftyServiceSvc->getNiftyServices(Auth::id());
        return view('niftyassistant.services.index', [
            'services' => $services,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|View|Response
     */
    public function create()
    {
        $assistant_types = $this->assistantTypeRepo->getAll();
        return view('niftyassistant.services.create', [
            'assistant_types' => $assistant_types,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return Application|RedirectResponse|Response|Redirector
     */
    public function store(Request $request)
    {
        $data = $request->except('_token');
        $data['nifty_assistant_id'] = Auth::id();
        $store = $this->niftyServiceSvc->store($data);
        if ($store) {
            flash('Service Added!')->success();
        } else {
            flash('Something went wrong!')->error();
        }
        return redirect(route('niftyassistant.services.index'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return Application|Factory|View|Response
     */
    public function edit(int $id)
    {
        $service = $this->niftyServiceSvc->get($id);
        $assistant_types = Auth::guard('niftyassistant')->user()->assistant_types;
        return view('niftyassistant.services.edit', [
            'service'         => $service,
            'assistant_types' => $assistant_types,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return Application|RedirectResponse|Response|Redirector
     */
    public function update(Request $request, $id)
    {
        $data = $request->except('_token', '_method');
        $store = $this->niftyServiceSvc->update($id, $data);
        if ($store) {
            flash('Service Edited!')->success();
        } else {
            flash('Something went wrong!')->error();
        }
        return redirect(route('niftyassistant.services.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        $store = $this->niftyServiceSvc->destroy($id);
        if ($store) {
            flash('Service Deleted!')->success();
        } else {
            flash('Something went wrong!')->error();
        }
        return redirect(route('niftyassistant.services.index'));
    }
}
