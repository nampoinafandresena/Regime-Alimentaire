<?php
    namespace App\Controllers;
    use App\Models\UserModel;
    class AuthController extends BaseController {
    public function form() {
        return view('auth/Login');
    }
    public function login() {
        $model = new UserModel();
        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');
        $user = $model->getUserByEmail($email);
        if (!$user || !password_verify($password, password_hash($user['mot_de_passe'], PASSWORD_DEFAULT))) {
            return view('auth/Login', [
            'erreur' => 'Email ou mot de passe incorrect'
            ]);
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