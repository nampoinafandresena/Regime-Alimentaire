<?php

namespace App\Models;

use CodeIgniter\Model;

class CodeUserModel extends Model{
    protected $table = 'code_users';
    protected $primaryKey = 'id';
    protected $allowedFields = ['id_utilisateur', 'id_code', 'date_utilisation_code'];
    protected $useTimestamps = false;

    public function getCodesByUserId($userId){
        return $this->where('id_utilisateur', $userId)->orderBy('date_utilisation_code', 'DESC')->findAll();
    }

    public function hasUsedCode($userId, $codeId){
        return $this->where('id_utilisateur', $userId)
            ->where('id_code', $codeId)
            ->first() !== null;
    }

    public function utiliserCode($userId, $codeId){
        if($this->hasUsedCode($userId, $codeId)){
            return false;
        }
        $data = [
            'id_utilisateur' => $userId,
            'id_code' => $codeId,
        ];
        return $this->insert($data);
    }
}