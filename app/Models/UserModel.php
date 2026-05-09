<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model{

    protected $table = 'utilisateurs';
    protected $primaryKey = 'id';
    protected $allowedFields = ['nom', 'genre' ,'email', 'mot_de_passe', 'role', 'est_gold', 'solde_portefeuille'];
    protected $useTimestamps = false;

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

    public function countUser(){
        return $this->countAllResults();
    }
    
    public function countGoldUsers(){
        return $this->where('est_gold', 1)->countAllResults();
    }

    public function getTotalWallet(){
        return $this->selectSum('solde_portefeuille')->first()['solde_portefeuille'];
    }

    public function getInfosGeneralesUsers($limit = null, $search = null, $order = null)
    {
        $sql = "
            SELECT 
                utilisateurs.id,
                utilisateurs.nom, 
                utilisateurs.email, 
                utilisateurs.genre, 
                CONCAT(ds.taille_cm, ' cm / ', ds.poids_kg, ' kg') AS taille_poids, 
                ROUND(ds.poids_kg / POWER(ds.taille_cm/100, 2), 2) AS imc, 
                o.libelle AS objectif, 
                utilisateurs.solde_portefeuille, 
                CASE WHEN utilisateurs.est_gold = 1 THEN 'Gold' ELSE 'Standard' END AS statut 
            FROM utilisateurs 
            INNER JOIN donnees_sante ds ON utilisateurs.id = ds.id_utilisateur 
            INNER JOIN utilisateurs_objectifs uo ON utilisateurs.id = uo.id_utilisateur 
            INNER JOIN objectifs o ON uo.id_objectif = o.id
            WHERE ds.date_mesure = (
                SELECT MAX(date_mesure) 
                FROM donnees_sante ds2 
                WHERE ds2.id_utilisateur = utilisateurs.id
            )
        ";
        
        if($search) {
            $sql .= " AND (utilisateurs.nom LIKE '%" . $this->db->escapeLikeString($search) . "%' 
                    OR utilisateurs.email LIKE '%" . $this->db->escapeLikeString($search) . "%')";
        }
        
        if ($limit !== null) {
            $sql .= " LIMIT " . (int)$limit;
        }
        

        if ($order == "DESC") {
            $sql .= " ORDER BY utilisateurs.id DESC";
        } 
        
        $query = $this->db->query($sql);
        return $query->getResultArray();
    }

}