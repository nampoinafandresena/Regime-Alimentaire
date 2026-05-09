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

		return redirect()->to('/formulaire');
	}
}

