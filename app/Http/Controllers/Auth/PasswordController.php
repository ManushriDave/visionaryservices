<?php

namespace App\Http\Controllers\Auth;

use App\Contracts\Controller;
use Hash;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Str;
use Password;

class PasswordController extends Controller
{
    public function request()
    {
        return view('auth.password.forgot');
    }

    public function email(Request $request): RedirectResponse
    {
        $request->validate(['email' => 'required|email']);

        $broker = 'users';
        if ($request->has('nifty')) {
            $broker = 'niftyassistants';
        }

        $status = Password::broker($broker)->sendResetLink(
            $request->only('email')
        );

        return $status === Password::RESET_LINK_SENT
            ? back()->with(['status' => __($status)])->cookie(
                'isNifty',
                '123456',
                60
            )
            : back()->withErrors(['email' => __($status)]);
    }

    public function reset(Request $request, $token)
    {
        $email = $request->get('email');
        return view('auth.password.reset', [
            'email' => $email,
            'token' => $token,
        ]);
    }

    public function update(Request $request): RedirectResponse
    {
        $request->validate([
            'token'    => 'required',
            'email'    => 'required|email',
            'password' => 'required|min:8|confirmed',
        ]);

        $broker = 'users';
        if (Cookie::has('isNifty')) {
            $broker = 'niftyassistants';
        }

        $status = Password::broker($broker)->reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) use ($request) {
                $user->forceFill([
                    'password' => Hash::make($password)
                ])->save();

                Cookie::forget('isNifty');

                $user->setRememberToken(Str::random(60));

                event(new PasswordReset($user));
            }
        );

        return $status == Password::PASSWORD_RESET
            ? redirect()->route('auth.login')->with('status', __($status))
            : back()->withErrors(['email' => [__($status)]]);
    }
}
