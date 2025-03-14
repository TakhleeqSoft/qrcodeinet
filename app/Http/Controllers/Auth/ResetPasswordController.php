<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\ResetsPasswords;

class ResetPasswordController extends Controller
{
    use ResetsPasswords;
    protected $redirectTo = RouteServiceProvider::HOME;

    protected function rules()
    {
        return [
            'token' => 'required',
            'email' => 'required|email',
            'password' => ['required','confirmed',],
        ];
    }

    protected function validationErrorMessages()
    {
        $lbl_email = strtolower(__('system.fields.email'));
        strtolower(__('system.fields.password'));
        return [
            "email.required" => __('validation.required', ['attribute' => $lbl_email]),
            "email.email" => __('validation.custom.invalid', ['attribute' => $lbl_email]),

            "password.required" => __('validation.required'),
            "password.regex" => __('validation.password.invalid'),
            "password.confirmed" => __('validation.password.passwordconfirmation'),

        ];
    }
}
