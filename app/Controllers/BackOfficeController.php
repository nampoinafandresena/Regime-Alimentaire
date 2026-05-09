<?php

namespace App\Controllers;

class BackOfficeController extends BaseController
{
    public function index(): string{
        return view('Modal-BO', ['page' => 'pages/bo-dashboard']);
    }

    public function crud_regime(): string{
        return view('Modal-BO', ['page' => 'pages/bo-crud-regime']);
    }

    public function crud_sport(): string{
        return view('Modal-BO', ['page' => 'pages/bo-crud-sport']);
    }

    public function crud_code(): string{
        return view('Modal-BO', ['page' => 'pages/bo-crud-code']);
    }

    public function crud_user(): string{
        return view('Modal-BO', ['page' => 'pages/bo-crud-user']);
    }
}
