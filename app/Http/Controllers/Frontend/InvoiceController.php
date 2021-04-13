<?php

namespace App\Http\Controllers\Frontend;

use App\Contracts\Controller;
use App\Services\AppointmentService;
use App\Services\InvoiceService;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InvoiceController extends Controller
{
    /**
     * @var UserService
     */
    private $userSvc;
    private $appointmentSvc;

    /**
     * InvoiceController constructor.
     * @param UserService $userSvc
     * @param AppointmentService $appointmentSvc
     */
    public function __construct(
        UserService $userSvc,
        AppointmentService $appointmentSvc
    ) {
        $this->userSvc = $userSvc;
        $this->appointmentSvc = $appointmentSvc;
    }

    public function index()
    {
        $invoices = $this->userSvc->getAllBookings(Auth::id());
        return view('frontend.invoices.index', [
            'invoices' => $invoices,
        ]);
    }

    public function show($id)
    {
        $invoice = $this->appointmentSvc->get($id);
        if (Auth::id() != $invoice->user_id) {
            flash('This Invoice does not belongs to you!')->error();
            return redirect(route('frontend.invoices.index'));
        }
        return view('frontend.invoices.show', [
            'invoice' => $invoice,
        ]);
    }
}
