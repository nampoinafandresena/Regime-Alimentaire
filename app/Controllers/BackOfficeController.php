<?php

namespace App\Controllers;

class BackOfficeController extends BaseController
{
    public function index(): string
    {
        return view('Modal-BO', ['page' => 'pages/bo-dashboard']);
    }
}
