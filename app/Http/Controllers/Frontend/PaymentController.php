<?php

namespace App\Http\Controllers\Frontend;

use App\Contracts\Controller;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{
    private $userSvc;

    /**
     * PaymentController constructor.
     * @param $userSvc
     */
    public function __construct(UserService $userSvc)
    {
        $this->userSvc = $userSvc;
    }

    public function index()
    {
        $payments = $this->userSvc->getPayments(Auth::id());
        return view('frontend.payments.index', [
            'payments' => $payments,
        ]);
    }
}
