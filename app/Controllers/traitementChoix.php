<?php

namespace App\Controllers;
use App\Models\ActiviteSportiveModel;
use App\Models\RegimeModel;
use App\Models\ChoixRegimeSport;

class traitementChoix extends BaseController
{       
    public function traitement()
    {
        $regimeModel = new RegimeModel();
        $activiteModel = new ActiviteSportiveModel();
        
        $sportId = $this->request->getPost('sport_id');
        $selectedRegimes[] = $this->request->getPost('regime_ids[]') ?? []; 

        $ChoixRegimeSportModel = new ChoixRegimeSport();
        $ChoixRegimeSportModel->insert($selectedRegimes, $sportId);


        return view('pages/confirmation', [
            'regimes' => $regimesDetails,
            'activite' => $activiteDetails
        ]);
    }
}