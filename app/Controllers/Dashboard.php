<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class Dashboard extends BaseController
{
    public function index()
    {
        $rdtrModel = new \App\Models\RdtrModel();
        $rtrwModel = new \App\Models\RtrwModel();
        $userModel = new \App\Models\UserModel();

        $data = [
            'count_rdtr' => $rdtrModel->countAllResults(),
            'count_rtrw' => $rtrwModel->countAllResults(),
            'count_users' => $userModel->countAllResults(),
        ];

        return view('admin/dashboard', $data);
    }
}