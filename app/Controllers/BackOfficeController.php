<?php

namespace App\Controllers;
use App\Models\UserModel;
use App\Models\RegimeModel;
use App\Models\CodeModel;
use App\Models\UserObjectifModel;
use App\Models\ObjectifModel;

class BackOfficeController extends BaseController
{
    public function index(){
        $userModel = new UserModel();
        $dataUser = $userModel->countUser();
        $dataGold = $userModel->countGoldUsers();
        $dataUserInfos = $userModel->getInfosGeneralesUsers(5, null, null);
        
        // Calculer les statistiques des objectifs pour TOUS les utilisateurs
        $ObjectifModel = new ObjectifModel();
        $objectifsStatsResult = $ObjectifModel->getObjectifsStatistics();
        $objectifsStats = $objectifsStatsResult['data'] ?? [];
        $objectifsTotal = $objectifsStatsResult['total'] ?? 0;
        
        $regimeModel = new RegimeModel();
        $dataRegimes = $regimeModel->countActiveRegimes();
        $codeModel = new CodeModel();
        $dataCodes = $codeModel->countValidatedCodes();
        
        return view('Modal-BO', [
            'title' => 'Dashboard',
            'page' => 'pages/bo-dashboard', 
            'dataUser' => $dataUser,
            'dataGold' => $dataGold,
            'dataUserInfos' => $dataUserInfos,
            'dataRegimes' => $dataRegimes,
            'dataCodes' => $dataCodes,
            'objectifsStats' => $objectifsStats 
        ]);
    }

    public function crud_regime(): string{
        $regimeModel = new RegimeModel();
        $searchTerm = $this->request->getGet('search');
        $regimes = $regimeModel->getAllInfosRegimes($searchTerm);
        return view('Modal-BO', [
            'page' => 'pages/bo-crud-regime',
            'regimes' => $regimes,
            'title' => 'Régimes'
        ]);
    }

    public function crud_sport(): string{
        return view('Modal-BO', [
            'page' => 'pages/bo-crud-sport',
            'title' => 'Sports'
        ]);
    }

    public function crud_code(): string{
        return view('Modal-BO', ['page' => 'pages/bo-crud-code']);
    }

    public function crud_user(){
        $userModel = new UserModel();
        $searchTerm = $this->request->getGet('search');
        
        // Récupérer les utilisateurs avec recherche
        $dataUserInfos = $userModel->getInfosGeneralesUsers(null, $searchTerm);
        
        // Calculer les statistiques
        $dataUser = count($dataUserInfos);
        $dataGold = count(array_filter($dataUserInfos, fn($u) => $u['statut'] === 'Gold'));
        $soldePortefeuille = array_sum(array_column($dataUserInfos, 'solde_portefeuille'));
        $imcMoyen = array_sum(array_column($dataUserInfos, 'imc')) / max($dataUser, 1);
        
        // Statistiques pour les graphiques
        $objectifStats = $this->calculateGoalStats($dataUserInfos);
        $imcStats = $this->calculateImcStats($dataUserInfos);
        
        return view('Modal-BO', [
            'page' => 'pages/bo-crud-user',
            'title' => 'Utilisateurs',
            'dataUser' => $dataUser,
            'dataGold' => $dataGold,
            'dataUserInfos' => $dataUserInfos,
            'soldePortefeuille' => $soldePortefeuille,
            'imcMoyen' => $imcMoyen,
            'objectifStats' => $objectifStats,
            'imcStats' => $imcStats,
            'searchTerm' => $searchTerm
        ]);
    }

    private function calculateGoalStats($users)
    {
        $stats = ['reduce' => 0, 'increase' => 0, 'ideal' => 0];
        foreach($users as $user) {
            $objectif = $user['objectif'];
            if(strpos($objectif, 'Réduire') !== false) $stats['reduce']++;
            elseif(strpos($objectif, 'Augmenter') !== false) $stats['increase']++;
            elseif(strpos($objectif, 'IMC idéal') !== false) $stats['ideal']++;
        }
        return $stats;
    }
    
    private function calculateImcStats($users)
    {
        $stats = ['faible' => 0, 'normal' => 0, 'surpoids' => 0, 'obese' => 0];
        foreach($users as $user) {
            $imc = $user['imc'];
            if($imc < 18.5) $stats['faible']++;
            elseif($imc < 25) $stats['normal']++;
            elseif($imc < 30) $stats['surpoids']++;
            else $stats['obese']++;
        }
        return $stats;
    }
    
    public function viewUser($id)
    {
        $userModel = new UserModel();
        $user = $userModel->getUserById($id);
        
        if(!$user) {
            return redirect()->to('/backoffice')->with('error', 'Utilisateur non trouvé');
        }
        
        return view('Modal-BO', [
            'page' => 'pages/bo-view-user',
            'user' => $user
        ]);
    }
    
    public function deleteUser($id)
    {
        $userModel = new UserModel();
        $userModel->delete($id);
        
        return redirect()->to('/backoffice')->with('success', 'Utilisateur supprimé');
    }

    public function deleteUserAjax($id)
    {
        if ($this->request->isAJAX()) {
            $userModel = new UserModel();
            
            try {
                $userModel->delete($id);
                return $this->response->setJSON([
                    'success' => true,
                    'message' => 'Utilisateur supprimé avec succès'
                ]);
            } catch (\Exception $e) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Erreur lors de la suppression: ' . $e->getMessage()
                ]);
            }
        }
        
        return $this->response->setStatusCode(400)->setJSON([
            'success' => false,
            'message' => 'Requête invalide'
        ]);
    }

    public function deleteRegimeAjax($id)
    {
        if ($this->request->isAJAX()) {
            $regimeModel = new RegimeModel();
            
            try {
                $regimeModel->delete($id);
                return $this->response->setJSON([
                    'success' => true,
                    'message' => 'Régime supprimé avec succès'
                ]);
            } catch (\Exception $e) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Erreur lors de la suppression: ' . $e->getMessage()
                ]);
            }
        }
        
        return $this->response->setStatusCode(400)->setJSON([
            'success' => false,
            'message' => 'Requête invalide'
        ]);
    }

    public function getRegimeAjax($id)
    {
        if ($this->request->isAJAX()) {
            $regimeModel = new RegimeModel();
            $regime = $regimeModel->getRegimeById($id);
            
            if ($regime) {
                return $this->response->setJSON([
                    'success' => true,
                    'regime' => $regime
                ]);
            } else {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Régime non trouvé'
                ]);
            }
        }
        
        return $this->response->setStatusCode(400)->setJSON([
            'success' => false,
            'message' => 'Requête invalide'
        ]);
    }

    public function createRegimeAjax()
    {
        if ($this->request->isAJAX()) {
            $regimeModel = new RegimeModel();
            
            $data = [
                'nom' => $this->request->getPost('nom'),
                'description' => $this->request->getPost('description'),
                'pourcentage_viande' => $this->request->getPost('pourcentage_viande'),
                'pourcentage_poisson' => $this->request->getPost('pourcentage_poisson'),
                'pourcentage_volaille' => $this->request->getPost('pourcentage_volaille')
            ];
            
            // Validation basique
            if (empty($data['nom']) || empty($data['description'])) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Le nom et la description sont obligatoires'
                ]);
            }
            
            try {
                $regimeId = $regimeModel->insert($data);
                
                if ($regimeId) {
                    // Insérer les données de prix et durée si fournies
                    $prixData = [
                        'id_regime' => $regimeId,
                        'duree_semaines' => $this->request->getPost('duree_semaines'),
                        'prix' => $this->request->getPost('prix'),
                        'variation_poids' => $this->request->getPost('variation_min') . ' à ' . $this->request->getPost('variation_max')
                    ];
                    
                    $this->db->table('regimes_prix_duree')->insert($prixData);
                    
                    return $this->response->setJSON([
                        'success' => true,
                        'message' => 'Régime créé avec succès'
                    ]);
                } else {
                    return $this->response->setJSON([
                        'success' => false,
                        'message' => 'Erreur lors de la création du régime'
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

    public function updateRegimeAjax($id)
    {
        if ($this->request->isAJAX()) {
            $regimeModel = new RegimeModel();
            
            $data = [
                'nom' => $this->request->getPost('nom'),
                'description' => $this->request->getPost('description'),
                'pourcentage_viande' => $this->request->getPost('pourcentage_viande'),
                'pourcentage_poisson' => $this->request->getPost('pourcentage_poisson'),
                'pourcentage_volaille' => $this->request->getPost('pourcentage_volaille')
            ];
            
            // Validation basique
            if (empty($data['nom']) || empty($data['description'])) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Le nom et la description sont obligatoires'
                ]);
            }
            
            try {
                $updated = $regimeModel->update($id, $data);
                
                if ($updated) {
                    // Mettre à jour les données de prix et durée
                    $prixData = [
                        'duree_semaines' => $this->request->getPost('duree_semaines'),
                        'prix' => $this->request->getPost('prix'),
                        'variation_poids' => $this->request->getPost('variation_min') . ' à ' . $this->request->getPost('variation_max')
                    ];
                    
                    $this->db->table('regimes_prix_duree')
                             ->where('id_regime', $id)
                             ->update($prixData);
                    
                    return $this->response->setJSON([
                        'success' => true,
                        'message' => 'Régime mis à jour avec succès'
                    ]);
                } else {
                    return $this->response->setJSON([
                        'success' => false,
                        'message' => 'Erreur lors de la mise à jour du régime'
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
