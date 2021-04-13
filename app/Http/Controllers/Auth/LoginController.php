<?php

namespace App\Http\Controllers\Auth;

use App\Contracts\Controller;
use App\Models\NiftyAssistant;
use App\Models\Token;
use App\Models\User;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function index()
    {
        if (Auth::guard('niftyassistant')->check()) {
            redirect()->intended(route('niftyassistant.index'));
        } elseif (Auth::check()) {
            redirect()->intended(route('frontend.index'));
        }
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'email|required',
            'password' => 'required',
        ]);

        if ($request->has('niftyassistant')) {
            $guard = 'niftyassistant';
            $route = 'niftyassistant.index';
            $client_name = 'Visionary Services Nifty Personal Access Client';
            $scope = 'is-nifty';
            $column = 'nifty_assistant_id';
            $user = NiftyAssistant::where('email', $request->input('email'))->first();
        } else {
            $guard = 'web';
            $route = 'admin.index';
            $client_name = 'Visionary Services Personal Access Client';
            $scope = 'is-user';
            $column = 'user_id';
            $user = User::where('email', $request->input('email'))->first();
        }

        $credentials = $request->only('email', 'password');

        if (Auth::guard($guard)->attempt($credentials, true)) {
            return redirect()->intended(route($route));
        } else {
            if ($user) {
                flash('Incorrect Login Credentials!')->error();
            } else {
                flash('No account found with this email!')->error();
            }
        }

        return view('auth.login');
    }

    public function logout()
    {
        if (Auth::guard('niftyassistant')->check()) {
            Auth::guard('niftyassistant')->logout();
        } elseif (Auth::check()) {
            Auth::logout();
        }
        return redirect(route('auth.login'));
    }

    public function email()
    {
        return view('auth.verify-email');
    }

    public function verify(EmailVerificationRequest $request)
    {
        $request->fulfill();
        return redirect(route('frontend.index'));
    }

    public function resend(Request $request): RedirectResponse
    {
        $request->user()->sendEmailVerificationNotification();
        flash('Verification link sent!')->success();
        return back();
    }
}
