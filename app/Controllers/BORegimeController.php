<?php

namespace App\Controllers;

use App\Models\RegimeModel;

class BORegimeController extends BaseController
{
    public function index()
    {
        $model = new RegimeModel();
        $regimes = $model->findAll();
        return view('backoffice/regimes', ['regimes' => $regimes]);
    }

    public function crud_regime(): string
    {
        $regimeModel = new RegimeModel();
        $searchTerm = $this->request->getGet('search');
        $regimes = $regimeModel->getAllInfosRegimes($searchTerm);
        return view('Modal-BO', [
            'page' => 'pages/bo-crud-regime',
            'regimes' => $regimes,
            'title' => 'Régimes'
        ]);
    }

    public function deleteRegimeAjax($id)
    {
        if ($this->request->isAJAX()) {
            $regimeModel = new RegimeModel();
            $db = \Config\Database::connect();

            try {
                $db->transStart();

                $db->table('regimes_prix_duree')
                    ->where('id_regime', $id)
                    ->delete();

                $regimeModel->delete($id);

                $db->transComplete();

                if ($db->transStatus() === false) {
                    throw new \RuntimeException('La suppression a échoué.');
                }

                return $this->response->setJSON([
                    'success' => true,
                    'message' => 'Régime supprimé avec succès'
                ]);
            } catch (\Exception $e) {
                if ($db->transStatus() !== null) {
                    $db->transRollback();
                }

                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Erreur lors de la suppression: ' . $e->getMessage()
                ]);
            }
        }

        return $this->response->setStatusCode(400)->setJSON([
            'success' => false,
            'message' => 'Requête invalide'
        ]);
    }

    public function getRegimeAjax($id)
    {
        if ($this->request->isAJAX()) {
            $regimeModel = new RegimeModel();
            $regime = $regimeModel->getRegimeById($id);

            if ($regime) {
                return $this->response->setJSON([
                    'success' => true,
                    'regime' => $regime
                ]);
            } else {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Régime non trouvé'
                ]);
            }
        }

        return $this->response->setStatusCode(400)->setJSON([
            'success' => false,
            'message' => 'Requête invalide'
        ]);
    }

    public function createRegimeAjax()
    {
        if ($this->request->isAJAX()) {
            $regimeModel = new RegimeModel();
            $payload = $this->request->getJSON(true) ?? [];

            $data = [
                'nom' => trim((string) ($payload['nom'] ?? '')),
                'description' => trim((string) ($payload['description'] ?? '')),
                'pourcentage_viande' => (float) ($payload['pourcentage_viande'] ?? 0),
                'pourcentage_poisson' => (float) ($payload['pourcentage_poisson'] ?? 0),
                'pourcentage_volaille' => (float) ($payload['pourcentage_volaille'] ?? 0)
            ];

            // Validation basique
            if (empty($data['nom']) || empty($data['description'])) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Le nom et la description sont obligatoires'
                ]);
            }

            try {
                $inserted = $regimeModel->insert($data);

                if ($inserted) {
                    $regimeId = $regimeModel->getInsertID();
                    
                    // Récupérer et valider les données de prix/durée
                    $duree = (int) ($payload['duree_semaines'] ?? 0);
                    $prix = (float) ($payload['prix'] ?? 0);
                    $variation = (float) ($payload['variation_poids'] ?? 0);

                    if (!$duree || !$prix) {
                        return $this->response->setJSON([
                            'success' => false,
                            'message' => 'Durée et prix sont obligatoires'
                        ]);
                    }

                    // Insérer dans regimes_prix_duree
                    $db = \Config\Database::connect();
                    $result = $db->table('regimes_prix_duree')->insert([
                        'id_regime' => $regimeId,
                        'duree_semaines' => $duree,
                        'prix' => $prix,
                        'variation_poids' => $variation
                    ]);

                    if (!$result) {
                        log_message('error', 'Insert regimes_prix_duree failed. ID: ' . $regimeId);
                        return $this->response->setJSON([
                            'success' => false,
                            'message' => 'Erreur lors de l\'insertion des prix'
                        ]);
                    }

                    return $this->response->setJSON([
                        'success' => true,
                        'message' => 'Régime créé avec succès'
                    ]);
                } else {
                    return $this->response->setJSON([
                        'success' => false,
                        'message' => 'Erreur lors de la création du régime'
                    ]);
                }
            } catch (\Exception $e) {
                log_message('error', 'Erreur création régime: ' . $e->getMessage() . ' | Trace: ' . $e->getTraceAsString());
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Erreur : ' . $e->getMessage()
                ]);
            }
        }

        return $this->response->setStatusCode(400)->setJSON([
            'success' => false,
            'message' => 'Requête invalide'
        ]);
    }

    public function updateRegimeAjax($id)
    {
        if ($this->request->isAJAX()) {
            $regimeModel = new RegimeModel();
            $payload = $this->request->getJSON(true) ?? [];

            $data = [
                'nom' => trim((string) ($payload['nom'] ?? '')),
                'description' => trim((string) ($payload['description'] ?? '')),
                'pourcentage_viande' => (float) ($payload['pourcentage_viande'] ?? 0),
                'pourcentage_poisson' => (float) ($payload['pourcentage_poisson'] ?? 0),
                'pourcentage_volaille' => (float) ($payload['pourcentage_volaille'] ?? 0)
            ];

            // Validation basique
            if (empty($data['nom']) || empty($data['description'])) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Le nom et la description sont obligatoires'
                ]);
            }

            try {
                $updated = $regimeModel->update($id, $data);

                if ($updated) {
                    // Mettre à jour les données de prix et durée
                    $prixData = [
                        'duree_semaines' => (int) ($payload['duree_semaines'] ?? 0),
                        'prix' => (float) ($payload['prix'] ?? 0),
                        'variation_poids' => (float) ($payload['variation_poids'] ?? 0)
                    ];

                    $db = \Config\Database::connect();
                    $updatedPrix = $db->table('regimes_prix_duree')
                        ->where('id_regime', $id)
                        ->update($prixData);

                    if (! $updatedPrix) {
                        return $this->response->setJSON([
                            'success' => false,
                            'message' => 'Erreur lors de la mise à jour des prix et de la durée'
                        ]);
                    }

                    return $this->response->setJSON([
                        'success' => true,
                        'message' => 'Régime mis à jour avec succès'
                    ]);
                } else {
                    return $this->response->setJSON([
                        'success' => false,
                        'message' => 'Erreur lors de la mise à jour du régime'
                    ]);
                }
            } catch (\Exception $e) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Erreur lors de la mise à jour: ' . $e->getMessage()
                ]);
            }
        }

        return $this->response->setStatusCode(400)->setJSON([
            'success' => false,
            'message' => 'Requête invalide'
        ]);
    }
}
