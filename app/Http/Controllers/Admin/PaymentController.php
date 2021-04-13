<?php

namespace App\Http\Controllers\Admin;

use App\Contracts\Controller;
use App\Services\PaymentService;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    private $paymentSvc;

    /**
     * PaymentController constructor.
     * @param $paymentSvc
     */
    public function __construct(PaymentService $paymentSvc)
    {
        $this->paymentSvc = $paymentSvc;
    }

    public function index()
    {
        $payments = $this->paymentSvc->getAll();
        return view('admin.payments.index', [
            'payments' => $payments,
        ]);
    }

    public function show($id)
    {
        $payment = $this->paymentSvc->get($id);
        return view('admin.payments.show');
    }
}
