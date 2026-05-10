<?php

namespace App\Controllers;

use App\Models\ObjectifModel;
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

		return redirect()->to('/login');
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
		$objectifs = $objectifModel->findAll();
		$selectedObjectifIds = $userObjectifModel->getObjectifIdsByUserId($userId);

		$regimeModel = new \App\Models\RegimeModel();
		$regimes = $regimeModel->getAllInfosRegimes();
		$recommendedRegimes = array_slice($regimes, 0, 3);

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
		]);
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
}

