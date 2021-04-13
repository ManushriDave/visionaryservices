<?php

namespace App\Http\Controllers\Api;

use App\Contracts\Controller;
use App\Services\UserService;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    private $userSvc;

    /**
     * ContactController constructor.
     * @param $userSvc
     */
    public function __construct(UserService $userSvc)
    {
        $this->userSvc = $userSvc;
    }

    public function contact(Request $request)
    {
        $request->validate([
            'email'   => 'required|email|min:5',
            'message' => 'required|string|min:5',
            'name'    => 'required|string|min:5',
            'phone'   => 'required|string|min:5',
        ]);
        return $this->userSvc->contact($request->all());
    }
}
