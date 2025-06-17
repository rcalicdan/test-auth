<?php

namespace App\Controllers;

use App\Models\User;
use App\Requests\Auth\LoginRequest;
use App\Requests\Auth\RegisterRequest;
use Rcalicdan\Ci4Larabridge\Facades\Auth;

class AuthController extends BaseController
{
    public function showLoginPage()
    {
        return blade_view('contents.auth.login');
    }


    public function showRegisterPage()
    {
        return blade_view('contents.auth.register');
    }

    public function register()
    {
        User::create(RegisterRequest::validateRequest());

        return redirect()->route('login')->with('success', 'Registration successful. Please login.');
    }

    public function login()
    {
        $credentials = LoginRequest::validateRequest();
        $remember = $this->request->getPost('remember') ? true : false;

        if (Auth::attempt($credentials, $remember)) {
            return redirect()->to('/welcome');
        }

        return redirect()->back()->withInput()->with('error', 'Invalid Email or Password');
    }

    public function logout()
    {
        Auth::logout();

        return redirect()->to('/login')->with('success', 'Logged out successfully');
    }
}
