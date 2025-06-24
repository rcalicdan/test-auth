<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Jobs\SendEmailVerfication;
use Rcalicdan\Ci4Larabridge\Facades\Auth;

class EmailVerficationController extends BaseController
{
    public function index(): string
    {
        return blade_view('email-required');
    }

    public function send()
    {
        $user = auth()->user();
        SendEmailVerfication::dispatch($user->id);
        return redirect()->back()->with('success', "Email Verification sent to {$user->email}");
    }

    public function verify($token)
    {
        $token = service('uri')->getSegment(3);

        if (Auth::verifyEmail($token)) {
            return redirect()->route('welcome');
        }

        return redirect()->to('/login')->with('error', 'Invalid or expired verification link.');
    }
}
