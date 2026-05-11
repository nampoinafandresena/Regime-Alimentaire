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

    public function getChoixDetailsByUserId($userId)
    {
        return $this->db->table('choix_regimes_sport crs')
            ->select('crs.id, crs.id_utilisateur, crs.id_regime, crs.id_sport, crs.prix_precis, crs.semaine_precis, crs.date_choix')
            ->select('r.nom AS regime_nom, r.description AS regime_description')
            ->select('s.nom AS sport_nom, c.nom AS sport_categorie, i.nom AS sport_intensite')
            ->join('regimes r', 'r.id = crs.id_regime', 'left')
            ->join('sport s', 's.id = crs.id_sport', 'left')
            ->join('sport_categorie c', 'c.id = s.id_categorie', 'left')
            ->join('sport_intensite i', 'i.id = s.id_intensite', 'left')
            ->where('crs.id_utilisateur', $userId)
            ->orderBy('crs.date_choix', 'DESC')
            ->get()
            ->getResultArray();
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