<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use Illuminate\Support\Facades\DB;
use Rcalicdan\Ci4Larabridge\Facades\Auth;
use Rcalicdan\FiberAsync\AsyncEventLoop;

class EmailVerficationController extends BaseController
{
    public function index(): string
    {
        return blade_view('email-required');
    }

    public function send()
    {
        $user = auth()->user();

        task(function () use ($user) {
            Auth::sendEmailVerification($user);
        });
       
        return redirect()->back()->with('success', "Email Verfication sent to {$user->email}");
    }

    public function verify($token)
    {
        $token = service('uri')->getSegment(3);
        Auth::verifyEmail($token);

        return redirect()->route('welcome');
    }
}
