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

        // Officer Info for PDF
        $data['kepala_dinas_nama'] = $model->getValueWithRole('kepala_dinas_nama', $role, 'Dr. H. Andi Aminuddin, S.Pd., MM');
        $data['kepala_dinas_nip'] = $model->getValueWithRole('kepala_dinas_nip', $role, '19671231 199003 1 122');
        $data['kepala_dinas_jabatan'] = $model->getValueWithRole('kepala_dinas_jabatan', $role, 'Kepala Dinas');
        $data['kepala_dinas_lokasi'] = $model->getValueWithRole('kepala_dinas_lokasi', $role, 'Tanah Bumbu');
        $data['pdf_show_qr'] = $model->getValueWithRole('pdf_show_qr', $role, '1');

        // Agency Branding for PDF
        $data['agency_main_name'] = $model->getValueWithRole('agency_main_name', $role, 'PEMERINTAH KABUPATEN TANAH BUMBU');
        $data['agency_sub_name'] = $model->getValueWithRole('agency_sub_name', $role, 'DINAS PENANAMAN MODAL DAN PELAYANAN TERPADU SATU PINTU');
        $data['agency_address'] = $model->getValueWithRole('agency_address', $role, 'Jl. Dharma Praja No. 1, Kel. Gunung Tinggi, Kec. Batulicin, Kab. Tanah Bumbu');
        $data['agency_contact'] = $model->getValueWithRole('agency_contact', $role, 'Email: dpmptsp@tanahbumbukab.go.id | Website: dpmptsp.tanahbumbukab.go.id');
        $data['pdf_disclaimer'] = $model->getValueWithRole('pdf_disclaimer', $role, "1. Laporan ini merupakan hasil analisis otomatis sistem informasi geospasial sebagai instrumen bantu pelayanan publik.\n2. Dokumen ini bersifat INDIKATIF dan digunakan hanya sebagai informasi awal kesesuaian ruang bagi pemohon.\n3. Laporan ini BUKAN merupakan dokumen Persetujuan Kesesuaian Kegiatan Pemanfaatan Ruang (PKKPR) resmi.\n4. Validasi legalitas akhir tetap mengacu pada sistem OSS-RBA dan verifikasi faktual lapangan oleh tenaga teknis terkait.");

        // Global UI Text & Branding
        $data['app_slogan'] = $model->getValueWithRole('app_slogan', $role, 'Sistem Informasi Geospasial Terintegrasi');
        $data['app_hero_title'] = $model->getValueWithRole('app_hero_title', $role, 'Transparansi Tata Ruang Tanah Bumbu');
        $data['app_hero_desc'] = $model->getValueWithRole('app_hero_desc', $role, 'Pusat data spasial terpadu untuk pemantauan rencana tata ruang, analisis investasi, dan keterbukaan informasi publik Kabupaten Tanah Bumbu.');
        $data['app_cta_title'] = $model->getValueWithRole('app_cta_title', $role, 'Cek Lokasi Investasi Anda');
        $data['app_cta_desc'] = $model->getValueWithRole('app_cta_desc', $role, 'Dapatkan informasi detail mengenai peruntukan zona dan regulasi pemanfaatan ruang secara instan langsung dari peta.');
        $data['copyright_text'] = $model->getValueWithRole('copyright_text', $role, 'DPMPTSP Tanah Bumbu');
        $data['contact_email'] = $model->getValueWithRole('contact_email', $role, 'info@tanahbumbu.go.id');
        $data['contact_phone'] = $model->getValueWithRole('contact_phone', $role, '(0518) Hubungi Kami');
        $data['agency_footer_desc'] = $model->getValueWithRole('agency_footer_desc', $role, 'Sistem Informasi Geospasial Terintegrasi Kabupaten Tanah Bumbu untuk transparansi data tata ruang dan investasi.');
        $data['login_sidebar_title'] = $model->getValueWithRole('login_sidebar_title', $role, 'Command Center');
        $data['login_form_title'] = $model->getValueWithRole('login_form_title', $role, 'Administrator Login');

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
        $mediaService = new \App\Services\MediaService();
        $role = session()->get('role');
        $userId = session()->get('user_id');

        $keys = [
            'app_name', 'app_subtitle', 'header_text', 'footer_text', 'header_color',
            'map_center_lat', 'map_center_lng', 'hero_slide_interval',
            'facebook_url', 'instagram_url', 'youtube_url', 'twitter_url', 'office_map_iframe',
            'kepala_dinas_nama', 'kepala_dinas_nip', 'kepala_dinas_jabatan', 'kepala_dinas_lokasi',
            'pdf_show_qr', 'agency_main_name', 'agency_sub_name', 'agency_address', 'agency_contact', 'pdf_disclaimer',
            'app_slogan', 'app_hero_title', 'app_hero_desc', 'app_cta_title', 'app_cta_desc',
            'copyright_text', 'contact_email', 'contact_phone', 'agency_footer_desc',
            'login_sidebar_title', 'login_form_title'
        ];

        foreach ($keys as $key) {
            $value = $this->request->getPost($key);
            if ($value !== null) {
                $model->setValue($key . '_' . $role, $value);
                if ($role == 'admin') {
                    $model->setValue($key, $value);
                }
            }
        }

        // Handle Multiple Navbar Logos
        for ($i = 1; $i <= 3; $i++) {
            $file = $this->request->getFile('logo_navbar_' . $i);
            if ($file && $file->isValid()) {
                $uuid = $mediaService->upload($file, 'branding', $userId);
                if ($uuid) {
                    $model->setValue('logo_navbar_' . $i . '_' . $role, $uuid);
                    if ($role == 'admin') $model->setValue('logo_navbar_' . $i, $uuid);
                }
            }
        }

        // Handle Sidebar Logo
        $file = $this->request->getFile('logo_sidebar');
        if ($file && $file->isValid()) {
            $uuid = $mediaService->upload($file, 'branding', $userId);
            if ($uuid) {
                $model->setValue('logo_sidebar_' . $role, $uuid);
                if ($role == 'admin') $model->setValue('logo_sidebar', $uuid);
            }
        }

        // Handle Login Logo
        $file = $this->request->getFile('logo_login');
        if ($file && $file->isValid()) {
            $uuid = $mediaService->upload($file, 'login', $userId);
            if ($uuid) {
                $model->setValue('logo_login_' . $role, $uuid);
                if ($role == 'admin') $model->setValue('logo_login', $uuid);
            }
        }

        return redirect()->to('admin/settings')->with('success', 'Pengaturan berhasil disimpan dengan standar Pro-Storage.');
    }

    public function addHeroImage()
    {
        $heroModel = new \App\Models\HeroImageModel();
        $mediaService = new \App\Services\MediaService();
        $file = $this->request->getFile('hero_image');
        $userId = session()->get('user_id');

        if ($file && $file->isValid()) {
            $uuid = $mediaService->upload($file, 'hero', $userId);
            if ($uuid) {
                $heroModel->insert([
                    'image_path' => $uuid, // Store UUID as path for interop
                    'sort_order' => $this->request->getPost('sort_order') ?? 0
                ]);
                return redirect()->to('admin/settings')->with('success', 'Gambar Hero berhasil dienkripsi dan disimpan.');
            }
        }

        return redirect()->to('admin/settings')->with('error', 'Gagal memproses file strategis.');
    }

    public function deleteHeroImage($id)
    {
        $heroModel = new \App\Models\HeroImageModel();
        $mediaService = new \App\Services\MediaService();
        $image = $heroModel->find($id);

        if ($image) {
            $mediaService->delete($image['image_path']);
            $heroModel->delete($id);
            return redirect()->to('admin/settings')->with('success', 'Aset hero telah dimusnahkan secara aman.');
        }

        return redirect()->to('admin/settings')->with('error', 'Aset tidak ditemukan.');
    }

    public function deleteLogo($key)
    {
        $model = new SettingsModel();
        $mediaService = new \App\Services\MediaService();
        $role = session()->get('role');

        $uuid = $model->getValueWithRole($key, $role);

        if ($uuid) {
            $mediaService->delete($uuid);
            $model->setValue($key . '_' . $role, '');
            if ($role == 'admin') $model->setValue($key, '');

            return redirect()->to('admin/settings')->with('success', 'Aset branding berhasil dihapus.');
        }

        return redirect()->to('admin/settings')->with('error', 'Aset tidak ditemukan.');
    }
}
