<?php
    namespace App\Controllers;
    use App\Models\UserModel;
    class AuthController extends BaseController {
    public function form() {
        return view('Modal', ['page' => 'auth/Login']);
    }
    public function login() {
        $model = new UserModel();
        $role = $this->request->getPost('role');
        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');
        $user = $model->getUserByEmail($email);
        if (!$user || !password_verify($password, password_hash($user['mot_de_passe'], PASSWORD_DEFAULT))) {
            return view('Modal', [
            'erreur' => 'Email ou mot de passe incorrect',
            'page' => 'auth/Login'
            ]);
        }
        if ($user['role'] !== $role) {
            return view('Modal', [
            'erreur' => 'Rôle sélectionné ne correspond pas à l\'utilisateur',
            'page' => 'auth/Login'
            ]);
        }
        if ($user['role'] === 'admin') {
            session()->set('admin', ['id' => $user['id'],'nom' => $user['nom'], 'email' => $user['email'],'role' => $user['role']]);
            return redirect()->to('/bo/dashboard/general');
        }
        // Stocker uniquement les données non sensibles en session
        session()->set('user', ['id' => $user['id'],'nom' => $user['nom'], 'email' => $user['email'],'role' => $user['role']]);
        return redirect()->to('/index');
    }

    public function logout() {
        session()->destroy();
        return redirect()->to('/');
    }

    

}