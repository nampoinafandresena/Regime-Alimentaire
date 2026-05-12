<?php

namespace App\Models;

use CodeIgniter\Model;

class SportModel extends Model{
    protected $table = 'sport';
    protected $primaryKey = 'id';
    protected $allowedFields = ['nom', 'description', 'id_categorie', 'id_intensite', 'variation_poids_par_heure'];
    protected $useTimestamps = false;

    public function getAllSports(){
        return $this->findAll();
    }

    public function getAllInfosSports($filtre_nom = null, $filtre_categorie = null, $filtre_intensite = null){
        $sql = "SELECT sport.id, sport.nom, sport.description, sport.variation_poids_par_heure, 
                c.nom AS categorie, i.nom AS intensite
         FROM sport 
         INNER JOIN sport_categorie c ON sport.id_categorie = c.id
         INNER JOIN sport_intensite i ON sport.id_intensite = i.id";

        if($filtre_nom) {
            $sql .= " WHERE sport.nom LIKE '%" . $this->db->escapeLikeString($filtre_nom) . "%'";
        }
        if($filtre_categorie) {
            $sql .= " AND sport.id_categorie = " . $this->db->escape($filtre_categorie);
        }
        if($filtre_intensite) {
            $sql .= " AND sport.id_intensite = " . $this->db->escape($filtre_intensite);
        }
        $query = $this->db->query($sql);
        return $query->getResultArray();
    }

    public function getSportByCategorie($id_categorie){
        return $this->where('id_categorie', $id_categorie)->findAll();
    }

    public function getSportByIntensite($id_intensite){
        return $this->where('id_intensite', $id_intensite)->findAll();
    }

    public function createSport($data){
        return $this->insert($data);
    }

    public function updateSport($id, $data){
        return $this->update($id, $data);
    }

    public function deleteSport($id){
        return $this->delete($id);
    }

    public function getSportById($id){
        return $this->find($id);
    }
}