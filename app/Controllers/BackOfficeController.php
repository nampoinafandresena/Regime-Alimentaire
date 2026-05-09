<?php

namespace App\Controllers;
use App\Models\UserModel;
use App\Models\RegimeModel;
use App\Models\CodeModel;

class BackOfficeController extends BaseController
{
    public function index(){
        $userModel = new UserModel();
        $dataUser = $userModel->countUser();
        $dataGold = $userModel->countGoldUsers();
        $dataUserInfos = $userModel->getInfosGeneralesUsers(5, null, null);
        $regimeModel = new RegimeModel();
        $dataRegimes = $regimeModel->countActiveRegimes();
        $codeModel = new CodeModel();
        $dataCodes = $codeModel->countValidatedCodes();
        return view('Modal-BO', [
            'page' => 'pages/bo-dashboard', 
            'dataUser' => $dataUser,
            'dataGold' => $dataGold,
            'dataUserInfos' => $dataUserInfos,
            'dataRegimes' => $dataRegimes,
            'dataCodes' => $dataCodes
        ]);
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
}
