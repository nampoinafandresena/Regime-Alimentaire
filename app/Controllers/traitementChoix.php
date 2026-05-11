<?php

namespace App\Controllers;
use App\Models\ActiviteSportiveModel;
use App\Models\RegimeModel;
use App\Models\ChoixRegimesSport;

class traitementChoix extends BaseController
{       
    public function traitement()
    {
        $sportId = $this->request->getPost('sport_id');
        $selectedRegimes = $this->request->getPost('regime_ids') ?? []; 

        // Vérifier que les données requises sont présentes
        if (empty($sportId) || empty($selectedRegimes)) {
            return redirect()->to('/regimes')->with('error', 'Veuillez sélectionner au moins un régime et un sport.');
        }

        $ChoixRegimeSportModel = new ChoixRegimesSport();
        
        // Insérer les choix dans la base de données
        if ($ChoixRegimeSportModel->insertAll($selectedRegimes, $sportId)) {
            return redirect()->to('/profil')->with('success', 'Vos choix ont été enregistrés avec succès !');
        } else {
            return redirect()->to('/regimes')->with('error', 'Erreur lors de l\'enregistrement de vos choix.');
        }
    }
}