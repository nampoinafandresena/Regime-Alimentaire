<?php

namespace App\Models;

use CodeIgniter\Model;

class IntensitesSportModel extends Model{
    protected $table = 'sport_intensite';
    protected $primaryKey = 'id';
    protected $allowedFields = ['nom'];
    protected $useTimestamps = false;
}