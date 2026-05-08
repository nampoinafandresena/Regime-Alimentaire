<?php

namespace App\Models;

use CodeIgniter\Model;

class RegimePrixModel extends Model{
    protected $table = 'regimes_prix_duree';
    protected $primaryKey = 'id';
    protected $allowedFields = ['id_regime', 'duree_semaines', 'variation_poids', 'prix'];
    protected $useTimestamps = true;

    public function getPrixByRegimeId($regimeId){
        return $this->where('id_regime', $regimeId)->first();
    }

    public function PrixRemiseForUserGold($regimeId, $userId){
        $prix = $this->getPrixByRegimeId($regimeId);
        $userModel = new UserModel();
        $user = $userModel->find($userId);
        if($user['est_gold']){
            return $prix * 0.85;
        }
        else{
            return $prix = $this->getPrixByRegimeId($regimeId);
        }
    }
}