<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\Request;

class ForgotPasswordController extends Controller
{
    use SendsPasswordResetEmails;

    protected function validateEmail(Request $request)
    {
        $lbl_email = strtolower(__('system.fields.email'));
        $request->validate(
            ['email' => 'required|email'],
            [
                "email.required" => __('validation.required', ['attribute' => $lbl_email]),
                "email.email" => __('validation.custom.invalid', ['attribute' => $lbl_email]),
            ]
        );
    }
}
