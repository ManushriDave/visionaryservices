<?php

namespace App\Http\Controllers\Admin;

use App\Contracts\Controller;
use App\Services\NiftyHomeDataService;
use Illuminate\Http\Request;

class NiftyHomeDataController extends Controller
{
    private $niftyHomeDataSvc;

    /**
     * NiftyHomeDataController constructor.
     * @param $niftyHomeDataSvc
     */
    public function __construct(NiftyHomeDataService $niftyHomeDataSvc)
    {
        $this->niftyHomeDataSvc = $niftyHomeDataSvc;
    }

    public function index()
    {
        $niftys_home_data = $this->niftyHomeDataSvc->getAll();
        return view('admin.nifty-home-data.index', [
            'niftys_home_data' => $niftys_home_data,
        ]);
    }

    public function edit($id)
    {
        $nifty_home_data = $this->niftyHomeDataSvc->get($id);
        return view('admin.nifty-home-data.edit', [
            'nifty_home_data' => $nifty_home_data,
        ]);
    }

    public function update($id, Request $request)
    {
        $update = $this->niftyHomeDataSvc->update($id, $request->except('_token', '_method'));
        if ($update) {
            flash('Success')->success();
        } else {
            flash('Error!')->error();
        }
        return redirect(route('admin.nifty-home-data.index'));
    }
}
