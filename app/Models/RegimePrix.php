<?php

namespace App\Models;

use CodeIgniter\Model;

class RegimePrixModel extends Model{
    protected $table = 'regimes_prix_duree';
    protected $primaryKey = 'id';
    protected $allowedFields = ['id_regime', 'duree_semaines', 'variation_poids', 'prix'];
    protected $useTimestamps = true;

    public function getAllRegimePrix(){
        return $this->orderBy('prix', 'ASC')->findAll();
    }

    public function getPrixByRegimeId($regimeId){
        return $this->where('id_regime', $regimeId)->first();
    }

    public function PrixRemiseForUserGold($userId){
        $prix = $this->getAllRegimePrix();
        $userModel = new UserModel();
        $user = $userModel->find($userId);
        if($user['est_gold']){
            foreach($prix as &$ligne){
                if(isset($ligne['prix'])){
                    $ligne['prix'] = $ligne['prix'] * 0.85;
                }
            }
            unset($ligne);
            return $prix;
        }
        else{
            return $prix = $this->getAllRegimePrix();
        }
    }
}