<?php

namespace App\Http\Controllers\Api;

use App\Contracts\Controller;
use App\Services\NiftyRankService;

class NiftyRankController extends Controller
{
    private $niftyRankSvc;

    /**
     * NiftyRankController constructor.
     * @param $niftyRankSvc
     */
    public function __construct(NiftyRankService $niftyRankSvc)
    {
        $this->niftyRankSvc = $niftyRankSvc;
    }

    public function index()
    {
        return $this->niftyRankSvc->getAll();
    }
}
