<?php /** @var \CodeIgniter\View\View $this */ ?>
<?php $this->extend('layouts/admin') ?>

<?php $this->section('title') ?>
Konfigurasi Sistem
<?php $this->endSection() ?>

<?php $this->section('content') ?>
<div class="row">
    <div class="col-xl-9">
        <?php if (session()->getFlashdata('success')): ?>
            <div class="alert alert-success border-0 shadow-sm rounded-4 d-flex align-items-center p-3 mb-4" role="alert">
                <i class="bi bi-check-circle-fill fs-4 me-3"></i>
                <div class="fw-600">
                    <?= session()->getFlashdata('success') ?>
                </div>
                <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"></button>
            </div>
            <?php
        endif; ?>

        <div class="card card-premium mb-4">
            <div class="card-header bg-white py-4 px-4 border-0">
                <h5 class="mb-1 fw-800 text-dark"><i class="bi bi-sliders2 me-2"></i> Pengaturan Global</h5>
                <p class="text-muted small mb-0 fw-500">Sesuaikan identitas instansi dan konfigurasi teknis sistem.</p>
            </div>
            <div class="card-body p-4 pt-2">
                <form action="<?= base_url('admin/settings/update') ?>" method="post" enctype="multipart/form-data">

                    <!-- Section: Branding -->
                    <div class="p-4 bg-light rounded-4 mb-4 border">
                        <div class="d-flex align-items-center justify-content-between mb-4">
                            <h6 class="fw-800 text-primary text-uppercase m-0"
                                style="font-size: 0.75rem; letter-spacing: 1px;">Identitas & Branding</h6>
                            <span
                                class="badge bg-primary-subtle text-primary border border-primary-subtle px-3 py-2 rounded-pill small fw-700">
                                <i class="bi bi-person-badge me-1"></i> Mode: Role <?= ucfirst($role) ?>
                            </span>
                        </div>

                        <div class="row g-3">
                            <div class="col-md-6 mb-2">
                                <label class="form-label fw-700 small">Nama Instansi / Aplikasi</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-white border-end-0"><i
                                            class="bi bi-building text-muted"></i></span>
                                    <input type="text" name="app_name" class="form-control border-start-0 ps-0"
                                        value="<?= esc($app_name) ?>" required>
                                </div>
                            </div>

                            <div class="col-md-6 mb-2">
                                <label class="form-label fw-700 small">Slogan / Teks Header</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-white border-end-0"><i
                                            class="bi bi-fonts text-muted"></i></span>
                                    <input type="text" name="app_subtitle" class="form-control border-start-0 ps-0"
                                        value="<?= esc($app_subtitle ?? 'SISTEM SPASIAL') ?>" required>
                                </div>
                            </div>

                            <div class="col-md-6 mb-2">
                                <label class="form-label fw-700 small">Teks Deskripsi (Header)</label>
                                <input type="text" name="header_text" class="form-control"
                                    value="<?= esc($header_text ?? 'Sistem Informasi Geotagging Tata Ruang') ?>">
                            </div>

                            <div class="col-md-6 mb-2">
                                <label class="form-label fw-700 small">Teks Hak Cipta (Footer)</label>
                                <input type="text" name="footer_text" class="form-control"
                                    value="<?= esc($footer_text ?? 'Dinas Penanaman Modal dan PTSP') ?>">
                            </div>

                            <div class="col-md-12">
                                <label class="form-label fw-700 small mb-3 d-block text-muted">Logo Navbar (Maksimal 3
                                    Upload)</label>
                                <div class="row g-3">
                                    <?php for ($i = 1; $i <= 3; $i++): ?>
                                        <div class="col-md-4">
                                            <div class="p-3 bg-white border rounded-3 position-relative">
                                                <div class="text-center mb-3">
                                                    <div class="d-inline-block position-relative">
                                                        <?php $logoVar = 'logo_navbar_' . $i;
                                                        if ($$logoVar): ?>
                                                            <img src="<?= base_url($$logoVar) ?>" alt="Logo <?= $i ?>"
                                                                class="rounded border p-1 bg-light" style="height: 50px;">
                                                            <a href="<?= base_url('admin/settings/delete-logo/logo_navbar_' . $i) ?>"
                                                                class="btn btn-danger btn-xs position-absolute top-0 start-100 translate-middle rounded-circle shadow-sm"
                                                                style="width: 20px; height: 20px; padding: 0; font-size: 10px; line-height: 20px;"
                                                                onclick="return confirm('Hapus logo ini?')">
                                                                <i class="bi bi-x"></i>
                                                            </a>
                                                        <?php else: ?>
                                                            <div class="rounded border bg-light d-flex align-items-center justify-content-center"
                                                                style="width: 80px; height: 50px;">
                                                                <i class="bi bi-image text-muted"></i>
                                                            </div>
                                                        <?php endif; ?>
                                                    </div>
                                                </div>
                                                <input type="file" name="logo_navbar_<?= $i ?>"
                                                    class="form-control form-control-sm" accept="image/*">
                                                <small class="text-muted d-block mt-2">Logo <?= $i ?></small>
                                            </div>
                                        </div>
                                    <?php endfor; ?>
                                </div>
                                <small class="text-muted d-block mt-2"><i class="bi bi-info-circle me-1"></i> Gunakan
                                    file PNG transparan untuk hasil terbaik (Max 2MB per file).</small>
                            </div>

                            <!-- Logo Sidebar -->
                            <div class="col-md-6 mb-2">
                                <label class="form-label fw-700 small">Logo Sidebar</label>
                                <div class="p-3 bg-white border rounded-3 d-flex align-items-center gap-3">
                                    <div class="position-relative">
                                        <?php if ($logo_sidebar): ?>
                                            <img src="<?= base_url($logo_sidebar) ?>" class="rounded border p-1"
                                                style="height: 40px;">
                                            <a href="<?= base_url('admin/settings/delete-logo/logo_sidebar') ?>"
                                                class="btn btn-danger btn-xs position-absolute top-0 start-100 translate-middle rounded-circle shadow-sm"
                                                style="width: 18px; height: 18px; padding: 0; font-size: 9px; line-height: 18px;"
                                                onclick="return confirm('Hapus logo ini?')">
                                                <i class="bi bi-x"></i>
                                            </a>
                                        <?php else: ?>
                                            <div class="rounded border bg-light d-flex align-items-center justify-content-center"
                                                style="width: 40px; height: 40px;"><i class="bi bi-image"></i></div>
                                        <?php endif; ?>
                                    </div>
                                    <input type="file" name="logo_sidebar" class="form-control form-control-sm"
                                        accept="image/*">
                                </div>
                            </div>

                            <!-- Logo Login -->
                            <div class="col-md-6 mb-2">
                                <label class="form-label fw-700 small">Logo Login</label>
                                <div class="p-3 bg-white border rounded-3 d-flex align-items-center gap-3">
                                    <div class="position-relative">
                                        <?php if ($logo_login): ?>
                                            <img src="<?= base_url($logo_login) ?>" class="rounded border p-1"
                                                style="height: 40px;">
                                            <a href="<?= base_url('admin/settings/delete-logo/logo_login') ?>"
                                                class="btn btn-danger btn-xs position-absolute top-0 start-100 translate-middle rounded-circle shadow-sm"
                                                style="width: 18px; height: 18px; padding: 0; font-size: 9px; line-height: 18px;"
                                                onclick="return confirm('Hapus logo ini?')">
                                                <i class="bi bi-x"></i>
                                            </a>
                                        <?php else: ?>
                                            <div class="rounded border bg-light d-flex align-items-center justify-content-center"
                                                style="width: 40px; height: 40px;"><i class="bi bi-image"></i></div>
                                        <?php endif; ?>
                                    </div>
                                    <input type="file" name="logo_login" class="form-control form-control-sm"
                                        accept="image/*">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Section: Slider Interval -->
                    <div class="p-4 bg-light rounded-4 mb-4 border">
                        <h6 class="fw-800 text-primary text-uppercase mb-4"
                            style="font-size: 0.75rem; letter-spacing: 1px;">Konfigurasi Slider</h6>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label fw-700 small"><i class="bi bi-clock-history me-1"></i> Durasi
                                    Auto-Slide (Detik)</label>
                                <div class="input-group">
                                    <input type="number" name="hero_slide_interval" class="form-control"
                                        value="<?= esc($hero_slide_interval ?? '5') ?>" min="1" max="60">
                                    <span class="input-group-text bg-white">Detik</span>
                                </div>
                                <small class="text-muted">Lama waktu setiap gambar tampil sebelum berpindah.</small>
                            </div>
                        </div>
                    </div>

                    <!-- Section: Theme -->
                    <div class="p-4 bg-light rounded-4 mb-4 border">
                        <h6 class="fw-800 text-primary text-uppercase mb-4"
                            style="font-size: 0.75rem; letter-spacing: 1px;">Visual & Tema</h6>
                        <div class="mb-0">
                            <label class="form-label fw-700 small">Warna Utama (Primary Color)</label>
                            <div class="d-flex align-items-center gap-3">
                                <input type="color" name="header_color"
                                    class="form-control form-control-color border-0 shadow-sm"
                                    value="<?= esc($header_color) ?>" title="Pilih Warna Tema">
                                <span class="fw-600 text-muted"><?= esc($header_color) ?></span>
                            </div>
                        </div>
                    </div>

                    <!-- Section: GIS -->
                    <div class="p-4 bg-light rounded-4 mb-4 border">
                        <h6 class="fw-800 text-primary text-uppercase mb-4"
                            style="font-size: 0.75rem; letter-spacing: 1px;">Konfigurasi Peta (GIS)</h6>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label fw-700 small">Titik Tengah Peta (Latitude)</label>
                                <input type="text" name="map_center_lat" class="form-control"
                                    value="<?= esc($map_center_lat) ?>" placeholder="-3.456xxx">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-700 small">Titik Tengah Peta (Longitude)</label>
                                <input type="text" name="map_center_lng" class="form-control"
                                    value="<?= esc($map_center_lng) ?>" placeholder="115.982xxx">
                            </div>
                        </div>
                    </div>

                    <!-- Section: Social Media & Map Frame -->
                    <div class="p-4 bg-light rounded-4 mb-4 border"
                        style="background: rgba(var(--bs-primary-rgb), 0.02) !important;">
                        <h6 class="fw-800 text-primary text-uppercase mb-4"
                            style="font-size: 0.75rem; letter-spacing: 1px;">Media Sosial & Lokasi Kantor</h6>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label fw-700 small">Facebook URL</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-white border-end-0"><i
                                            class="bi bi-facebook text-primary"></i></span>
                                    <input type="url" name="facebook_url" class="form-control border-start-0"
                                        value="<?= esc($facebook_url ?? '') ?>" placeholder="https://facebook.com/...">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-700 small">Instagram URL</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-white border-end-0"><i
                                            class="bi bi-instagram text-danger"></i></span>
                                    <input type="url" name="instagram_url" class="form-control border-start-0"
                                        value="<?= esc($instagram_url ?? '') ?>"
                                        placeholder="https://instagram.com/...">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-700 small">YouTube URL</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-white border-end-0"><i
                                            class="bi bi-youtube text-danger"></i></span>
                                    <input type="url" name="youtube_url" class="form-control border-start-0"
                                        value="<?= esc($youtube_url ?? '') ?>" placeholder="https://youtube.com/...">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-700 small">X (Twitter) URL</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-white border-end-0"><i
                                            class="bi bi-twitter-x text-dark"></i></span>
                                    <input type="url" name="twitter_url" class="form-control border-start-0"
                                        value="<?= esc($twitter_url ?? '') ?>" placeholder="https://x.com/...">
                                </div>
                            </div>
                            <div class="col-12 mt-3">
                                <label class="form-label fw-700 small">Google Maps Embed (Iframe)</label>
                                <textarea name="office_map_iframe" class="form-control font-monospace small" rows="3"
                                    placeholder='<iframe src="https://www.google.com/maps/embed?..." ...></iframe>'><?= esc($office_map_iframe ?? '') ?></textarea>
                                <small class="text-muted mt-1 d-block"><i class="bi bi-info-circle me-1"></i> Paste kode
                                    iframe dari Google Maps "Bagikan > Sematkan Peta".</small>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex gap-2 mt-5">
                        <button type="submit" class="btn btn-primary px-5 fw-700 rounded-3 shadow">
                            <i class="bi bi-save2-fill me-2"></i> SIMPAN PERUBAHAN
                        </button>
                        <a href="<?= base_url('dashboard') ?>"
                            class="btn btn-light fw-700 rounded-3 px-4 border">BATAL</a>
                    </div>
                </form>
            </div>
        </div>

        <!-- Section Hero Images Management (Separate Form) -->
        <div class="card card-premium mt-4">
            <div class="card-header bg-white py-4 px-4 border-0">
                <h5 class="mb-1 fw-800 text-dark"><i class="bi bi-image-fill me-2"></i> Manajemen Gambar Hero Slider
                </h5>
                <p class="text-muted small mb-0 fw-500">Tambah atau hapus gambar yang muncul di slider halaman depan.
                </p>
            </div>
            <div class="card-body p-4 pt-2">
                <div class="p-4 bg-light rounded-4 mb-4 border">
                    <form action="<?= base_url('admin/settings/add-hero') ?>" method="post"
                        enctype="multipart/form-data">
                        <div class="row g-3 align-items-end mb-4 border-bottom pb-4">
                            <div class="col-md-7">
                                <label class="form-label fw-700 small">Tambah Gambar Hero</label>
                                <input type="file" name="hero_image" class="form-control" accept="image/*" required>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label fw-700 small">Urutan</label>
                                <input type="number" name="sort_order" class="form-control" value="0">
                            </div>
                            <div class="col-md-2">
                                <button type="submit" class="btn btn-primary w-100 fw-700"><i
                                        class="bi bi-plus-lg me-1"></i> TAMBAH</button>
                            </div>
                        </div>
                    </form>

                    <div class="row g-3">
                        <?php if (!empty($hero_images)): ?>
                            <?php foreach ($hero_images as $img): ?>
                                <div class="col-md-4">
                                    <div class="card border rounded-3 overflow-hidden position-relative shadow-sm">
                                        <img src="<?= base_url($img['image_path']) ?>" class="card-img-top"
                                            style="height: 120px; object-fit: cover;">
                                        <div class="p-2 d-flex justify-content-between align-items-center bg-white">
                                            <small class="text-muted fw-600">Urutan: <?= $img['sort_order'] ?></small>
                                            <a href="<?= base_url('admin/settings/delete-hero/' . $img['id']) ?>"
                                                class="btn btn-sm btn-outline-danger border-0"
                                                onclick="return confirm('Hapus gambar ini?')">
                                                <i class="bi bi-trash3-fill"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <div class="col-12 text-center py-4">
                                <i class="bi bi-images text-muted fs-1 opacity-25"></i>
                                <p class="text-muted mt-2 fw-600">Belum ada gambar slider.</p>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
<?php $this->endSection() ?>