<?php

namespace App\Models;

use CodeIgniter\Model;

class AchatGoldModel extends Model{
    protected $table = 'achats_gold';
    protected $primaryKey = 'id';
    protected $allowedFields = ['id_utilisateur', 'date_achat', 'montant_paye'];
    protected $useTimestamps = true;

    public function getAchatsByUserId($userId){
        return $this->where('id_utilisateur', $userId)->orderBy('date_achat', 'DESC')->findAll();
    }

    public function getTotalGoldByUserId($userId){
        return $this->where('id_utilisateur', $userId)->selectSum('montant_paye')->first();
    }

    public function AcheterGold($userId, $montant){
        $data = [
            'id_utilisateur' => $userId,
            'montant_paye' => $montant,
        ];
        return $this->insert($data);
    }
}