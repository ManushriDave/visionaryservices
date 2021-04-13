<?php

namespace App\Http\Controllers\Api;

use App\Contracts\Controller;
use App\Services\EmirateService;
use Illuminate\Http\Request;

class EmirateController extends Controller
{
    private $emirateSvc;

    /**
     * EmirateController constructor.
     * @param $emirateSvc
     */
    public function __construct(EmirateService $emirateSvc)
    {
        $this->emirateSvc = $emirateSvc;
    }

    public function index()
    {
        return $this->emirateSvc->getAll();
    }
}
