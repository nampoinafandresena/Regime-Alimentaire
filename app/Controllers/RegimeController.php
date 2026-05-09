<?php

namespace App\Controllers;

class RegimeController extends BaseController
{
    public function index(): string
    {
        return view('Modal', ['page' => 'pages/Regime']);
    }
}
