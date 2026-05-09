<?php

namespace App\Controllers;

use App\Models\ObjectifModel;
use App\Models\OptionGoldModel;
use App\Models\RegimePrix;
use App\Models\UserModel;

class ObjectifController extends BaseController
{
    public function index()
    {
        $objectifModel = new ObjectifModel();
        $objectifs = $objectifModel->getAllObjectif();

        return view('objectifs', ['objectifs' => $objectifs]);
    }
}