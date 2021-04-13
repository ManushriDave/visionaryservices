<?php

namespace App\Http\Controllers\NiftyAssistant;

use App\Contracts\Controller;
use App\Services\SupportService;
use Illuminate\Http\Request;

class SupportController extends Controller
{
    private $supportSvc;

    /**
     * SupportController constructor.
     * @param $supportSvc
     */
    public function __construct(SupportService $supportSvc)
    {
        $this->supportSvc = $supportSvc;
    }

    public function index()
    {
        return view('niftyassistant.support.index');
    }

    public function store(Request $request)
    {
        $data = $request->except('_token');
        $store = $this->supportSvc->storeRequest($data);
        if ($store) {
            flash('We have received your query!')->success();
        } else {
            flash('Query Sending Failed!')->error();
        }
        return redirect(route('niftyassistant.support.index'));
    }
}
