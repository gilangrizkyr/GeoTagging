<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;

class AuditLogController extends BaseController
{
    public function index()
    {
        $model = new \App\Models\AuditLogModel();

        // Get recent logs with pagination
        $perPage = 50;
        $data['logs'] = $model->orderBy('search_time', 'DESC')->paginate($perPage);
        $data['pager'] = $model->pager;

        return view('admin/audit_logs/index', $data);
    }

    public function clear()
    {
        // Only admin can clear logs
        if (session()->get('role') !== 'admin') {
            return redirect()->to('admin/audit_logs')->with('error', 'Unauthorized');
        }

        $model = new \App\Models\AuditLogModel();
        $model->truncate();

        return redirect()->to('admin/audit_logs')->with('success', 'Audit logs cleared successfully');
    }
}