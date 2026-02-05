<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\UserModel;

class UserController extends BaseController
{
    public function index()
    {
        $model = new UserModel();
        $data['users'] = $model->findAll();
        return view('admin/users/index', $data);
    }

    public function create()
    {
        return view('admin/users/create');
    }

    public function store()
    {
        $rules = [
            'username' => 'required|min_length[3]|is_unique[users.username]',
            'password' => 'required|min_length[6]',
            'role' => 'required|in_list[admin,operator]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $model = new UserModel();
        $data = [
            'username' => $this->request->getPost('username'),
            'password_hash' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
            'role' => $this->request->getPost('role'),
        ];

        $model->insert($data);
        return redirect()->to('admin/users')->with('success', 'User berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $model = new UserModel();
        $user = $model->find($id);

        if (!$user) {
            return redirect()->to('admin/users')->with('error', 'User tidak ditemukan.');
        }

        return view('admin/users/edit', ['user' => $user]);
    }

    public function update($id)
    {
        $model = new UserModel();
        $user = $model->find($id);

        if (!$user) {
            return redirect()->to('admin/users')->with('error', 'User tidak ditemukan.');
        }

        $rules = [
            'role' => 'required|in_list[admin,operator]',
        ];

        // Validate username only if changed
        if ($this->request->getPost('username') != $user['username']) {
            $rules['username'] = 'required|min_length[3]|is_unique[users.username]';
        }

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = [
            'username' => $this->request->getPost('username'),
            'role' => $this->request->getPost('role'),
        ];

        // Update password only if provided
        $password = $this->request->getPost('password');
        if (!empty($password)) {
            $data['password_hash'] = password_hash($password, PASSWORD_DEFAULT);
        }

        $model->update($id, $data);
        return redirect()->to('admin/users')->with('success', 'User berhasil diperbarui.');
    }

    public function delete($id)
    {
        $model = new UserModel();

        // Prevent deleting self (basic check)
        if (session()->get('id') == $id) {
            return redirect()->to('admin/users')->with('error', 'Tidak dapat menghapus akun sendiri.');
        }

        $model->delete($id);
        return redirect()->to('admin/users')->with('success', 'User berhasil dihapus.');
    }
}