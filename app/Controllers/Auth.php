<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use Google\Client;
use App\Models\UserModel;

class Auth extends Controller
{
    public function index()
    {
        if (session()->get('user')) {
            return redirect()->to('/horario');
        }

        return redirect()->to('/login');
    }

    public function login()
    {
        // Vista simple con botón de prueba
        return view('login');
    }

    /**
     * Cerrar sesión
     */
    public function logout()
    {
        session()->destroy();
        return redirect()->to('/');
    }

    /**
     * Iniciar autenticación con Google Oauth2
     */
    public function google()
    {
        $client = new Client();
        $client->setClientId(env('GOOGLE_CLIENT_ID'));
        $client->setClientSecret(env('GOOGLE_CLIENT_SECRET'));
        $client->setRedirectUri(env('GOOGLE_REDIRECT_URI'));

        $client->addScope('email');
        $client->addScope('profile');

        return redirect()->to($client->createAuthUrl());
    }


    /**
     * Callback de Google después de autenticación
     */
    public function callback()
    {
        $client = new Client();
        $client->setClientId(env('GOOGLE_CLIENT_ID'));
        $client->setClientSecret(env('GOOGLE_CLIENT_SECRET'));
        $client->setRedirectUri(env('GOOGLE_REDIRECT_URI'));

        $token = $client->fetchAccessTokenWithAuthCode($this->request->getVar('code'));

        
        if (isset($token['error'])) {
            return redirect()->to('/login');
            }
            
            $client->setAccessToken($token['access_token']);
            
            
        $google_service = new \Google\Service\Oauth2($client);
        $data = $google_service->userinfo->get();

        $email = $data->email;
        $name  = $data->name;

        // 🔐 Validar dominio colegio
        if (!str_ends_with($email, '@scuolaitalianalaserena.cl')) {
            return redirect()->to('/login');
        }

        // Guardar en sesión
        $userModel = new UserModel();

        // Buscar usuario
        $user = $userModel->where('email', $email)->first();
        $avatar = $user ? $user['avatar'] : null; // Mantener avatar existente si el usuario ya existe, o usar el nuevo de Google si es nuevo


        if (!$user) {
            if($email == 'informatica@scuolaitalianalaserena.cl') {
                $role = 1; // Admin
            } else {
                $role = 2; // Usuario normal
            }

            $avatarUrl = $data->picture;
            $avatarContent = file_get_contents($avatarUrl);

            $fileName = 'avatar_' . time() . '.jpg';
            file_put_contents(FCPATH . 'uploads/avatars/' . $fileName, $avatarContent);

            $avatar = 'uploads/avatars/' . $fileName;

            // Crear si no existe
            $userId = $userModel->insert([
                'google_id' => $data->id,
                'first_name' => $data->givenName,
                'last_name'  => $data->familyName,
                'email'      => $email,
                'avatar'     => $avatar,
                'role'       => $role
            ]);

            $user = $userModel->find($userId);
        }

        // Guardar sesión real
        session()->set('user', [
            'id'    => $user['id'],
            'name'  => $user['first_name'] . ' ' . $user['last_name'],
            'email' => $user['email'],
            'avatar' => $avatar,
            'role'  => $user['role'],
            'logged_in' => true
        ]);

        if($user['role'] == 1) {
            return redirect()->to('/admin');

        }
        return redirect()->to('/horario');
    }
}