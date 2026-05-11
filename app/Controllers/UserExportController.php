<?php

namespace App\Controllers;

use App\Models\RegimeModel;
use App\Models\UserModel;
use App\Models\SanteModel;
use App\Models\ObjectifModel;
use App\Models\UserObjectifModel;

class UserExportController extends BaseController
{
    public function exportPlanPDF()
    {
        $sessionUser = session()->get('user');
        if (! $sessionUser || ! isset($sessionUser['id'])) {
            return redirect()->to('/formulaire');
        }

        try {

            $userId = $sessionUser['id'];
            $userModel = new UserModel();
            $santeModel = new SanteModel();
            $objectifModel = new ObjectifModel();
            $userObjectifModel = new UserObjectifModel();

            $user = $userModel->find($userId);
            $latestSante = $santeModel->getLatestSanteByUserId($userId);
            $allObjectifs = $objectifModel->findAll();
            $selectedObjectifIds = $userObjectifModel->getObjectifIdsByUserId($userId);

            $imc = null;
            if ($latestSante && (float) $latestSante['taille_cm'] > 0) {
                $tailleM = (float) $latestSante['taille_cm'] / 100;
                $imc = round((float) $latestSante['poids_kg'] / ($tailleM * $tailleM), 1);
            }


            $this->generatePDFwithFPDF($user, $latestSante, $imc, $allObjectifs, $selectedObjectifIds, $sessionUser);

        } catch (\Exception $e) {
            log_message('error', 'PDF Generation Error: ' . $e->getMessage());
            return redirect()->to('/profil')->with('errors', ['pdf' => 'Erreur lors de la génération du PDF.']);
        }
    }

    private function generatePDFwithFPDF($user, $latestSante, $imc, $allObjectifs, $selectedObjectifIds, $sessionUser)
    {

        $possiblePaths = [
            ROOTPATH . 'public/assets/fpdf.php',
            FCPATH . 'assets/fpdf.php',
            APPPATH . '../public/assets/fpdf.php',
        ];
        
            $fpdfPath = FCPATH . 'assets/fpdf186/fpdf.php';
            if (! file_exists($fpdfPath)) {
                throw new \Exception('FPDF library not found at ' . $fpdfPath);
            }
            require_once $fpdfPath;

        $pdf = new \FPDF();
        $pdf->AddPage();
        $pdf->SetFont('Arial', 'B', 16);


        $pdf->SetTextColor(22, 163, 74); 
        $pdf->Cell(0, 15, 'Mon plan actuel NutriPath', 0, 1, 'C');
        $pdf->SetFont('Arial', '', 10);
        $pdf->SetTextColor(100, 100, 100);
        $pdf->Cell(0, 8, 'Genere le ' . date('d/m/Y a H:i'), 0, 1, 'C');

        $pdf->SetDrawColor(22, 163, 74);
        $pdf->Line(10, $pdf->GetY() + 2, 200, $pdf->GetY() + 2);
        $pdf->Ln(8);

  
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->Cell(0, 8, 'Informations utilisateur', 0, 1);
        
        $pdf->SetFont('Arial', '', 10);
        $pdf->SetTextColor(80, 80, 80);
        $pdf->Cell(50, 6, 'Nom : ');
        $pdf->SetTextColor(0, 0, 0);
        $pdf->Cell(0, 6, $user['nom'] ?? 'N/A', 0, 1);

        $pdf->SetTextColor(80, 80, 80);
        $pdf->Cell(50, 6, 'Email : ');
        $pdf->SetTextColor(0, 0, 0);
        $pdf->Cell(0, 6, $user['email'] ?? 'N/A', 0, 1);

        $pdf->SetTextColor(80, 80, 80);
        $pdf->Cell(50, 6, 'Genre : ');
        $pdf->SetTextColor(0, 0, 0);
        $pdf->Cell(0, 6, $user['genre'] ?? 'N/A', 0, 1);

        $pdf->Ln(4);

        $pdf->SetFont('Arial', 'B', 12);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->Cell(0, 8, 'Donnees de sante actuelles', 0, 1);

        $pdf->SetFont('Arial', '', 10);
        $pdf->SetTextColor(80, 80, 80);
        $pdf->Cell(50, 6, 'Taille : ');
        $pdf->SetTextColor(0, 0, 0);
        $pdf->Cell(0, 6, ($latestSante['taille_cm'] ?? 'N/A') . ' cm', 0, 1);

        $pdf->SetTextColor(80, 80, 80);
        $pdf->Cell(50, 6, 'Poids : ');
        $pdf->SetTextColor(0, 0, 0);
        $pdf->Cell(0, 6, ($latestSante['poids_kg'] ?? 'N/A') . ' kg', 0, 1);

        $pdf->SetTextColor(80, 80, 80);
        $pdf->Cell(50, 6, 'IMC : ');
        $pdf->SetTextColor(22, 163, 74); 
        $pdf->Cell(0, 6, ($imc !== null ? $imc : 'N/A'), 0, 1);

        $pdf->Ln(4);


        $pdf->SetFont('Arial', 'B', 12);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->Cell(0, 8, 'Objectifs selectionnes', 0, 1);

        $pdf->SetFont('Arial', '', 10);
        if (! empty($selectedObjectifIds)) {
            foreach ($allObjectifs as $obj) {
                if (in_array((int) $obj['id'], $selectedObjectifIds, true)) {
                    $pdf->SetTextColor(80, 80, 80);
                    $pdf->Cell(8, 6);
                    $pdf->SetTextColor(0, 0, 0);
                    $pdf->MultiCell(0, 6, $obj['libelle'], 0, 'L');
                }
            }
        } else {
            $pdf->SetTextColor(150, 150, 150);
            $pdf->Cell(0, 6, 'Aucun objectif selectionne', 0, 1);
        }

        $pdf->Ln(6);

        $pdf->SetFont('Arial', '', 8);
        $pdf->SetTextColor(150, 150, 150);
        $pdf->SetDrawColor(200, 200, 200);
        $pdf->Line(10, $pdf->GetY(), 200, $pdf->GetY());
        $pdf->Ln(2);
        $pdf->Cell(0, 5, 'Ce document est personnel et confidentiel. © 2026 NutriPath', 0, 1, 'C');

        $filename = 'plan_objectifs_' . str_replace(' ', '_', $sessionUser['nom'] ?? 'user') . '_' . date('Y-m-d') . '.pdf';
        
    $pdf->Output('D', $filename);
    exit;
    }
}
