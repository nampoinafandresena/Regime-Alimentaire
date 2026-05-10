<?php

namespace App\Controllers;
use App\Models\sport\SportModel;


class BOSportController extends BaseController{
    public function index(){
        $sportModel = new SportModel();
        $sports = $sportModel->getAllInfosSports($nom, $categorie, $intensite);
        return view('Modal-BO', [
            'page' => 'pages/bo-crud-sport',
            'sports' => $sports
        ]);
    }

    public function createSportAjax(){
        if ($this->request->isAJAX()) {
            $sportModel = new SportModel();
            
            $data = [
                'nom' => $this->request->getPost('nom'),
                'description' => $this->request->getPost('description'),
                'categorie' => $this->request->getPost('categorie'),
                'intensite' => $this->request->getPost('intensite'),
                'calorie_par_heure' => $this->request->getPost('calorie_par_heure')
            ];
            
            // Validation basique
            if (empty($data['nom']) || empty($data['description']) || empty($data['calorie_par_heure'])) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Le nom, la description et le nombre de calories sont obligatoires'
                ]);
            }
            
            try {
                $sportId = $sportModel->createSport($data);
                
                if ($sportId) {
                    return $this->response->setJSON([
                        'success' => true,
                        'message' => 'Sport créé avec succès',
                        'sport_id' => $sportId
                    ]);
                } else {
                    return $this->response->setJSON([
                        'success' => false,
                        'message' => 'Erreur lors de la création du sport'
                    ]);
                }
            } catch (\Exception $e) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Erreur lors de la création: ' . $e->getMessage()
                ]);
            }
        }
        
        return $this->response->setStatusCode(400)->setJSON([
            'success' => false,
            'message' => 'Requête invalide'
        ]);
    }

    public function updateSportAjax($id){
        if ($this->request->isAJAX()) {
            $sportModel = new SportModel();
            
            $data = [
                'nom' => $this->request->getPost('nom'),
                'description' => $this->request->getPost('description'),
                'categorie' => $this->request->getPost('categorie'),
                'intensite' => $this->request->getPost('intensite'),
                'calorie_par_heure' => $this->request->getPost('calorie_par_heure')
            ];
            
            // Validation basique
            if (empty($data['nom']) || empty($data['description']) || empty($data['calorie_par_heure'])) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Le nom, la description et le nombre de calories sont obligatoires'
                ]);
            }
            
            try {
                $updated = $sportModel->updateSport($id, $data);
                
                if ($updated) {
                    return $this->response->setJSON([
                        'success' => true,
                        'message' => 'Sport mis à jour avec succès'
                    ]);
                } else {
                    return $this->response->setJSON([
                        'success' => false,
                        'message' => 'Erreur lors de la mise à jour du sport'
                    ]);
                }
            } catch (\Exception $e) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Erreur lors de la mise à jour: ' . $e->getMessage()
                ]);
            }
        }
        
        return $this->response->setStatusCode(400)->setJSON([
            'success' => false,
            'message' => 'Requête invalide'
        ]);
    }
}