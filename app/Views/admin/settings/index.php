<?php /** @var \CodeIgniter\View\View $this */?>
<?php $this->extend('layouts/admin')?>

<?php $this->section('title')?>
System Configuration
<?php $this->endSection()?>

<?php $this->section('content')?>
<div class="row">
    <div class="col-xl-9">
        <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success border-0 shadow-sm rounded-4 d-flex align-items-center p-3 mb-4" role="alert">
            <i class="bi bi-check-circle-fill fs-4 me-3"></i>
            <div class="fw-600">
                <?= session()->getFlashdata('success')?>
            </div>
            <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"></button>
        </div>
        <?php
endif; ?>

        <div class="card card-premium">
            <div class="card-header bg-white py-4 px-4 border-0">
                <h5 class="mb-1 fw-800 text-dark"><i class="bi bi-sliders2 me-2"></i> Pengaturan Global</h5>
                <p class="text-muted small mb-0 fw-500">Sesuaikan identitas instansi dan konfigurasi teknis sistem.</p>
            </div>
            <div class="card-body p-4 pt-2">
                <form action="<?= base_url('admin/settings/update')?>" method="post" enctype="multipart/form-data">

                    <div class="p-4 bg-light rounded-4 mb-4 border">
                        <div class="d-flex align-items-center justify-content-between mb-4">
                            <h6 class="fw-800 text-primary text-uppercase m-0"
                                style="font-size: 0.75rem; letter-spacing: 1px;">Identitas & Branding</h6>
                            <span
                                class="badge bg-primary-subtle text-primary border border-primary-subtle px-3 py-2 rounded-pill small fw-700">
                                <i class="bi bi-person-badge me-1"></i> Mode: Role
                                <?= ucfirst($role)?>
                            </span>
                        </div>

                        <div class="row g-3">
                            <div class="col-md-6 mb-2">
                                <label class="form-label fw-700 small">Nama Instansi / Aplikasi</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-white border-end-0"><i
                                            class="bi bi-building text-muted"></i></span>
                                    <input type="text" name="app_name" class="form-control border-start-0 ps-0"
                                        value="<?= esc($app_name)?>" required>
                                </div>
                            </div>

                            <div class="col-md-6 mb-2">
                                <label class="form-label fw-700 small">Sidebar Subtitle</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-white border-end-0"><i
                                            class="bi bi-fonts text-muted"></i></span>
                                    <input type="text" name="app_subtitle" class="form-control border-start-0 ps-0"
                                        value="<?= esc($app_subtitle ?? 'SISTEM SPASIAL')?>" required>
                                </div>
                            </div>

                            <div class="col-md-6 mb-2">
                                <label class="form-label fw-700 small">Header Text (Slogan)</label>
                                <input type="text" name="header_text" class="form-control"
                                    value="<?= esc($header_text ?? 'Sistem Informasi Geotagging Tata Ruang')?>">
                            </div>

                            <div class="col-md-6 mb-2">
                                <label class="form-label fw-700 small">Footer Copyright Text</label>
                                <input type="text" name="footer_text" class="form-control"
                                    value="<?= esc($footer_text ?? 'Dinas Penanaman Modal dan PTSP')?>">
                            </div>

                            <div class="col-md-12">
                                <label class="form-label fw-700 small mb-3 d-block text-muted">Logo Navbar (Maksimal 3 Upload)</label>
                                <div class="row g-3">
                                    <!-- Logo Navbar 1 -->
                                    <div class="col-md-4">
                                        <div class="p-3 bg-white border rounded-3">
                                            <div class="text-center mb-3">
                                                <div class="d-inline-block">
                                                    <?php if ($logo_navbar_1): ?>
                                                    <img src="<?= base_url($logo_navbar_1)?>" alt="Logo 1"
                                                        class="rounded border p-1 bg-light" style="height: 50px;">
                                                    <?php
else: ?>
                                                    <div class="rounded border bg-light d-flex align-items-center justify-content-center"
                                                        style="width: 80px; height: 50px;">
                                                        <i class="bi bi-image text-muted"></i>
                                                    </div>
                                                    <?php
endif; ?>
                                                </div>
                                            </div>
                                            <input type="file" name="logo_navbar_1" class="form-control form-control-sm"
                                                accept="image/*">
                                            <small class="text-muted d-block mt-2">Logo 1</small>
                                        </div>
                                    </div>

                                    <!-- Logo Navbar 2 -->
                                    <div class="col-md-4">
                                        <div class="p-3 bg-white border rounded-3">
                                            <div class="text-center mb-3">
                                                <div class="d-inline-block">
                                                    <?php if ($logo_navbar_2): ?>
                                                    <img src="<?= base_url($logo_navbar_2)?>" alt="Logo 2"
                                                        class="rounded border p-1 bg-light" style="height: 50px;">
                                                    <?php
else: ?>
                                                    <div class="rounded border bg-light d-flex align-items-center justify-content-center"
                                                        style="width: 80px; height: 50px;">
                                                        <i class="bi bi-image text-muted"></i>
                                                    </div>
                                                    <?php
endif; ?>
                                                </div>
                                            </div>
                                            <input type="file" name="logo_navbar_2" class="form-control form-control-sm"
                                                accept="image/*">
                                            <small class="text-muted d-block mt-2">Logo 2</small>
                                        </div>
                                    </div>

                                    <!-- Logo Navbar 3 -->
                                    <div class="col-md-4">
                                        <div class="p-3 bg-white border rounded-3">
                                            <div class="text-center mb-3">
                                                <div class="d-inline-block">
                                                    <?php if ($logo_navbar_3): ?>
                                                    <img src="<?= base_url($logo_navbar_3)?>" alt="Logo 3"
                                                        class="rounded border p-1 bg-light" style="height: 50px;">
                                                    <?php
else: ?>
                                                    <div class="rounded border bg-light d-flex align-items-center justify-content-center"
                                                        style="width: 80px; height: 50px;">
                                                        <i class="bi bi-image text-muted"></i>
                                                    </div>
                                                    <?php
endif; ?>
                                                </div>
                                            </div>
                                            <input type="file" name="logo_navbar_3" class="form-control form-control-sm"
                                                accept="image/*">
                                            <small class="text-muted d-block mt-2">Logo 3</small>
                                        </div>
                                    </div>
                                </div>
                                <small class="text-muted d-block mt-2"><i class="bi bi-info-circle me-1"></i>
                                    Gunakan file PNG transparan untuk hasil terbaik (Max 2MB per file).</small>
                            </div>

                            <!-- Logo Sidebar -->
                            <div class="col-md-12">
                                <label class="form-label fw-700 small">Logo Sidebar</label>
                                <div class="p-3 bg-white border rounded-3 d-flex align-items-center gap-4">
                                    <div class="avatar-preview">
                                        <?php if ($logo_sidebar): ?>
                                        <img src="<?= base_url($logo_sidebar)?>" alt="Logo Sidebar"
                                            class="rounded border p-1 bg-light" style="height: 60px;">
                                        <?php
else: ?>
                                        <div class="rounded border bg-light d-flex align-items-center justify-content-center"
                                            style="width: 60px; height: 60px;">
                                            <i class="bi bi-image text-muted"></i>
                                        </div>
                                        <?php
endif; ?>
                                    </div>
                                    <div class="flex-grow-1">
                                        <input type="file" name="logo_sidebar" class="form-control form-control-sm"
                                            accept="image/*">
                                        <small class="text-muted d-block mt-1">Gunakan file PNG transparan untuk hasil
                                            terbaik (Max 2MB).</small>
                                    </div>
                                </div>
                            </div>

                            <!-- Logo Login -->
                            <div class="col-md-12">
                                <label class="form-label fw-700 small">Logo Login</label>
                                <div class="p-3 bg-white border rounded-3 d-flex align-items-center gap-4">
                                    <div class="avatar-preview">
                                        <?php if ($logo_login): ?>
                                        <img src="<?= base_url($logo_login)?>" alt="Logo Login"
                                            class="rounded border p-1 bg-light" style="height: 60px;">
                                        <?php
else: ?>
                                        <div class="rounded border bg-light d-flex align-items-center justify-content-center"
                                            style="width: 60px; height: 60px;">
                                            <i class="bi bi-image text-muted"></i>
                                        </div>
                                        <?php
endif; ?>
                                    </div>
                                    <div class="flex-grow-1">
                                        <input type="file" name="logo_login" class="form-control form-control-sm"
                                            accept="image/*">
                                        <small class="text-muted d-block mt-1">Gunakan file PNG transparan untuk hasil
                                            terbaik (Max 2MB).</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Section: Theme -->
                    <div class="p-4 bg-light rounded-4 mb-4 border">
                        <h6 class="fw-800 text-primary text-uppercase mb-4"
                            style="font-size: 0.75rem; letter-spacing: 1px;">Visual & Tema</h6>
                        <div class="mb-0">
                            <label class="form-label fw-700 small">Warna Utama (Primary Color) -
                                <?= ucfirst($role)?>
                            </label>
                            <div class="d-flex align-items-center gap-3">
                                <input type="color" name="header_color"
                                    class="form-control form-control-color border-0 shadow-sm"
                                    value="<?= esc($header_color)?>" title="Pilih Warna Tema">
                                <span class="fw-600 text-muted">
                                    <?= esc($header_color)?>
                                </span>
                            </div>
                            <small class="text-muted mt-2 d-block">Warna ini akan digunakan sebagai identitas visual
                                utama aplikasi khusus untuk akun Anda (
                                <?= $role?>).
                            </small>
                        </div>
                    </div>

                    <div class="p-4 bg-light rounded-4 mb-4 border">
                        <h6 class="fw-800 text-primary text-uppercase mb-4"
                            style="font-size: 0.75rem; letter-spacing: 1px;">Konfigurasi Peta (GIS)</h6>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label fw-700 small">Map Center Latitude</label>
                                <input type="text" name="map_center_lat" class="form-control"
                                    value="<?= esc($map_center_lat)?>" placeholder="-3.456xxx">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-700 small">Map Center Longitude</label>
                                <input type="text" name="map_center_lng" class="form-control"
                                    value="<?= esc($map_center_lng)?>" placeholder="115.982xxx">
                            </div>
                        </div>
                    </div>

                    <div class="d-flex gap-2 mt-5">
                        <button type="submit" class="btn btn-primary px-5 fw-700 rounded-3 shadow">
                            <i class="bi bi-save2-fill me-2"></i> SIMPAN PERUBAHAN
                        </button>
                        <a href="<?= base_url('dashboard')?>" class="btn btn-light fw-700 rounded-3 px-4 border">
                            BATAL
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?php $this->endSection()?>