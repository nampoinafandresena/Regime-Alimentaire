<?php

namespace App\Models;

use CodeIgniter\Model;

class ObjectifModel extends Model{
    protected $table = 'objectifs';
    protected $primaryKey = 'id';
    protected $allowedFields = ['libelle'];
    protected $userTimestamps = true;

    public function getAllObjectif(){
        return $this->findAll();
    }
    
}