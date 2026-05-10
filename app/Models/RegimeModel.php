<?php

namespace App\Models;

use CodeIgniter\Model;

class RegimeModel extends Model{
    protected $table = 'regimes';
    protected $primaryKey = 'id';
    protected $allowedFields = ['nom', 'description', 'pourcentage_viande', 'pourcentage_poisson', 'pourcentage_volaille'];
    protected $useTimestamps = false;

    public function getAllRegimes(){
        return $this->findAll();
    }
    
    public function countActiveRegimes(){
        return $this->countAllResults();
    }

    public function getAllInfosRegimes($filtre_nom = null){
        $sql = "SELECT regimes.id, regimes.nom, regimes.description, regimes.pourcentage_viande, regimes.pourcentage_poisson, regimes.pourcentage_volaille, 
                COALESCE(rpd.duree_semaines, 'N/A') AS duree_semaines, 
                COALESCE(rpd.variation_poids, 'N/A') AS variation_poids, 
                COALESCE(rpd.prix, 'N/A') AS prix
         FROM regimes 
         LEFT JOIN regimes_prix_duree rpd ON regimes.id = rpd.id_regime";

        if($filtre_nom) {
            $sql .= " WHERE regimes.nom LIKE '%" . $this->db->escapeLikeString($filtre_nom) . "%'";
        }
        $query = $this->db->query($sql);
        return $query->getResultArray();
    }

    public function getRegimeById($id){
        $sql = "SELECT regimes.id, regimes.nom, regimes.description, regimes.pourcentage_viande, regimes.pourcentage_poisson, regimes.pourcentage_volaille, 
                COALESCE(rpd.duree_semaines, 'N/A') AS duree_semaines, 
                COALESCE(rpd.variation_poids, 'N/A') AS variation_poids, 
                COALESCE(rpd.prix, 'N/A') AS prix
         FROM regimes 
         LEFT JOIN regimes_prix_duree rpd ON regimes.id = rpd.id_regime
         WHERE regimes.id = ?";
        
        $query = $this->db->query($sql, [$id]);
        return $query->getRowArray();
    }

}