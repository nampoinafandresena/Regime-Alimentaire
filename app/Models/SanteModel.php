<?php

namespace App\Models;

use CodeIgniter\Model;

class SanteModel extends Model{
    protected $table = 'donnees_sante';
    protected $primaryKey = 'id';
    protected $allowedFields = ['id_utilisateur', 'taille_cm', 'poids_kg', 'date_mesure'];
    protected $useTimestamps = true;

    public function getSanteByUserId($userId){
        return $this->where('id_utilisateur', $userId)->orderBy('date_mesure', 'DESC')->findAll();
    }
}