<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class EmailVerficationController extends BaseController
{
    public function index()
    {
        return blade_view('email-required');
    }
}
