<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use Rcalicdan\Ci4Larabridge\Facades\Auth;
use Rcalicdan\Ci4Larabridge\Validation\RequestValidator;

class ForgotPasswordController extends BaseController
{
    public function index()
    {
        return blade_view('contents.auth.forgot-password');
    }

    public function send()
    {
        $data = RequestValidator::validate([
            'email' => ['required', 'email', 'max:255'],
        ]);

        Auth::sendPasswordResetLink($data->email);

        return redirect()->back()->with('success', 'Password reset link sent to your email.');
    }

    public function show()
    {
        $token = service('uri')->getSegment(3);

        return blade_view('contents.auth.reset-password', compact('token'));
    }

    public function update($token)
    {
        $token = service('uri')->getSegment(3);

        $data = RequestValidator::validate([
            'password' => ['required', 'string', 'min:8'],
            'confirm_password' => ['required', 'string', 'same:password'],
        ]);

        if(! Auth::resetPassword($token, $data->password)) {
            log_message('error', "token: $token");
            log_message('error', "Password reset failed for token: $token");
            return redirect()->back()->with('error', 'Invalid or expired token.');
        }

        return redirect()->route('login')->with('success', 'Password reset successfully.');
    }
}
