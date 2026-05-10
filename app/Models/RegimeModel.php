<?php

namespace App\Models;

use CodeIgniter\Model;

class RegimeModel extends Model{
    protected $table = 'regimes';
    protected $primaryKey = 'id';
    protected $allowedFields = ['nom', 'description', 'pourcentage_viande', 'pourcentage_poisson', 'pourcentage_volaille'];
    protected $useTimestamps = true;

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

    /**
     * Suggestions de régimes : on rapproche rpd.variation_poids (kg sur la durée du pack)
     * de la variation souhaitée (même signe : +prise, -perte, 0 pour équilibre / IMC idéal).
     */
    public function getRecommendedPlansByObjectifAndVariation(int $objectifId, float $variationSouhaitee, int $limit = 3): array
    {
        $cible = round($variationSouhaitee, 2);

        $builder = $this->db->table('regimes r');
        $builder->select(
            'r.id, r.nom, r.description, r.pourcentage_viande, r.pourcentage_poisson, r.pourcentage_volaille, ' .
            'rpd.duree_semaines, rpd.variation_poids, rpd.prix'
        );
        $builder->join('regimes_prix_duree rpd', 'r.id = rpd.id_regime', 'inner');

        if ($objectifId === 1) {
            $builder->where('rpd.variation_poids >', 0);
        } elseif ($objectifId === 2) {
            $builder->where('rpd.variation_poids <', 0);
        }

        $builder->orderBy('ABS(rpd.variation_poids - ' . $cible . ')', 'ASC', false);
        $builder->limit($limit);

        return $builder->get()->getResultArray();
    }
}