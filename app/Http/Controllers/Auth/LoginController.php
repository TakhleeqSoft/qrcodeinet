<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    use AuthenticatesUsers;
    protected $redirectTo = RouteServiceProvider::HOME;
    public function __construct()
    {
        Auth::viaRemember();
        $this->middleware('guest')->except('logout');
    }

    protected function validateLogin(Request $request)
    {
        $lbl_email = strtolower(__('system.fields.email'));
        $lbl_password = strtolower(__('system.fields.password'));
        $request->validate([
            $this->username() => 'required|string',
            'password' => 'required|string',
        ], [
            "email.required" => __('validation.required', ['attribute' => $lbl_email]),
            "email.string" => __('validation.custom.invalid', ['attribute' => $lbl_email]),
            "password.required" => __('validation.required', ['attribute' => $lbl_password]),
            "password.string" => __('validation.password.invalid', ['attribute' => $lbl_password]),
        ]);
    }
    function authenticated(Request $request, $user)
    {
        //Update last login date for user.
        $user->update([
            'last_login_at'=>date('Y-m-d H:i"s'),
            'user_ip'=>request()->ip()
        ]);
    }
}
