<?php

namespace App\Models;

use CodeIgniter\Model;

class CategoriesSportModel extends Model{
    protected $table = 'sport_categorie';
    protected $primaryKey = 'id';
    protected $allowedFields = ['nom'];
    protected $useTimestamps = false;
}