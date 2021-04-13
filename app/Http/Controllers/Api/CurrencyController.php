<?php

namespace App\Http\Controllers\Api;

use App\Contracts\Controller;
use App\Repositories\CurrencyRepository;
use App\Repositories\Interfaces\CurrencyRepositoryInterface;
use Illuminate\Http\Request;

class CurrencyController extends Controller
{
    private CurrencyRepositoryInterface $currencyRepo;

    /**
     * CurrencyController constructor.
     * @param $currencyRepo
     */
    public function __construct(CurrencyRepositoryInterface $currencyRepo)
    {
        $this->currencyRepo = $currencyRepo;
    }

    public function index()
    {
        return $this->currencyRepo->getAll();
    }
}
