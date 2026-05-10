<?php

namespace App\Models;

use CodeIgniter\Model;

class ActiviteSportiveModel extends Model
{
    protected $table = 'sport';
    protected $primaryKey = 'id';
    protected $allowedFields = ['nom', 'description', 'id_categorie', 'id_intensite', 'variation_poids_par_heure'];
    protected $useTimestamps = true;


    public function getRecommendedByObjectifAndVariation(float $variationSouhaitee, int $limit = 3): array
    {
        $cible = round($variationSouhaitee, 4);

        $builder = $this->db->table('sport s');
        $builder->select(
            's.id, s.nom, s.description, s.variation_poids_par_heure, ' .
            'sc.nom AS categorie, si.nom AS intensite'
        );
        $builder->join('sport_categorie sc', 's.id_categorie = sc.id', 'inner');
        $builder->join('sport_intensite si', 's.id_intensite = si.id', 'inner');

        $builder->orderBy('ABS(s.variation_poids_par_heure - ' . $cible . ')', 'ASC', false);

        return $builder->limit($limit)->get()->getResultArray();
    }
}
