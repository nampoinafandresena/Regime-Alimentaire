<?php

namespace App\Controllers;

use App\Models\ObjectifModel;
use App\Models\AchatGoldModel;
use App\Models\OptionGoldModel;
use App\Models\SanteModel;
use App\Models\UserModel;
use App\Models\UserObjectifModel;

class UserController extends BaseController
{
	public function inscriptionStep1()
	{
		return view('Modal', ['page' => 'inscription1']);
	}

	public function storeStep1()
	{
		$rules = [
			'prenom' => 'required|min_length[2]',
			'nom' => 'required|min_length[2]',
			'email' => 'required|valid_email',
			'mot_de_passe' => 'required|min_length[6]',
			'genre' => 'required|in_list[Homme,Femme,Autre]',
		];

		if (! $this->validate($rules)) {
			return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
		}

		$session = session();
		$session->set('inscription_step1', [
			'prenom' => $this->request->getPost('prenom'),
			'nom' => $this->request->getPost('nom'),
			'email' => $this->request->getPost('email'),
			'mot_de_passe' => $this->request->getPost('mot_de_passe'),
			'genre' => $this->request->getPost('genre'),
		]);

		return redirect()->to('/inscription/etape-2');
	}

	public function inscriptionStep2()
	{
		$objectifs = (new ObjectifModel())->findAll();

		return view('Modal', [
			'objectifs' => $objectifs,
			'page' => 'inscription2',
		]);
	}

	public function storeStep2()
	{
		$session = session();
		$step1 = $session->get('inscription_step1');

		if (! $step1) {
			return redirect()->to('/inscription/etape-1');
		}

		$rules = [
			'taille_cm' => 'required|decimal',
			'poids_kg' => 'required|decimal',
			'objectifs' => 'required',
		];

		if (! $this->validate($rules)) {
			return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
		}

		$objectifs = (array) $this->request->getPost('objectifs');
		if (count($objectifs) > 3) {
			return redirect()->back()->withInput()->with('errors', [
				'objectifs' => 'Vous pouvez choisir au maximum 3 objectifs.',
			]);
		}

		$userModel = new UserModel();
		$userId = $userModel->createUser([
			'nom' => trim($step1['prenom'] . ' ' . $step1['nom']),
			'genre' => $step1['genre'],
			'email' => $step1['email'],
			'mot_de_passe' => $step1['mot_de_passe'],
			'role' => 'user',
			'est_gold' => 0,
			'solde_portefeuille' => 0,
		]);

		if (! $userId) {
			return redirect()->back()->withInput()->with('errors', [
				'general' => 'Erreur lors de la creation du compte.',
			]);
		}

		$santeModel = new SanteModel();
		$santeModel->ajouterSante(
			$userId,
			$this->request->getPost('taille_cm'),
			$this->request->getPost('poids_kg')
		);

		$userObjectifModel = new UserObjectifModel();
		foreach ($objectifs as $objectifId) {
			$userObjectifModel->insertObjectifForUser($userId, $objectifId);
		}

		$session->remove('inscription_step1');


		return redirect()->to('/formulaire');
	}
	
	public function profil()
	{
		$sessionUser = session()->get('user');
		if (! $sessionUser || ! isset($sessionUser['id'])) {
			return redirect()->to('/formulaire');
		}

		$userId = $sessionUser['id'];
		$userModel = new UserModel();
		$santeModel = new SanteModel();
		$objectifModel = new ObjectifModel();
		$userObjectifModel = new UserObjectifModel();

		$user = $userModel->find($userId);
		$latestSante = $santeModel->getLatestSanteByUserId($userId);
		$objectifs = array_values(array_reduce($objectifModel->findAll(), function (array $carry, array $objectif) {
			$carry[$objectif['id']] = $objectif;
			return $carry;
		}, []));
		$selectedObjectifIds = $userObjectifModel->getObjectifIdsByUserId($userId);

		$regimeModel = new \App\Models\RegimeModel();
		$regimes = $regimeModel->getAllInfosRegimes();
		$recommendedRegimes = array_slice($regimes, 0, 3);
		$optionGoldModel = new OptionGoldModel();
		$goldOption = $optionGoldModel->orderBy('prix', 'ASC')->first();

		$imc = null;
		if ($latestSante && (float) $latestSante['taille_cm'] > 0) {
			$tailleM = (float) $latestSante['taille_cm'] / 100;
			$imc = round((float) $latestSante['poids_kg'] / ($tailleM * $tailleM), 1);
		}

		return view('Modal', [
			'page' => 'pages/profil',
			'user' => $user,
			'latestSante' => $latestSante,
			'objectifs' => $objectifs,
			'selectedObjectifIds' => $selectedObjectifIds,
			'imc' => $imc,
			'recommendedRegimes' => $recommendedRegimes,
			'goldOption' => $goldOption,
		]);
	}

	public function acheterGold()
	{
		$sessionUser = session()->get('user');
		if (! $sessionUser || ! isset($sessionUser['id'])) {
			return redirect()->to('/formulaire');
		}

		$userModel = new UserModel();
		$optionGoldModel = new OptionGoldModel();
		$achatGoldModel = new AchatGoldModel();

		$user = $userModel->find($sessionUser['id']);
		if (! $user) {
			return redirect()->to('/profil')->with('errors', ['gold' => 'Utilisateur introuvable.']);
		}

		if ((int) ($user['est_gold'] ?? 0) === 1) {
			return redirect()->to('/profil')->with('errors', ['gold' => 'Votre compte est déjà Gold.']);
		}

		$optionGold = $optionGoldModel->orderBy('prix', 'ASC')->first();
		if (! $optionGold) {
			return redirect()->to('/profil')->with('errors', ['gold' => 'Aucune option Gold disponible.']);
		}

		$prixGold = (float) $optionGold['prix'];
		$soldeActuel = (float) ($user['solde_portefeuille'] ?? 0);
		if ($soldeActuel < $prixGold) {
			return redirect()->to('/profil')->with('errors', ['gold' => 'Solde insuffisant pour activer Gold.']);
		}

		$db = \Config\Database::connect();
		$db->transStart();

		$nouveauSolde = $soldeActuel - $prixGold;
		$walletUpdated = $db->table('utilisateurs')
			->where('id', $sessionUser['id'])
			->update([
				'est_gold' => 1,
				'solde_portefeuille' => $nouveauSolde,
			]);

		if (! $walletUpdated) {
			$db->transRollback();
			return redirect()->to('/profil')->with('errors', ['gold' => 'Impossible d\'activer Gold.']);
		}

		$achatGoldModel->AcheterGold($sessionUser['id'], $prixGold);

		$db->transComplete();

		session()->set('user', array_merge($sessionUser, [
			'est_gold' => 1,
			'solde_portefeuille' => $nouveauSolde,
		]));

		return redirect()->to('/profil')->with('success', 'Compte Gold activé avec succès pour ' . number_format($prixGold, 2, ',', ' ') . ' Ar.');
	}

	public function updateProfil()
	{
		$sessionUser = session()->get('user');
		if (! $sessionUser || ! isset($sessionUser['id'])) {
			return redirect()->to('/formulaire');
		}

		$rules = [
			'nom' => 'required|min_length[3]',
			'email' => 'required|valid_email',
			'genre' => 'required|in_list[Homme,Femme,Autre]',
		];

		if (! $this->validate($rules)) {
			return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
		}

		$userModel = new UserModel();
		$userModel->updateUser($sessionUser['id'], [
			'nom' => $this->request->getPost('nom'),
			'email' => $this->request->getPost('email'),
			'genre' => $this->request->getPost('genre'),
		]);

		session()->set('user', [
			'id' => $sessionUser['id'],
			'nom' => $this->request->getPost('nom'),
			'email' => $this->request->getPost('email'),
			'role' => $sessionUser['role'] ?? 'user',
		]);

		return redirect()->to('/profil')->with('success', 'Profil mis a jour.');
	}

	public function updateSante()
	{
		$sessionUser = session()->get('user');
		if (! $sessionUser || ! isset($sessionUser['id'])) {
			return redirect()->to('/formulaire');
		}

		$rules = [
			'taille_cm' => 'required|decimal',
			'poids_kg' => 'required|decimal',
		];

		if (! $this->validate($rules)) {
			return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
		}

		$santeModel = new SanteModel();
		$santeModel->ajouterSante(
			$sessionUser['id'],
			$this->request->getPost('taille_cm'),
			$this->request->getPost('poids_kg')
		);

		return redirect()->to('/profil')->with('success', 'Donnees de sante mises a jour.');
	}

	public function updateObjectifs()
	{
		$sessionUser = session()->get('user');
		if (! $sessionUser || ! isset($sessionUser['id'])) {
			return redirect()->to('/formulaire');
		}

		$objectifs = (array) $this->request->getPost('objectifs');
		if (count($objectifs) === 0) {
			return redirect()->back()->withInput()->with('errors', [
				'objectifs' => 'Veuillez choisir au moins un objectif.',
			]);
		}
		if (count($objectifs) > 3) {
			return redirect()->back()->withInput()->with('errors', [
				'objectifs' => 'Vous pouvez choisir au maximum 3 objectifs.',
			]);
		}

		$userObjectifModel = new UserObjectifModel();
		$userObjectifModel->where('id_utilisateur', $sessionUser['id'])->delete();
		foreach ($objectifs as $objectifId) {
			$userObjectifModel->insertObjectifForUser($sessionUser['id'], $objectifId);
		}

		return redirect()->to('/profil')->with('success', 'Objectifs mis a jour.');
	}

	public function UtilisationCode()
	{
		$sessionUser = session()->get('user');
		if (! $sessionUser || ! isset($sessionUser['id'])) {
			return redirect()->to('/formulaire');
		}

		$codeInput = trim($this->request->getPost('code'));
		if (! $codeInput) {
			if ($this->request->isAJAX()) {
				return $this->response->setJSON(['success' => false, 'errors' => ['Veuillez saisir un code.']])->setStatusCode(400);
			}
			return redirect()->to('/profil')->with('errors', ['code' => 'Veuillez saisir un code.']);
		}

		$codeModel = new \App\Models\CodeModel();
		$codeUserModel = new \App\Models\CodeUserModel();
		$userModel = new \App\Models\UserModel();

		$db = \Config\Database::connect();
		$db->transStart();

		$codeRow = $codeModel->where('code', $codeInput)->first();
		if (! $codeRow) {
			$db->transComplete();
			if ($this->request->isAJAX()) {
				return $this->response->setJSON(['success' => false, 'errors' => ['Code invalide.']])->setStatusCode(404);
			}
			return redirect()->to('/profil')->with('errors', ['code' => 'Code invalide.']);
		}
		if (! (int) $codeRow['est_valide']) {
			$db->transComplete();
			if ($this->request->isAJAX()) {
				return $this->response->setJSON(['success' => false, 'errors' => ['Ce code n\'est pas valide.']])->setStatusCode(400);
			}
			return redirect()->to('/profil')->with('errors', ['code' => 'Ce code n\'est pas valide.']);
		}
		if (! empty($codeRow['date_expiration']) && strtotime($codeRow['date_expiration']) < time()) {
			$db->transComplete();
			if ($this->request->isAJAX()) {
				return $this->response->setJSON(['success' => false, 'errors' => ['Ce code est expiré.']])->setStatusCode(400);
			}
			return redirect()->to('/profil')->with('errors', ['code' => 'Ce code est expiré.']);
		}

		$usedCount = $db->table('code_users')->where('id_code', $codeRow['id'])->countAllResults();
		if ($usedCount > 0) {
			$db->transComplete();
			if ($this->request->isAJAX()) {
				return $this->response->setJSON(['success' => false, 'errors' => ['Ce code a déjà été utilisé.']])->setStatusCode(409);
			}
			return redirect()->to('/profil')->with('errors', ['code' => 'Ce code a déjà été utilisé.']);
		}

		$user = $userModel->find($sessionUser['id']);
		if (! $user) {
			$db->transComplete();
			return redirect()->to('/profil')->with('errors', ['code' => 'Utilisateur introuvable.']);
		}

		$nouveauSolde = (float) $user['solde_portefeuille'] + (float) $codeRow['montant'];
		$walletUpdated = $db->table('utilisateurs')
			->where('id', $sessionUser['id'])
			->update(['solde_portefeuille' => $nouveauSolde]);

		if (! $walletUpdated) {
			$db->transRollback();
			if ($this->request->isAJAX()) {
				return $this->response->setJSON(['success' => false, 'errors' => ['Impossible de mettre à jour le solde.']])->setStatusCode(500);
			}
			return redirect()->to('/profil')->with('errors', ['code' => 'Impossible de mettre à jour le solde.']);
		}

		$codeUserModel->utiliserCode($sessionUser['id'], $codeRow['id']);

		$codeModel->updateCode($codeRow['id'], ['est_valide' => 0]);

		$db->transComplete();

		if ($this->request->isAJAX()) {
			return $this->response->setJSON([
				'success' => true,
				'message' => 'Code appliqué — ' . number_format($codeRow['montant'],0,',',' ') . ' Ar ajouté.',
				'newBalance' => $nouveauSolde
			])->setStatusCode(200);
		}

		session()->setFlashdata('success', 'Code appliqué — ' . number_format($codeRow['montant'],0,',',' ') . ' Ar ajouté.');
		return redirect()->to('/profil');
	}
}

