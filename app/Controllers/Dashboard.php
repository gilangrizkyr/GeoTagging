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

        $auditModel = new \App\Models\AuditLogModel();

        $today = date('Y-m-d');

        $data = [
            'count_rdtr' => $rdtrModel->countAllResults(),
            'count_rtrw' => $rtrwModel->countAllResults(),
            'count_users' => $userModel->countAllResults(),
            'total_searches' => $auditModel->countAllResults(),
            'today_searches' => $auditModel->where('DATE(search_time)', $today)->countAllResults(),
        ];

        return view('admin/dashboard', $data);
    }
}