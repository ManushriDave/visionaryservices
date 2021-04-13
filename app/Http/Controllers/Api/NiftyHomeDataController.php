<?php

namespace App\Http\Controllers\Api;

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
        return $this->niftyHomeDataSvc->getAll();
    }
}
