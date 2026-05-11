<?php

namespace app\Models;
use CodeIgniter\Model;
class ChoixRegimesSport extends Model
{
    protected $table = 'choix_regimes_sport';
    protected $primaryKey = 'id';
    protected $allowedFields = ['id_utilisateur', 'id_regime', 'id_sport', 'prix_precis', 'semaine_precis', 'date_choix'];

    public function getChoixByUserId($userId){
        return $this->where('id_utilisateur', $userId)->findAll();
    }

    // inserer plusieurs regime en meme temps pour un sport donné
    public function insertAll($regimeIds, $sportId, $regimePrices = [], $regimeWeeks = []){
        $userId = session()->get('user')['id'] ?? null;
        if (!$userId) {
            return false; // ou gérer l'erreur comme vous le souhaitez
        }

        $data = [];
        foreach ($regimeIds as $regimeId) {
            $data[] = [
                'id_utilisateur' => $userId,
                'id_regime' => $regimeId,
                'id_sport' => $sportId,
                'prix_precis' => $regimePrices[$regimeId] ?? null,
                'semaine_precis' => $regimeWeeks[$regimeId] ?? null
            ];
        }

        return $this->insertBatch($data);
    }

    

}