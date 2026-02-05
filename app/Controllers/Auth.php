<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class Auth extends BaseController
{
    public function index()
    {
        return redirect()->to('auth/login');
    }

    public function login()
    {
        if (session()->get('isLoggedIn')) {
            return redirect()->to('dashboard');
        }
        return view('auth/login');
    }

    public function attemptLogin()
    {
        $rules = [
            'username' => 'required',
            'password' => 'required'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');

        $userModel = new \App\Models\UserModel();
        $user = $userModel->where('username', $username)->first();

        if ($user && password_verify($password, $user['password_hash'])) {
            $sessionData = [
                'id' => $user['id'],
                'username' => $user['username'],
                'role' => $user['role'],
                'isLoggedIn' => true
            ];
            session()->set($sessionData);
            return redirect()->to('dashboard');
        }
        else {
            return redirect()->back()->withInput()->with('error', 'Invalid Login Credentials');
        }
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('auth/login');
    }
}