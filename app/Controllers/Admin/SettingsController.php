<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\SettingsModel;

class SettingsController extends BaseController
{
    public function index()
    {
        $model = new SettingsModel();
        $data['app_name'] = $model->getValue('app_name', 'Geotagging App');
        $data['header_color'] = $model->getValue('header_color', '#0d6efd');
        $data['app_logo'] = $model->getValue('app_logo', '/assets/logo.png');
        $data['map_center_lat'] = $model->getValue('map_center_lat', '-6.175392');
        $data['map_center_lng'] = $model->getValue('map_center_lng', '106.827153');

        return view('admin/settings/index', $data);
    }

    public function update()
    {
        $model = new SettingsModel();

        // Update Text Fields
        $model->setValue('app_name', $this->request->getPost('app_name'));
        $model->setValue('header_color', $this->request->getPost('header_color'));
        $model->setValue('map_center_lat', $this->request->getPost('map_center_lat'));
        $model->setValue('map_center_lng', $this->request->getPost('map_center_lng'));

        // Handle Logo Upload
        $file = $this->request->getFile('app_logo_file');
        if ($file && $file->isValid() && !$file->hasMoved()) {
            $newName = $file->getRandomName();
            $file->move(FCPATH . 'uploads', $newName);

            // Generate public path
            $logoPath = '/uploads/' . $newName;
            $model->setValue('app_logo', $logoPath);
        }

        return redirect()->to('admin/settings')->with('success', 'Pengaturan berhasil disimpan.');
    }
}