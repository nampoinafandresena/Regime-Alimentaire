<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model{

    protected $table = 'utilisateurs';
    protected $primaryKey = 'id';
    protected $allowedFields = ['nom', 'genre' ,'email', 'mot_de_passe', 'role', 'est_gold', 'solde_portefeuille'];
    protected $useTimestamps = true;

    protected $validationRules = [
        'nom' => 'required[min_length[3]]',
        'genre' => 'required[in_list[Homme,Femme,Autre]]',
        'email' => 'required[required|valid_email]',
        'mot_de_passe' => 'required[min_length[6]]',
        'role' => 'required|in_list[user,admin]',
        'est_gold' => 'required|in_list[0,1]',
        'solde_portefeuille' => 'required|decimal[2]'
    ];

    public function getUserByEmail($email){
        return $this->where('email', $email)->first();
    }

    public function createUser($data){
        $data['mot_de_passe'] = password_hash($data['mot_de_passe'], PASSWORD_DEFAULT);
        return $this->insert($data);
    }

}