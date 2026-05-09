<?php

namespace App\Controllers;

class BackOfficeController extends BaseController
{
    public function index(): string
    {
        return view('bo-dashboard', ['page' => 'pages/Regime']);
    }
}
