<?php

namespace App\Http\Controllers\Frontend;

use App\Contracts\Controller;
use App\Services\NiftyWalletService;
use Auth;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class NiftyWalletController extends Controller
{
    private $niftyWalletSvc;

    /**
     * NiftyWalletController constructor.
     * @param $niftyWalletSvc
     */
    public function __construct(NiftyWalletService $niftyWalletSvc)
    {
        $this->niftyWalletSvc = $niftyWalletSvc;
    }

    /**
     * Display a listing of the resource.
     *
     * @return View|Response
     */
    public function index()
    {
        $wallet = $this->niftyWalletSvc->getWallet(Auth::id());
        if ($wallet) {
            $transactions = $wallet->transactions;
        } else {
            $transactions = [];
        }
        return view('frontend.nifty-wallet.index', [
            'transactions' => $transactions,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }
}
