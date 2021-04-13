<?php

namespace App\Http\Controllers\Frontend;

use App\Contracts\Controller;
use App\Services\UserService;
use Auth;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    private $userSvc;

    /**
     * DashboardController constructor.
     * @param $userSvc
     */
    public function __construct(UserService $userSvc)
    {
        $this->userSvc = $userSvc;
    }

    public function index()
    {
        // Get Logged In USER ID
        $user_id = Auth::id();

        $upcoming_bookings = $this->userSvc->getPendingBookings($user_id);
        $ongoing_tasks = $this->userSvc->getOnGoingTasks($user_id);
        $all_bookings = $this->userSvc->getAllBookings($user_id);

        $pending_payment = $this->userSvc->getPendingPayment($user_id);

        return view('frontend.dashboard.index', [
            'upcoming_bookings' => $upcoming_bookings,
            'ongoing_tasks'     => $ongoing_tasks,
            'all_bookings'      => $all_bookings,
            'pending_payment'   => $pending_payment,
        ]);
    }
}
