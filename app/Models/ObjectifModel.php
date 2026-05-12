<?php

namespace App\Models;

use CodeIgniter\Model;

class ObjectifModel extends Model{
    protected $table = 'objectifs';
    protected $primaryKey = 'id';
    protected $allowedFields = ['libelle'];
    protected $useTimestamps = true;

    public function getAllObjectif(){
        return $this->findAll();
    }

    public function getObjectifsStatistics(){
        $sql = "
            SELECT 
                objectifs.id,
                objectifs.libelle,
                COUNT(uo.id_utilisateur) as total
            FROM objectifs
            LEFT JOIN utilisateurs_objectifs uo ON objectifs.id = uo.id_objectif
            GROUP BY objectifs.id, objectifs.libelle
            ORDER BY total DESC
        ";
        
        $query = $this->db->query($sql);
        $results = $query->getResultArray();
        
        $totalGlobal = array_sum(array_column($results, 'total'));
        
        foreach($results as &$row) {
            $row['pourcentage'] = $totalGlobal > 0 
                ? round(($row['total'] / $totalGlobal) * 100, 0) 
                : 0;
        }
        
        return [
            'data' => $results,
            'total' => $totalGlobal
        ];
    }
    
}