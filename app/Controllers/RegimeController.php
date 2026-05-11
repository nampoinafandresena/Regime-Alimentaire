<?php

namespace App\Controllers;
use App\Models\ActiviteSportiveModel;
use App\Models\ObjectifModel;
use App\Models\RegimeModel;
use App\Models\UserObjectifModel;
use App\Models\UserModel;

class RegimeController extends BaseController
{
    public function index()
    {
        $userModel = new UserModel();
        $user = session()->get('user');
        if (!$user) {
            return redirect()->to('/formulaire');
        }

        $user = $userModel->find($user['id']) ?? $user;

        $poids = $userModel->getPoidsTailleActuel($user['id']);
        $poidsKg = $poids['poids_kg'] ?? 0;
        $tailleCm = $poids['taille_cm'] ?? 0;

        $objectifModel = new ObjectifModel();
        $userObjectifModel = new UserObjectifModel();
        $regimeModel = new RegimeModel();
        $activiteModel = new ActiviteSportiveModel();

        $objectifs = $objectifModel->findAll();
        $defaultObjectifId = $objectifs[0]['id'] ?? 1;

        $userObjectifs = $userObjectifModel->getObjectifsByUserId((int) $user['id']);
        if (!empty($userObjectifs)) {
            $latest = end($userObjectifs);
            $defaultObjectifId = (int) ($latest['id_objectif'] ?? $defaultObjectifId);
        }

        $selectedObjectifId = (int) $this->request->getPost('objectif_id');
        if ($selectedObjectifId <= 0) {
            $selectedObjectifId = $defaultObjectifId;
        }

        $variationKgSaisie = $this->request->getPost('variation_kg');
        $variationKg = is_numeric($variationKgSaisie) ? (float) $variationKgSaisie : 5.0;
        $variationKg = abs($variationKg);
        if ($variationKg < 0.1) {
            $variationKg = 0.1;
        }

        $tailleM = $tailleCm > 0 ? $tailleCm / 100 : 0;

        // Cible alignée sur regimes_prix_duree.variation_poids (+ = prise, - = perte)
        $variationSouhaitee = 0.0;
        if ($selectedObjectifId === 1) {
            $variationSouhaitee = $variationKg;
        } elseif ($selectedObjectifId === 2) {
            $variationSouhaitee = -$variationKg;
        } else {
            // IMC idéal : calculer le poids à atteindre pour être entre 18.5 et 24.9
            if ($tailleM > 0) {
                $poidsMinIdeal = 18.5 * $tailleM * $tailleM;
                $poidsMaxIdeal = 24.9 * $tailleM * $tailleM;

                if ($poidsKg < $poidsMinIdeal) {
                    $variationSouhaitee = $poidsMinIdeal - $poidsKg;
                } elseif ($poidsKg > $poidsMaxIdeal) {
                    $variationSouhaitee = -($poidsKg - $poidsMaxIdeal);
                } else {
                    $variationSouhaitee = 0.0;
                }

                $variationKg = abs($variationSouhaitee);
            } else {
                $variationSouhaitee = 0.0;
            }
        }

        // Même valeur de comparaison pour le tri sport : ABS(s.variation_poids_par_heure - variationSouhaitee)
        $recommendedRegimesRaw = $regimeModel->getRecommendedPlansByObjectifAndVariation($selectedObjectifId, $variationSouhaitee, 12);
        $uniqueRegimes = [];
        foreach ($recommendedRegimesRaw as $regime) {
            $regimeId = (int) ($regime['id'] ?? 0);
            if ($regimeId && !isset($uniqueRegimes[$regimeId])) {
                $uniqueRegimes[$regimeId] = $regime;
            }
            if (count($uniqueRegimes) >= 3) {
                break;
            }
        }
        $recommendedRegimes = array_values($uniqueRegimes);

        $isGold = (int) ($user['est_gold'] ?? 0) === 1;
        $cibleVariation = abs($variationKg);
        foreach ($recommendedRegimes as &$regime) {
            $baseVariation = (float) ($regime['variation_poids'] ?? 0);
            $baseAbs = abs($baseVariation);
            $ratio = ($baseAbs > 0 && $cibleVariation > 0) ? ($cibleVariation / $baseAbs) : 1.0;
            $regime['duree_semaines_calculee'] = round(((float) ($regime['duree_semaines'] ?? 0)) * $ratio, 1);
            $prixCalcule = round(((float) ($regime['prix'] ?? 0)) * $ratio, 0);
            $regime['prix_initial'] = $prixCalcule;
            $regime['prix_calcule'] = $isGold ? round($prixCalcule * 0.85, 0) : $prixCalcule;
        }
        unset($regime);
        $suggestedActivities = $activiteModel->getRecommendedByObjectifAndVariation($variationSouhaitee, 3);

        $objectifLabel = 'Objectif non defini';
        foreach ($objectifs as $objectif) {
            if ((int) $objectif['id'] === $selectedObjectifId) {
                $objectifLabel = $objectif['libelle'];
                break;
            }
        }

    $imc = $tailleM > 0 ? round($poidsKg / ($tailleM * $tailleM), 1) : null;

        return view('Modal', [
            'page' => 'pages/Regime',
            'user' => $user,
            'poids' => $poidsKg,
            'taille' => $tailleCm,
            'imc' => $imc,
            'objectifs' => $objectifs,
            'selectedObjectifId' => $selectedObjectifId,
            'variationKg' => $variationKg,
            'variationSouhaitee' => $variationSouhaitee,
            'objectifLabel' => $objectifLabel,
            'recommendedRegimes' => $recommendedRegimes,
            'suggestedActivities' => $suggestedActivities,
        ]);
    }
}
