<?php /** @var \CodeIgniter\View\View $this */ ?>
<?php $this->extend('layouts/admin') ?>

<?php $this->section('title') ?>
Konfigurasi Sistem
<?php $this->endSection() ?>

<?php $this->section('content') ?>
<div class="row">
    <div class="col-12">
        <?php if (session()->getFlashdata('success')): ?>
            <div class="alert alert-success border-0 shadow-sm rounded-4 d-flex align-items-center p-3 mb-4" role="alert">
                <i class="bi bi-check-circle-fill fs-4 me-3"></i>
                <div class="fw-600">
                    <?= session()->getFlashdata('success') ?>
                </div>
                <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <div class="card card-premium overflow-hidden">
            <div class="card-header bg-white py-4 px-4 border-0 d-flex justify-content-between align-items-center">
                <div>
                    <h5 class="mb-1 fw-800 text-dark"><i class="bi bi-sliders2 me-2 text-primary"></i> Konfigurasi Sistem</h5>
                    <p class="text-muted small mb-0 fw-500">Kelola identitas, visual, dan parameter teknis aplikasi secara terpusat.</p>
                </div>
                <span class="badge bg-primary-subtle text-primary border border-primary-subtle px-3 py-2 rounded-pill small fw-700">
                    <i class="bi bi-person-badge me-1"></i> Mode: Role <?= ucfirst($role) ?>
                </span>
            </div>

            <div class="card-body p-0 border-top">
                <form action="<?= base_url('admin/settings/update') ?>" method="post" enctype="multipart/form-data" id="settingsForm">
                    <div class="row g-0">
                        <!-- Sidebar Navigation -->
                        <div class="col-md-3 border-end bg-light p-0">
                            <div class="nav flex-column nav-pills settings-pills border-0" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                                <button class="nav-link active py-3 px-4 border-bottom rounded-0 text-start" id="tab-branding" data-bs-toggle="pill" data-bs-target="#content-branding" type="button" role="tab">
                                    <i class="bi bi-palette2 me-2"></i> Identitas & Visual
                                </button>
                                <button class="nav-link py-3 px-4 border-bottom rounded-0 text-start" id="tab-kontak" data-bs-toggle="pill" data-bs-target="#content-kontak" type="button" role="tab">
                                    <i class="bi bi-geo-alt me-2"></i> Kontak & Media Sosial
                                </button>
                                <button class="nav-link py-3 px-4 border-bottom rounded-0 text-start" id="tab-beranda" data-bs-toggle="pill" data-bs-target="#content-beranda" type="button" role="tab">
                                    <i class="bi bi-window-sidebar me-2"></i> Konten Halaman Beranda
                                </button>
                                <button class="nav-link py-3 px-4 border-bottom rounded-0 text-start" id="tab-slider" data-bs-toggle="pill" data-bs-target="#content-slider" type="button" role="tab">
                                    <i class="bi bi-images me-2"></i> Manajemen Hero Slider
                                </button>
                                <button class="nav-link py-3 px-4 border-bottom rounded-0 text-start" id="tab-login" data-bs-toggle="pill" data-bs-target="#content-login" type="button" role="tab">
                                    <i class="bi bi-box-arrow-in-right me-2"></i> Branding Halaman Login
                                </button>
                                <button class="nav-link py-3 px-4 border-bottom rounded-0 text-start" id="tab-pdf" data-bs-toggle="pill" data-bs-target="#content-pdf" type="button" role="tab">
                                    <i class="bi bi-file-earmark-pdf me-2"></i> Otoritas Laporan PDF
                                </button>
                                <button class="nav-link py-3 px-4 rounded-0 text-start" id="tab-teknis" data-bs-toggle="pill" data-bs-target="#content-teknis" type="button" role="tab">
                                    <i class="bi bi-gear-wide-connected me-2"></i> Parameter Teknis & GIS
                                </button>
                            </div>
                        </div>

                        <!-- Tab Content -->
                        <div class="col-md-9 p-4 bg-white shadow-sm" style="min-height: 750px;">
                            <div class="tab-content" id="v-pills-tabContent">
                                
                                <!-- Tab 1: Identitas & Visual -->
                                <div class="tab-pane fade show active" id="content-branding" role="tabpanel">
                                    <h6 class="fw-800 text-uppercase text-primary mb-4" style="font-size: 0.8rem; letter-spacing: 1px;">
                                        Identitas Utama & Branding Visual
                                    </h6>
                                    <div class="row g-4">
                                        <div class="col-md-6">
                                            <label class="form-label fw-700 small">Nama Aplikasi Utama</label>
                                            <input type="text" name="app_name" class="form-control fw-600 shadow-none border-secondary-subtle" value="<?= esc($app_name) ?>" required>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label fw-700 small">Warna Tema Utama System</label>
                                            <div class="d-flex align-items-center gap-3">
                                                <input type="color" name="header_color" class="form-control form-control-color border-0 scale-110" value="<?= esc($header_color) ?>">
                                                <span class="fw-800 text-muted small letter-spacing-1"><?= strtoupper(esc($header_color)) ?></span>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <label class="form-label fw-700 small">Slogan / Teks Header Navbar</label>
                                            <input type="text" name="app_subtitle" class="form-control fw-600" value="<?= esc($app_subtitle) ?>" required>
                                        </div>

                                        <!-- Logo Navbar Section -->
                                        <div class="col-md-12 mt-2">
                                            <label class="form-label fw-800 small mb-3 text-muted text-uppercase">A. Logo Navbar (Halaman Publik - Maks 3)</label>
                                            <div class="row g-3">
                                                <?php for ($i = 1; $i <= 3; $i++): ?>
                                                    <div class="col-md-4">
                                                        <div class="p-3 bg-light border rounded-4 text-center transition-all h-100 d-flex flex-column justify-content-between">
                                                            <div class="logo-preview mb-3 flex-grow-1 d-flex align-items-center justify-content-center">
                                                                <div class="d-inline-block position-relative">
                                                                    <?php $logoVar = 'logo_navbar_' . $i; if ($$logoVar): ?>
                                                                        <img src="<?= get_media_url($$logoVar) ?>" class="rounded bg-white p-2 border shadow-sm" style="height: 60px; max-width: 100%; object-fit: contain;">
                                                                        <a href="<?= base_url('admin/settings/delete-logo/logo_navbar_' . $i) ?>" class="btn btn-danger btn-xs position-absolute top-0 start-100 translate-middle rounded-circle shadow" onclick="return confirm('Hapus logo?')"><i class="bi bi-x"></i></a>
                                                                    <?php else: ?>
                                                                        <div class="rounded bg-white p-2 border d-flex align-items-center justify-content-center border-dashed" style="width: 100px; height: 60px;">
                                                                            <i class="bi bi-image text-muted opacity-25"></i>
                                                                        </div>
                                                                    <?php endif; ?>
                                                                </div>
                                                            </div>
                                                            <input type="file" name="logo_navbar_<?= $i ?>" class="form-control form-control-sm" accept="image/*">
                                                            <small class="text-muted d-block mt-2 fw-800" style="font-size: 0.7rem;">NAVBAR <?= $i ?></small>
                                                        </div>
                                                    </div>
                                                <?php endfor; ?>
                                            </div>
                                        </div>

                                        <!-- Sidebar Logo -->
                                        <div class="col-md-12 mt-2 pt-3 border-top">
                                            <label class="form-label fw-800 small mb-3 text-muted text-uppercase text-center d-block">B. Logo Interface Internal</label>
                                            <div class="d-flex justify-content-center">
                                                <div class="col-md-6">
                                                    <div class="p-3 bg-light border rounded-4 text-center">
                                                        <div class="logo-preview mb-3">
                                                            <div class="d-inline-block position-relative">
                                                                <?php if ($logo_sidebar): ?>
                                                                    <img src="<?= get_media_url($logo_sidebar) ?>" class="rounded bg-white p-2 border shadow-sm" style="height: 65px;">
                                                                    <a href="<?= base_url('admin/settings/delete-logo/logo_sidebar') ?>" class="btn btn-danger btn-xs position-absolute top-0 start-100 translate-middle rounded-circle shadow" onclick="return confirm('Hapus logo?')"><i class="bi bi-x"></i></a>
                                                                <?php else: ?>
                                                                    <div class="rounded bg-white p-2 border d-flex align-items-center justify-content-center border-dashed" style="width: 85px; height: 65px;"><i class="bi bi-image text-muted opacity-25"></i></div>
                                                                <?php endif; ?>
                                                            </div>
                                                        </div>
                                                        <input type="file" name="logo_sidebar" class="form-control form-control-sm" accept="image/*">
                                                        <small class="text-muted d-block mt-2 fw-700">Logo Sidebar Admin Panel</small>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Tab 2: Kontak & Media Sosial -->
                                <div class="tab-pane fade" id="content-kontak" role="tabpanel">
                                    <h6 class="fw-800 text-uppercase text-primary mb-4" style="font-size: 0.8rem; letter-spacing: 1px;">
                                        Informasi Kontak & Media Sosial Instansi
                                    </h6>
                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <label class="form-label fw-700 small text-uppercase text-muted">A. Email Resmi</label>
                                            <div class="input-group">
                                                <span class="input-group-text bg-white border-end-0"><i class="bi bi-envelope text-primary"></i></span>
                                                <input type="email" name="contact_email" class="form-control border-start-0 ps-0 fw-600" value="<?= esc($contact_email) ?>">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label fw-700 small text-uppercase text-muted">B. Nomor Telepon</label>
                                            <div class="input-group">
                                                <span class="input-group-text bg-white border-end-0"><i class="bi bi-telephone text-primary"></i></span>
                                                <input type="text" name="contact_phone" class="form-control border-start-0 ps-0 fw-600" value="<?= esc($contact_phone) ?>">
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <label class="form-label fw-700 small text-uppercase text-muted">C. Alamat Lengkap Kantor</label>
                                            <textarea name="agency_address" class="form-control fw-600" rows="3"><?= esc($agency_address) ?></textarea>
                                        </div>
                                        
                                        <div class="col-12 mt-4 pt-3 border-top">
                                            <h6 class="fw-800 small text-muted text-uppercase mb-3">D. Tautan Media Sosial</h6>
                                            <div class="row g-3">
                                                <div class="col-md-6">
                                                    <label class="form-label fw-700 small">Facebook URL</label>
                                                    <div class="input-group">
                                                        <span class="input-group-text bg-white border-end-0"><i class="bi bi-facebook" style="color: #1877F2;"></i></span>
                                                        <input type="url" name="facebook_url" class="form-control border-start-0 ps-0 fw-600" value="<?= esc($facebook_url) ?>">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label fw-700 small">Instagram URL</label>
                                                    <div class="input-group">
                                                        <span class="input-group-text bg-white border-end-0"><i class="bi bi-instagram" style="color: #E4405F;"></i></span>
                                                        <input type="url" name="instagram_url" class="form-control border-start-0 ps-0 fw-600" value="<?= esc($instagram_url) ?>">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label fw-700 small">YouTube URL</label>
                                                    <div class="input-group">
                                                        <span class="input-group-text bg-white border-end-0"><i class="bi bi-youtube" style="color: #FF0000;"></i></span>
                                                        <input type="url" name="youtube_url" class="form-control border-start-0 ps-0 fw-600" value="<?= esc($youtube_url) ?>">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label fw-700 small">X (Twitter) URL</label>
                                                    <div class="input-group">
                                                        <span class="input-group-text bg-white border-end-0"><i class="bi bi-twitter-x" style="color: #000;"></i></span>
                                                        <input type="url" name="twitter_url" class="form-control border-start-0 ps-0 fw-600" value="<?= esc($twitter_url) ?>">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-12 mt-4 pt-3 border-top">
                                            <label class="form-label fw-700 small text-uppercase text-muted">E. Embed Peta Kantor (Iframe)</label>
                                            <textarea name="office_map_iframe" class="form-control font-monospace small bg-light" rows="3"><?= esc($office_map_iframe) ?></textarea>
                                        </div>
                                    </div>
                                </div>

                                <!-- Tab 3: Konten Halaman Beranda -->
                                <div class="tab-pane fade" id="content-beranda" role="tabpanel">
                                    <h6 class="fw-800 text-uppercase text-primary mb-4" style="font-size: 0.8rem; letter-spacing: 1px;">
                                        Kustomisasi Konten Narasi Halaman Depan
                                    </h6>
                                    <div class="row g-3">
                                        <div class="col-md-12">
                                            <label class="form-label fw-700 small">Judul Utama Hero (Headline)</label>
                                            <input type="text" name="app_hero_title" class="form-control fw-800 fs-5 text-primary border-primary-subtle" value="<?= esc($app_hero_title) ?>">
                                        </div>
                                        <div class="col-md-12">
                                            <label class="form-label fw-700 small">Teks Deskripsi Hero</label>
                                            <textarea name="app_hero_desc" class="form-control fw-600" rows="3"><?= esc($app_hero_desc) ?></textarea>
                                        </div>
                                        <div class="col-md-12 mt-4 pt-3 border-top">
                                            <h6 class="fw-800 small text-muted text-uppercase mb-3">Section Call to Action (CTA)</h6>
                                            <div class="mb-3">
                                                <label class="form-label fw-700 small">Judul Ajakan (CTA)</label>
                                                <input type="text" name="app_cta_title" class="form-control fw-800" value="<?= esc($app_cta_title) ?>">
                                            </div>
                                            <label class="form-label fw-700 small">Deskripsi Singkat CTA</label>
                                            <textarea name="app_cta_desc" class="form-control fw-600" rows="2"><?= esc($app_cta_desc) ?></textarea>
                                        </div>
                                        <div class="col-md-12 mt-4 pt-3 border-top">
                                            <h6 class="fw-800 small text-muted text-uppercase mb-3">Informasi Brand Footer Publik</h6>
                                            <div class="mb-3">
                                                <label class="form-label fw-700 small">Deskripsi Instansi di Footer</label>
                                                <textarea name="agency_footer_desc" class="form-control fw-600" rows="3"><?= esc($agency_footer_desc) ?></textarea>
                                            </div>
                                            <div class="row g-3">
                                                <div class="col-md-6">
                                                    <label class="form-label fw-700 small">Teks Hak Cipta (Public)</label>
                                                    <input type="text" name="copyright_text" class="form-control fw-600" value="<?= esc($copyright_text) ?>">
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label fw-700 small">Slogan Global Situs</label>
                                                    <input type="text" name="app_slogan" class="form-control fw-600" value="<?= esc($app_slogan) ?>">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Tab 4: Manajemen Hero Slider (CONSOLIDATED) -->
                                <div class="tab-pane fade" id="content-slider" role="tabpanel">
                                    <h6 class="fw-800 text-uppercase text-primary mb-4" style="font-size: 0.8rem; letter-spacing: 1px;">
                                        Manajemen Visual & Animasi Hero Slider
                                    </h6>
                                    
                                    <!-- Slider Interval moved here -->
                                    <div class="p-4 bg-primary bg-opacity-10 border border-primary border-opacity-25 rounded-4 mb-4 d-flex align-items-center justify-content-between">
                                        <div>
                                            <h6 class="fw-800 text-primary mb-1">Durasi Transisi Gambar</h6>
                                            <p class="small text-muted mb-0 fw-600">Kecepatan pergantian antar gambar pada slider beranda (dalam detik).</p>
                                        </div>
                                        <div class="input-group" style="width: 150px;">
                                            <input type="number" name="hero_slide_interval" class="form-control fw-900 border-primary" value="<?= esc($hero_slide_interval ?? '5') ?>">
                                            <span class="input-group-text bg-primary text-white fw-800 border-primary">DTK</span>
                                        </div>
                                    </div>

                                    <!-- Add New Image UI -->
                                    <div class="p-4 rounded-4 border border-dashed border-secondary bg-light mb-5">
                                        <h6 class="fw-800 mb-3 small text-secondary text-uppercase"><i class="bi bi-plus-circle me-1"></i> Tambah Visual Slider Baru</h6>
                                        <div class="row g-3 align-items-end">
                                            <div class="col-md-7">
                                                <input type="file" name="hero_image" class="form-control shadow-none" accept="image/*" form="heroImageAddForm">
                                            </div>
                                            <div class="col-md-3">
                                                <input type="number" name="sort_order" class="form-control shadow-none" placeholder="Urutan (0-99)" value="0" form="heroImageAddForm">
                                            </div>
                                            <div class="col-md-2">
                                                <button type="submit" class="btn btn-primary w-100 fw-900 shadow-primary" form="heroImageAddForm">
                                                    UNGGAH
                                                </button>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Gallery -->
                                    <div class="row g-4">
                                        <?php if (!empty($hero_images)): ?>
                                            <?php foreach ($hero_images as $img): ?>
                                                <div class="col-md-4">
                                                    <div class="card border rounded-4 overflow-hidden shadow-hover transition-all">
                                                        <div class="position-relative">
                                                            <img src="<?= get_media_url($img['image_path']) ?>" class="card-img-top" style="height: 150px; object-fit: cover;">
                                                            <span class="position-absolute top-0 start-0 m-2 badge bg-dark bg-opacity-75 shadow">Urutan: <?= $img['sort_order'] ?></span>
                                                        </div>
                                                        <div class="card-footer bg-white border-0 py-2 d-flex justify-content-center">
                                                            <a href="<?= base_url('admin/settings/delete-hero/' . $img['id']) ?>" class="btn btn-sm btn-outline-danger border-0 fw-800" onclick="return confirm('Hapus gambar ini?')">
                                                                <i class="bi bi-trash3-fill"></i> Hapus
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php endforeach; ?>
                                        <?php else: ?>
                                            <div class="col-12 py-5 text-center text-muted border border-dashed rounded-4">
                                                <i class="bi bi-image-fill fs-1 opacity-25"></i>
                                                <p class="mt-2 fw-700">Belum ada gambar dalam antrian slider.</p>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>

                                <!-- Tab 5: Branding Halaman Login (CONSOLIDATED) -->
                                <div class="tab-pane fade" id="content-login" role="tabpanel">
                                    <h6 class="fw-800 text-uppercase text-primary mb-4" style="font-size: 0.8rem; letter-spacing: 1px;">
                                        Konfigurasi Identitas Halaman Login
                                    </h6>
                                    <div class="row g-4">
                                        <!-- Logo Login moved here -->
                                        <div class="col-md-12">
                                            <label class="form-label fw-800 small mb-3 text-muted text-uppercase">A. Visual Logo Login</label>
                                            <div class="d-flex justify-content-center">
                                                <div class="col-md-6">
                                                    <div class="p-4 bg-light border border-dashed rounded-4 text-center">
                                                        <div class="logo-preview mb-3">
                                                            <div class="d-inline-block position-relative">
                                                                <?php if ($logo_login): ?>
                                                                    <img src="<?= get_media_url($logo_login) ?>" class="rounded bg-white p-3 border shadow-sm" style="height: 110px;">
                                                                    <a href="<?= base_url('admin/settings/delete-logo/logo_login') ?>" class="btn btn-danger btn-xs position-absolute top-0 start-100 translate-middle rounded-circle shadow" onclick="return confirm('Hapus logo?')"><i class="bi bi-x"></i></a>
                                                                <?php else: ?>
                                                                    <div class="rounded bg-white p-3 border d-flex align-items-center justify-content-center border-dashed" style="width: 140px; height: 110px;"><i class="bi bi-image text-muted opacity-25 fs-1"></i></div>
                                                                <?php endif; ?>
                                                            </div>
                                                        </div>
                                                        <input type="file" name="logo_login" class="form-control border-secondary-subtle" accept="image/*">
                                                        <small class="text-muted d-block mt-2 fw-800">Pratinjau Logo Login</small>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Login Titles -->
                                        <div class="col-md-12 mt-3 pt-4 border-top">
                                            <label class="form-label fw-800 small mb-3 text-muted text-uppercase">B. Narasi Teks Halaman Login</label>
                                            <div class="row g-4">
                                                <div class="col-md-12">
                                                    <label class="form-label fw-700 small text-muted">Judul Headline Sidebar (Kiri)</label>
                                                    <input type="text" name="login_sidebar_title" class="form-control fw-800 ps-4 border-primary-subtle fs-5" value="<?= esc($login_sidebar_title) ?>">
                                                </div>
                                                <div class="col-md-12">
                                                    <label class="form-label fw-700 small text-muted">Judul Headline Form (Kanan)</label>
                                                    <input type="text" name="login_form_title" class="form-control fw-800 ps-4 border-primary-subtle fs-5" value="<?= esc($login_form_title) ?>">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Tab 6: Otoritas Laporan PDF -->
                                <div class="tab-pane fade" id="content-pdf" role="tabpanel">
                                    <h6 class="fw-800 text-uppercase text-primary mb-4" style="font-size: 0.8rem; letter-spacing: 1px;">
                                        Parameter Otoritas & Legalitas Laporan PDF
                                    </h6>
                                    <div class="row g-3">
                                        <div class="col-md-12 mb-4">
                                            <div class="form-check form-switch p-4 bg-warning bg-opacity-10 rounded-4 border border-warning border-opacity-25 d-flex align-items-center justify-content-between">
                                                <div>
                                                    <label class="form-check-label fw-800 text-warning-emphasis d-block mb-1" for="pdf_show_qr">
                                                        Sertakan QR Code Verifikasi
                                                    </label>
                                                    <span class="small text-muted fw-600">Menambahkan kode QR validasi keaslian dokumen otomatis.</span>
                                                </div>
                                                <input class="form-check-input ms-0 scale-150" type="checkbox" name="pdf_show_qr" id="pdf_show_qr" value="1" <?= ($pdf_show_qr ?? '1') == '1' ? 'checked' : '' ?>>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <label class="form-label fw-700 small">Nama Lengkap Pejabat</label>
                                            <input type="text" name="kepala_dinas_nama" class="form-control fw-700 border-secondary-subtle" value="<?= esc($kepala_dinas_nama) ?>">
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label fw-700 small">NIP Resmi</label>
                                            <input type="text" name="kepala_dinas_nip" class="form-control fw-700 border-secondary-subtle" value="<?= esc($kepala_dinas_nip) ?>">
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label fw-700 small">Jabatan Utama</label>
                                            <input type="text" name="kepala_dinas_jabatan" class="form-control fw-600" value="<?= esc($kepala_dinas_jabatan) ?>">
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label fw-700 small">Tempat / Lokasi</label>
                                            <input type="text" name="kepala_dinas_lokasi" class="form-control fw-600" value="<?= esc($kepala_dinas_lokasi) ?>">
                                        </div>

                                        <div class="col-12 mt-4 pt-3 border-top">
                                            <h6 class="fw-800 small text-muted text-uppercase mb-3">Informasi Kop Surat (Official Header)</h6>
                                            <div class="row g-3">
                                                <div class="col-md-12">
                                                    <label class="form-label fw-700 small text-muted">A. Nama Pemerintah</label>
                                                    <input type="text" name="agency_main_name" class="form-control fw-700 text-primary border-primary-subtle" value="<?= esc($agency_main_name) ?>">
                                                </div>
                                                <div class="col-md-12">
                                                    <label class="form-label fw-700 small text-muted">B. Nama Dinas / Satker</label>
                                                    <input type="text" name="agency_sub_name" class="form-control fw-800 text-uppercase border-primary-subtle" value="<?= esc($agency_sub_name) ?>">
                                                </div>
                                                <div class="col-md-12">
                                                    <label class="form-label fw-700 small text-muted">C. Detail Kontak (Baris Ketiga Kop)</label>
                                                    <input type="text" name="agency_contact" class="form-control fw-600 border-secondary-subtle" value="<?= esc($agency_contact) ?>">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-12 mt-4 pt-3 border-top">
                                            <label class="form-label fw-700 small text-danger-emphasis">Disclaimer & Klausul Hukum Laporan</label>
                                            <textarea name="pdf_disclaimer" class="form-control fw-500 small border-secondary-subtle" rows="5" style="line-height: 1.6;"><?= esc($pdf_disclaimer) ?></textarea>
                                        </div>
                                    </div>
                                </div>

                                <!-- Tab 7: Parameter Teknis & GIS -->
                                <div class="tab-pane fade" id="content-teknis" role="tabpanel">
                                    <h6 class="fw-800 text-uppercase text-primary mb-4" style="font-size: 0.8rem; letter-spacing: 1px;">
                                        Parameter Konfigurasi Teknis & Geospasial
                                    </h6>
                                    <div class="row g-4">
                                        <div class="col-md-12">
                                            <div class="p-4 rounded-4 border-start border-4 border-primary bg-primary bg-opacity-10 shadow-sm">
                                                <h6 class="fw-800 mb-2 font-inter">Titik Koordinat Tengah Peta</h6>
                                                <p class="small text-muted mb-4 fw-600">Berfungsi sebagai titik utama kamera saat memuat peta interaktif pertama kali.</p>
                                                <div class="row g-4">
                                                    <div class="col-md-6">
                                                        <label class="form-label fw-800 small text-primary">LATITUDE</label>
                                                        <input type="text" name="map_center_lat" class="form-control fw-900 border-primary-subtle py-3 text-center fs-5 shadow-sm" value="<?= esc($map_center_lat) ?>">
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label class="form-label fw-800 small text-primary">LONGITUDE</label>
                                                        <input type="text" name="map_center_lng" class="form-control fw-900 border-primary-subtle py-3 text-center fs-5 shadow-sm" value="<?= esc($map_center_lng) ?>">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12 mt-2 pt-4 border-top">
                                            <h6 class="fw-800 small text-muted text-uppercase mb-4">Informasi Narasi Sistem Internal</h6>
                                            <div class="row g-3">
                                                <div class="col-md-6">
                                                    <label class="form-label fw-700 small">Teks Deskripsi Sidebar (Header)</label>
                                                    <input type="text" name="header_text" class="form-control fw-600 border-secondary-subtle" value="<?= esc($header_text) ?>">
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label fw-700 small">Teks Hak Cipta Sidebar (Footer)</label>
                                                    <input type="text" name="footer_text" class="form-control fw-600 border-secondary-subtle" value="<?= esc($footer_text) ?>">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>

                            <!-- Integrated Action Bar -->
                            <div class="d-flex align-items-center justify-content-between mt-5 pt-4 border-top">
                                <p class="small text-muted fw-700 italic mb-0 d-none d-md-block"><i class="bi bi-info-circle-fill text-primary me-2"></i> Klik tombol simpan untuk menerapkan seluruh perubahan secara permanen.</p>
                                <div class="d-flex gap-2">
                                    <a href="<?= base_url('admin/dashboard') ?>" class="btn btn-light px-4 fw-800 rounded-pill border shadow-sm">BATALKAN</a>
                                    <button type="submit" class="btn btn-primary px-5 py-2 fw-1000 rounded-pill shadow-primary border-0 scale-up-hover">
                                        SIMPAN CONFIG <i class="bi bi-cloud-arrow-up-fill ms-2"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>

                <!-- Hidden submission target for file-only uploads -->
                <form id="heroImageAddForm" action="<?= base_url('admin/settings/add-hero') ?>" method="post" enctype="multipart/form-data" style="display:none;"></form>
            </div>
        </div>
    </div>
</div>

<style>
/* PREMIUM SETTINGS STYLING */
.settings-pills .nav-link {
    color: #888;
    font-weight: 800;
    font-size: 0.8rem;
    text-transform: uppercase;
    letter-spacing: 0.85px;
    border-radius: 0;
    transition: all 0.25s ease;
    border-bottom: 1px solid rgba(0,0,0,0.035) !important;
    padding: 20px 24px;
}

.settings-pills .nav-link i {
    font-size: 1.25rem;
    margin-right: 15px;
    opacity: 0.6;
}

.settings-pills .nav-link.active {
    background-color: #fff !important;
    color: var(--bs-primary) !important;
    box-shadow: inset 8px 0 0 var(--bs-primary);
    background-image: linear-gradient(to right, rgba(var(--bs-primary-rgb), 0.05), transparent);
}

.settings-pills .nav-link.active i {
    opacity: 1;
    transform: scale(1.1);
}

.settings-pills .nav-link:hover:not(.active) {
    background-color: rgba(var(--bs-primary-rgb), 0.02);
    color: #333;
}

.card-premium {
    border-radius: 28px;
    box-shadow: 0 35px 80px rgba(0,0,0,0.15);
    border: 1px solid rgba(0,0,0,0.02);
}

.shadow-primary {
    box-shadow: 0 12px 25px rgba(var(--bs-primary-rgb), 0.45) !important;
}

.transition-all {
    transition: all 0.35s cubic-bezier(0.165, 0.84, 0.44, 1);
}

.shadow-hover:hover {
    transform: translateY(-10px);
    box-shadow: 0 20px 45px rgba(0,0,0,0.12) !important;
}

.scale-up-hover:hover {
    transform: scale(1.03);
}

.border-dashed {
    border-style: dashed !important;
    border-width: 2px !important;
}

.letter-spacing-1 { letter-spacing: 1px; }
.fw-900 { font-weight: 900; }
.fw-1000 { font-weight: 1000; }

.btn-xs {
    width: 22px;
    height: 22px;
    padding: 0;
    font-size: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Intercept separate upload forms
    const mainForm = document.getElementById('settingsForm');
    const uploadTrigger = document.querySelector('[form="heroImageAddForm"]');
    
    if (uploadTrigger) {
        uploadTrigger.addEventListener('click', function(e) {
            e.preventDefault();
            
            const heroInput = mainForm.querySelector('input[name="hero_image"]');
            if (!heroInput || !heroInput.value) {
                alert('Pilih gambar slider yang ingin diungguh terlebih dahulu!');
                return;
            }
            
            // Re-route form to add-hero temporarily
            mainForm.action = "<?= base_url('admin/settings/add-hero') ?>";
            mainForm.submit();
        });
    }
});
</script>
<?php $this->endSection() ?>