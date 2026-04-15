<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\SettingsModel;

class SettingsController extends BaseController
{
    public function index()
    {
        $model = new SettingsModel();
        $heroModel = new \App\Models\HeroImageModel();
        $role = session()->get('role');

        $data['hero_images'] = $heroModel->getSorted();

        $data['app_name'] = $model->getValueWithRole('app_name', $role, 'Geotagging App');
        $data['app_subtitle'] = $model->getValueWithRole('app_subtitle', $role, 'SISTEM SPASIAL');
        $data['header_text'] = $model->getValueWithRole('header_text', $role, 'Sistem Informasi Geotagging Tata Ruang');
        $data['footer_text'] = $model->getValueWithRole('footer_text', $role, 'Dinas Penanaman Modal dan PTSP');
        $data['header_color'] = $model->getValueWithRole('header_color', $role, '#0d6efd');
        $data['map_center_lat'] = $model->getValueWithRole('map_center_lat', $role, '-6.175392');
        $data['map_center_lng'] = $model->getValueWithRole('map_center_lng', $role, '106.827153');
        $data['hero_slide_interval'] = $model->getValueWithRole('hero_slide_interval', $role, '5');

        // Social Media & Map
        $data['facebook_url'] = $model->getValueWithRole('facebook_url', $role, '');
        $data['instagram_url'] = $model->getValueWithRole('instagram_url', $role, '');
        $data['youtube_url'] = $model->getValueWithRole('youtube_url', $role, '');
        $data['twitter_url'] = $model->getValueWithRole('twitter_url', $role, '');
        $data['office_map_iframe'] = $model->getValueWithRole('office_map_iframe', $role, '');

        // Logo Navbar (up to 3)
        $data['logo_navbar_1'] = $model->getValueWithRole('logo_navbar_1', $role, '');
        $data['logo_navbar_2'] = $model->getValueWithRole('logo_navbar_2', $role, '');
        $data['logo_navbar_3'] = $model->getValueWithRole('logo_navbar_3', $role, '');

        // Logo Sidebar
        $data['logo_sidebar'] = $model->getValueWithRole('logo_sidebar', $role, '');

        // Logo Login
        $data['logo_login'] = $model->getValueWithRole('logo_login', $role, '');

        // Legacy support
        $data['app_logo'] = $model->getValueWithRole('app_logo', $role, '/assets/logo.png');
        $data['role'] = $role;

        return view('admin/settings/index', $data);
    }

    public function update()
    {
        $model = new SettingsModel();
        $role = session()->get('role');

        $keys = [
            'app_name',
            'app_subtitle',
            'header_text',
            'footer_text',
            'header_color',
            'map_center_lat',
            'map_center_lng',
            'hero_slide_interval',
            'facebook_url',
            'instagram_url',
            'youtube_url',
            'twitter_url',
            'office_map_iframe'
        ];

        foreach ($keys as $key) {
            $value = $this->request->getPost($key);
            if ($value !== null) {
                // Save role-specific override
                $model->setValue($key . '_' . $role, $value);

                // If admin, also save as global default
                if ($role == 'admin') {
                    $model->setValue($key, $value);
                }
            }
        }

        // Handle Multiple Navbar Logos (up to 3)
        for ($i = 1; $i <= 3; $i++) {
            $file = $this->request->getFile('logo_navbar_' . $i);
            if ($file && $file->isValid() && !$file->hasMoved()) {
                $newName = $file->getRandomName();
                $file->move(FCPATH . 'uploads', $newName);
                $logoPath = '/uploads/' . $newName;
                $model->setValue('logo_navbar_' . $i . '_' . $role, $logoPath);
                if ($role == 'admin') {
                    $model->setValue('logo_navbar_' . $i, $logoPath);
                }
            }
        }

        // Handle Sidebar Logo
        $file = $this->request->getFile('logo_sidebar');
        if ($file && $file->isValid() && !$file->hasMoved()) {
            $newName = $file->getRandomName();
            $file->move(FCPATH . 'uploads', $newName);
            $logoPath = '/uploads/' . $newName;
            $model->setValue('logo_sidebar_' . $role, $logoPath);
            if ($role == 'admin') {
                $model->setValue('logo_sidebar', $logoPath);
            }
        }

        // Handle Login Logo
        $file = $this->request->getFile('logo_login');
        if ($file && $file->isValid() && !$file->hasMoved()) {
            $newName = $file->getRandomName();
            $file->move(FCPATH . 'uploads', $newName);
            $logoPath = '/uploads/' . $newName;
            $model->setValue('logo_login_' . $role, $logoPath);
            if ($role == 'admin') {
                $model->setValue('logo_login', $logoPath);
            }
        }

        return redirect()->to('admin/settings')->with('success', 'Pengaturan berhasil disimpan.');
    }

    public function addHeroImage()
    {
        $heroModel = new \App\Models\HeroImageModel();
        $file = $this->request->getFile('hero_image');

        if ($file && $file->isValid() && !$file->hasMoved()) {
            // Ensure directory exists
            if (!is_dir(FCPATH . 'uploads/hero')) {
                mkdir(FCPATH . 'uploads/hero', 0777, true);
            }

            $newName = $file->getRandomName();
            $file->move(FCPATH . 'uploads/hero', $newName);

            $heroModel->insert([
                'image_path' => '/uploads/hero/' . $newName,
                'sort_order' => $this->request->getPost('sort_order') ?? 0
            ]);

            return redirect()->to('admin/settings')->with('success', 'Gambar Hero berhasil ditambahkan.');
        }

        return redirect()->to('admin/settings')->with('error', 'Gagal mengupload gambar.');
    }

    public function deleteHeroImage($id)
    {
        $heroModel = new \App\Models\HeroImageModel();
        $image = $heroModel->find($id);

        if ($image) {
            $filePath = FCPATH . ltrim($image['image_path'], '/');
            if (file_exists($filePath)) {
                @unlink($filePath);
            }
            $heroModel->delete($id);
            return redirect()->to('admin/settings')->with('success', 'Gambar Hero berhasil dihapus.');
        }

        return redirect()->to('admin/settings')->with('error', 'Gambar tidak ditemukan.');
    }

    public function deleteLogo($key)
    {
        $model = new SettingsModel();
        $role = session()->get('role');

        $value = $model->getValueWithRole($key, $role);

        if ($value && $value !== '') {
            $filePath = FCPATH . ltrim($value, '/');
            if (file_exists($filePath)) {
                @unlink($filePath);
            }

            $model->setValue($key . '_' . $role, '');
            if ($role == 'admin') {
                $model->setValue($key, '');
            }

            return redirect()->to('admin/settings')->with('success', 'Logo berhasil dihapus.');
        }

        return redirect()->to('admin/settings')->with('error', 'Logo tidak ditemukan atau sudah dihapus.');
    }
}