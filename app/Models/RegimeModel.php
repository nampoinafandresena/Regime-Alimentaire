<?php

namespace App\Models;

use CodeIgniter\Model;

class RegimeModel extends Model{
    protected $table = 'regimes';
    protected $primaryKey = 'id';
    protected $allowedFields = ['nom', 'description', 'pourcentage_viande', 'pourcentage_poisson', 'pourcentage_volaille'];
    protected $useTimestamps = true;

    public function getAllRegimes(){
        return $this->findAll();
    }
    
    public function countActiveRegimes(){
        return $this->countAllResults();
    }

}