<?php

namespace App\Http\Controllers\Admin;

use App\Contracts\Controller;
use App\Services\NiftyRankService;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class NiftyRankController extends Controller
{
    private $niftyRankSvc;

    /**
     * NiftyRankController constructor.
     * @param NiftyRankService $niftyRankSvc
     */
    public function __construct(NiftyRankService $niftyRankSvc)
    {
        $this->niftyRankSvc = $niftyRankSvc;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View|Response
     */
    public function index()
    {
        $nifty_ranks = $this->niftyRankSvc->getAll();
        return view('admin.nifty-ranks.index', [
            'nifty_ranks' => $nifty_ranks,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|View|Response
     */
    public function create()
    {
        return view('admin.nifty-ranks.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request)
    {
        $store = $this->niftyRankSvc->store($request->except('_token'));
        if (!$store) {
            flash('Something went wrong!')->error();
            return redirect()->back();
        }
        flash('Rank Added!')->success();
        return redirect(route('admin.nifty-ranks.index'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Application|Factory|View|Response
     */
    public function edit($id)
    {
        $nifty_rank = $this->niftyRankSvc->get($id);
        return view('admin.nifty-ranks.edit', [
            'nifty_rank' => $nifty_rank,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $id
     * @return RedirectResponse
     */
    public function update(Request $request, int $id)
    {
        $store = $this->niftyRankSvc->update($id, $request->except('_token', '_method'));
        if (!$store) {
            flash('Something went wrong!')->error();
            return redirect()->back();
        }
        flash('Rank Edited!')->success();
        return redirect(route('admin.nifty-ranks.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return RedirectResponse
     */
    public function destroy(int $id)
    {
        $destroy = $this->niftyRankSvc->destroy($id);
        if (!$destroy) {
            flash('Something went wrong!')->error();
            return redirect()->back();
        }
        flash('Rank Deleted!')->success();
        return redirect(route('admin.nifty-ranks.index'));
    }
}
