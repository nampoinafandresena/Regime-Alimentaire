<?php

namespace App\Models;

use CodeIgniter\Model;
class CodeModel extends Model{
    protected $table = 'codes_portefeuille';
    protected $primaryKey = 'id';
    protected $allowedFields = ['code', 'montant', 'est_valide', 'date_expiration', 'created_at', 'updated_at'];
    protected $useTimestamps = false;

    public function getAllCodes(){
        return $this->orderBy('id', 'DESC')->findAll();
    }

    public function getCodesWithUsers($search = null, $statut = null){
        $sql = "SELECT codes_portefeuille.id, codes_portefeuille.code, codes_portefeuille.montant, codes_portefeuille.est_valide, codes_portefeuille.created_at, codes_portefeuille.date_expiration,
                       cu.id_utilisateur, cu.date_utilisation_code,
                       u.nom as utilisateur_nom, u.email as utilisateur_email
                FROM codes_portefeuille
                LEFT JOIN code_users cu ON codes_portefeuille.id = cu.id_code
                LEFT JOIN utilisateurs u ON cu.id_utilisateur = u.id";
        
        $where = [];
        if ($search) {
            $where[] = "codes_portefeuille.code LIKE '%" . $this->db->escapeLikeString($search) . "%'";
        }
        if ($statut !== null && $statut !== '') {
            if ($statut === 'valide') {
                $where[] = "codes_portefeuille.est_valide = 1 AND cu.id_utilisateur IS NOT NULL";
            } elseif ($statut === 'attente') {
                $where[] = "codes_portefeuille.est_valide = 1 AND cu.id_utilisateur IS NULL";
            } elseif ($statut === 'expire') {
                $where[] = "codes_portefeuille.est_valide = 0";
            }
        }
        
        if (!empty($where)) {
            $sql .= " WHERE " . implode(" AND ", $where);
        }
        
        $sql .= " ORDER BY codes_portefeuille.id DESC";
        
        $query = $this->db->query($sql);
        return $query->getResultArray();
    }

    public function countAllCodes(){
        return $this->countAllResults();
    }

    public function countValidatedCodes(){
        return $this->where('est_valide', 1)
                    ->where('id IN (SELECT DISTINCT id_code FROM code_users)', null, false)
                    ->countAllResults();
    }

    public function countAvailableCodes(){
        return $this->where('est_valide', 1)
                    ->where('id NOT IN (SELECT DISTINCT id_code FROM code_users)', null, false)
                    ->countAllResults();
    }

    public function createCode($code, $montant, $dateExpiration = null){
        return $this->insert([
            'code' => $code,
            'montant' => $montant,
            'est_valide' => 1,
            'date_expiration' => $dateExpiration
        ]);
    }

    private function generateUniqueCode(){
        $prefix = 'NUTR-';
        $code = $prefix . strtoupper(substr(bin2hex(random_bytes(4)), 0, 6));
        
        // Vérifier l'unicité
        while ($this->where('code', $code)->first()) {
            $code = $prefix . strtoupper(substr(bin2hex(random_bytes(4)), 0, 6));
        }
        return $code;
    }

    public function getCodeById($id){
        return $this->find($id);
    }

    public function updateCode($id, $data){
        return $this->update($id, $data);
    }

    public function deleteCode($id){
        // Supprimer d'abord les utilisations
        $codeUserModel = new CodeUserModel();
        $codeUserModel->where('id_code', $id)->delete();
        return $this->delete($id);
    }
}