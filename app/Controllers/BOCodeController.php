<?php

namespace App\Controllers;

use App\Models\CodeModel;
use App\Models\CodeUserModel;

class BOCodeController extends BaseController
{
    public function index()
    {
        $codeModel = new CodeModel();
        $search = $this->request->getGet('search');
        $statut = $this->request->getGet('statut');
        
        $data = [
            'codes' => $codeModel->getCodesWithUsers($search, $statut),
            'totalCodes' => $codeModel->countAllCodes(),
            'validatedCodes' => $codeModel->countValidatedCodes(),
            'availableCodes' => $codeModel->countAvailableCodes(),
            'searchTerm' => $search,
            'statutFilter' => $statut
        ];
        
        return view('Modal-BO', [
            'title' => 'Codes',
            'page' => 'pages/bo-crud-code',
            'data' => $data
        ]);
    }
    
    public function getCodeAjax($id)
    {
        if ($this->request->isAJAX()) {
            $codeModel = new CodeModel();
            $code = $codeModel->getCodeById($id);
            
            if ($code) {
                return $this->response->setJSON([
                    'success' => true,
                    'code' => $code
                ]);
            }
        }
        
        return $this->response->setJSON([
            'success' => false,
            'message' => 'Code non trouvé'
        ]);
    }
    
    public function createCodeAjax()
    {
        if ($this->request->isAJAX()) {
            $codeModel = new CodeModel();
            $data = $this->request->getJSON(true);
            
            // Validation
            if (empty($data['code']) || empty($data['montant'])) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Le code et le montant sont obligatoires'
                ]);
            }
            
            try {
                $id = $codeModel->insert([
                    'code' => $data['code'],
                    'montant' => $data['montant'],
                    'est_valide' => $data['est_valide'] ?? 1,
                    'date_expiration' => $data['date_expiration'] ?? null
                ]);
                
                if ($id) {
                    return $this->response->setJSON([
                        'success' => true,
                        'message' => 'Code créé avec succès',
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
    
    public function generateCodesAjax()
    {
        if ($this->request->isAJAX()) {
            $codeModel = new CodeModel();
            $data = $this->request->getJSON(true);
            
            $nombre = (int)($data['nombre'] ?? 10);
            $montant = (float)($data['montant'] ?? 10000);
            $dateExpiration = $data['date_expiration'] ?? null;
            
            if ($nombre <= 0 || $nombre > 100) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Le nombre doit être entre 1 et 100'
                ]);
            }
            
            try {
                $result = $codeModel->generateCodes($nombre, $montant, $dateExpiration);
                
                if ($result) {
                    return $this->response->setJSON([
                        'success' => true,
                        'message' => "$nombre codes générés avec succès"
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
    
    public function updateCodeAjax($id)
    {
        if ($this->request->isAJAX()) {
            $codeModel = new CodeModel();
            $data = $this->request->getJSON(true);
            
            try {
                $updated = $codeModel->update($id, $data);
                if ($updated) {
                    return $this->response->setJSON([
                        'success' => true,
                        'message' => 'Code mis à jour avec succès'
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
    
    public function deleteCodeAjax($id)
    {
        if ($this->request->isAJAX()) {
            $codeModel = new CodeModel();
            
            try {
                $deleted = $codeModel->deleteCode($id);
                if ($deleted) {
                    return $this->response->setJSON([
                        'success' => true,
                        'message' => 'Code supprimé avec succès'
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
    
    public function validerCodeAjax($id)
    {
        if ($this->request->isAJAX()) {
            $codeModel = new CodeModel();
            
            try {
                $updated = $codeModel->update($id, ['est_valide' => 1]);
                if ($updated) {
                    return $this->response->setJSON([
                        'success' => true,
                        'message' => 'Code validé avec succès'
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
    
    public function invaliderCodeAjax($id)
    {
        if ($this->request->isAJAX()) {
            $codeModel = new CodeModel();
            
            try {
                $updated = $codeModel->update($id, ['est_valide' => 0]);
                if ($updated) {
                    return $this->response->setJSON([
                        'success' => true,
                        'message' => 'Code invalidé avec succès'
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