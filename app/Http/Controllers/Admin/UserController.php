<?php

namespace App\Http\Controllers\Admin;

use App\Contracts\Controller;
use App\Services\UserService;
use Illuminate\Http\Request;

class UserController extends Controller
{
    private $userSvc;

    /**
     * @param $userSvc
     */
    public function __construct(UserService $userSvc)
    {
        $this->userSvc = $userSvc;
    }

    public function index()
    {
        $users = $this->userSvc->getClients();
        return view('admin.users.index', [
            'users' => $users,
        ]);
    }
}
