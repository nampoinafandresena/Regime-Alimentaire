<?php

namespace App\Controllers;

use App\Models\SportModel;
use App\Models\CategoriesSportModel;
use App\Models\IntensitesSportModel;

class BOSportController extends BaseController
{
    public function index()
    {
        $sportModel = new SportModel();
        $categorieModel = new CategoriesSportModel();
        $intensiteModel = new IntensitesSportModel();
        
        // Récupérer les filtres
        $search = $this->request->getGet('search');
        $categorie = $this->request->getGet('categorie');
        $intensite = $this->request->getGet('intensite');
        
        $sports = $sportModel->getAllInfosSports($search, $categorie, $intensite);
        $categories = $categorieModel->findAll();
        $intensites = $intensiteModel->findAll();
        
        return view('Modal-BO', [
            'title' => 'Sports',
            'page' => 'pages/bo-crud-sport',
            'sports' => $sports,
            'categories' => $categories,
            'intensites' => $intensites,
            'searchTerm' => $search,
            'filtreCategorie' => $categorie,
            'filtreIntensite' => $intensite
        ]);
    }
    
    public function getSportAjax($id)
    {
        if ($this->request->isAJAX()) {
            $sportModel = new SportModel();
            $sport = $sportModel->getSportById($id);
            
            if ($sport) {
                return $this->response->setJSON([
                    'success' => true,
                    'sport' => $sport
                ]);
            }
        }
        
        return $this->response->setJSON([
            'success' => false,
            'message' => 'Sport non trouvé'
        ]);
    }
    
    public function createSportAjax()
    {
        if ($this->request->isAJAX()) {
            $sportModel = new SportModel();
            $data = $this->request->getJSON(true);
            
            // Validation
            if (empty($data['nom']) || empty($data['id_categorie']) || empty($data['id_intensite'])) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Tous les champs sont obligatoires'
                ]);
            }
            
            try {
                $id = $sportModel->insert($data);
                if ($id) {
                    return $this->response->setJSON([
                        'success' => true,
                        'message' => 'Activité créée avec succès',
                        'id' => $id
                    ]);
                }
            } catch (\Exception $e) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Erreur: ' . $e->getMessage()
                ]);
            }
        }
        
        return $this->response->setJSON([
            'success' => false,
            'message' => 'Requête invalide'
        ]);
    }
    
    public function updateSportAjax($id)
    {
        if ($this->request->isAJAX()) {
            $sportModel = new SportModel();
            $data = $this->request->getJSON(true);
            
            try {
                $updated = $sportModel->update($id, $data);
                if ($updated) {
                    return $this->response->setJSON([
                        'success' => true,
                        'message' => 'Activité mise à jour avec succès'
                    ]);
                }
            } catch (\Exception $e) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Erreur: ' . $e->getMessage()
                ]);
            }
        }
        
        return $this->response->setJSON([
            'success' => false,
            'message' => 'Requête invalide'
        ]);
    }
    
    public function deleteSportAjax($id)
    {
        if ($this->request->isAJAX()) {
            $sportModel = new SportModel();
            
            try {
                $deleted = $sportModel->delete($id);
                if ($deleted) {
                    return $this->response->setJSON([
                        'success' => true,
                        'message' => 'Activité supprimée avec succès'
                    ]);
                }
            } catch (\Exception $e) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Erreur: ' . $e->getMessage()
                ]);
            }
        }
        
        return $this->response->setJSON([
            'success' => false,
            'message' => 'Requête invalide'
        ]);
    }
}