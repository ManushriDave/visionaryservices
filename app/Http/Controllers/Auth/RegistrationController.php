<?php

namespace App\Http\Controllers\Auth;

use App\Contracts\Controller;
use App\Models\User;
use App\Services\UserService;
use Hash;
use Illuminate\Http\Request;

class RegistrationController extends Controller
{
    private $userSvc;

    /**
     * RegistrationController constructor.
     * @param $userSvc
     */
    public function __construct(UserService $userSvc)
    {
        $this->userSvc = $userSvc;
    }

    public function index()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'email'    => 'required|unique:users|max:55',
            'name'     => 'required',
            'password' => 'required',
        ]);

        $register = $this->userSvc->register($request->all());

        if ($register) {
            flash('Registration Successful!')->success();
            $route = 'frontend.index';
        } else {
            flash('Something went wrong!')->error();
            $route = 'auth.register';
        }

        return redirect(route($route));
    }
}
