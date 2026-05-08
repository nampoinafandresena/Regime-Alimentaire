<?php

namespace App\Models;

use CodeIgniter\Model;

class CodeUserModel extends Model{
    protected $table = 'code_users';
    protected $primaryKey = 'id';
    protected $allowedFields = ['id_code', 'id_utilisateur', 'date_utilisation'];
    protected $useTimestamps = true;

    public function getCodesByUserId($userId){
        return $this->where('id_utilisateur', $userId)->orderBy('date_utilisation', 'DESC')->findAll();
    }

    public function CodeValideforUser($userId, $codeId){
        $alreadyUsed = $this->where('id_utilisateur', $userId)
            ->where('id_code', $codeId)
            ->first();

        return $alreadyUsed === null;
    }
}