<?php

namespace App\Models;

use CodeIgniter\Model;

class UserObjectifModel extends Model{
    protected $table = 'utilisateurs_objectifs';
    protected $primaryKey = 'id';
    protected $allowedFields = ['id_utilisateur', 'id_objectif'];
    protected $useTimestamps = false;

    public function getAllUserObjectif(){
        return $this->findAll();
    }

    public function deleteUserObjectif($id){
        return $this->delete($id);
    }

    public function getObjectifsByUserId($userId){
        return $this->where('id_utilisateur', $userId)->findAll();
    }

    public function getObjectifIdsByUserId($userId){
        $rows = $this->select('id_objectif')->where('id_utilisateur', $userId)->findAll();
        return array_map(static fn ($row) => (int) $row['id_objectif'], $rows);
    }

    public function insertObjectifForUser($userId, $objectifId){
        $currentCount = $this->where('id_utilisateur', $userId)->countAllResults();
        if($currentCount >= 3){
            return false;
        }
        return $this->insert([
            'id_utilisateur' => $userId,
            'id_objectif' => $objectifId
        ]);
    }

    public function updateUserObjectif($id, $data){
        return $this->update($id, $data);
    }
}