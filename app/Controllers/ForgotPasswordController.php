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
        return blade_view('contents.auth.reset-password');
    }

    public function update()
    {
        $token = service('uri')->getSegment(3);

        $data = RequestValidator::validate([
            'password' => ['required', 'string', 'min:8'],
            'confirm_password' => ['required', 'string', 'same:password'],
        ]);

        log_message('error', "confirm_password:" . $this->request->getPost('confirm_password') ?? "No value");

        Auth::resetPassword($token, $data->password);

        return redirect()->route('login')->with('success', 'Password reset successfully.');
    }
}
