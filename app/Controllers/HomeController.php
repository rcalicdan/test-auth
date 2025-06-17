<?php

namespace App\Controllers;

class HomeController extends BaseController
{
    public function index(): string
    {
        $user = auth()->user();
        $welcomeTitleMeta = "Welcome $user->first_name";
        
        return blade_view('welcome', compact('welcomeTitleMeta'));
    }
}
