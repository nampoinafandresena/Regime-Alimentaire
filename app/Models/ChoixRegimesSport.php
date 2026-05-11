<?php

namespace app\Models;

class ChoixRegimesSport extends BaseModel
{
    protected $table = 'choix_regime_sport';
    protected $primaryKey = 'id';
    protected $allowedFields = ['id_utilisateur', 'id_regime', 'id_sport', 'date_choix'];

    public function getChoixByUserId($userId){
        return $this->where('id_utilisateur', $userId)->findAll();
    }

    

}