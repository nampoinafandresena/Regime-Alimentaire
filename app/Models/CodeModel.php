<?php

namespace App\Models;

use CodeIgniter\Model;

class CodeModel extends Model{
    protected $table = 'code_portefeuille';
    protected $primaryKey = 'id';
    protected $allowedFields = ['code', 'montant', 'est_valide'];
    protected $useTimestamps = true;

    public function getAllCodes(){
        return $this->findAll();
    }
}