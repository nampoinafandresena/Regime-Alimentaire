<?php

namespace App\Models;

use CodeIgniter\Model;

class OptionGoldModel extends Model{
    protected $table = 'options_gold';
    protected $primaryKey = 'id';
    protected $allowedFields = ['prix', 'description'];
    protected $useTimestamps = false;

    public function getAllOptions(){
        return $this->orderBy('prix', 'ASC')->findAll();
    }
}
