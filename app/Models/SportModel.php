<?php

namespace App\Models;

use CodeIgniter\Model;

class SportModel extends Model{
    protected $table = 'activites_sportives';
    protected $primaryKey = 'id';
    protected $allowedFields = ['nom', 'variation_poids_par_heure'];
    protected $useTimestamps = true;

    public function getAllSports(){
        return $this->findAll();
    }
}