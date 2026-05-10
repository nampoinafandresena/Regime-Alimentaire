<?php

namespace App\Models;

use CodeIgniter\Model;

class SanteModel extends Model{
    protected $table = 'donnees_sante';
    protected $primaryKey = 'id';
    protected $allowedFields = ['id_utilisateur', 'taille_cm', 'poids_kg', 'date_mesure'];
    protected $useTimestamps = false;

    public function getSanteByUserId($userId){
        return $this->where('id_utilisateur', $userId)->orderBy('date_mesure', 'DESC')->findAll();
    }

    public function getLatestSanteByUserId($userId){
        return $this->where('id_utilisateur', $userId)
            ->orderBy('date_mesure', 'DESC')
            ->first();
    }

    public function ajouterSante($userId, $taille, $poids){
        $data = [
            'id_utilisateur' => $userId,
            'taille_cm' => $taille,
            'poids_kg' => $poids,
        ];
        return $this->insert($data);
    }

    public function UpdateSante($santeId, $taille, $poids){
        $data = [
            'taille_cm' => $taille,
            'poids_kg' => $poids,
        ];
        return $this->update($santeId, $data);
    }
}