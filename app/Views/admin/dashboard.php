<?php /** @var \CodeIgniter\View\View $this */ ?>
<?php $this->extend('layouts/admin') ?>

<?php $this->section('title') ?>
Ringkasan Portal
<?php $this->endSection() ?>

<?php $this->section('content') ?>
<div class="row g-4">
    <!-- Welcome Section -->
    <div class="col-12">
        <div class="card border-0 rounded-4 overflow-hidden shadow-sm"
            style="background: linear-gradient(135deg, var(--primary), var(--primary-dark));">
            <div class="card-body p-4 p-lg-5 position-relative">
                <div class="row align-items-center position-relative" style="z-index: 2;">
                    <div class="col-lg-8">
                        <h2 class="text-white fw-800 mb-2">Selamat Datang Kembali,
                            <?= session()->get('username') ?>!
                        </h2>
                        <p class="text-white opacity-75 fw-500 mb-0 fs-5">Anda masuk sebagai <span
                                class="badge bg-white bg-opacity-25">
                                <?= ucfirst(session()->get('role')) ?>
                            </span>. Berikut adalah ringkasan sistem spasial hari ini.</p>
                    </div>
                    <div class="col-lg-4 text-end d-none d-lg-block">
                        <i class="bi bi-shield-check text-white opacity-25" style="font-size: 8rem;"></i>
                    </div>
                </div>
                <!-- Decorative Circle -->
                <div class="position-absolute bottom-0 end-0 p-5 opacity-10">
                    <div class="rounded-circle border border-5 border-white"
                        style="width: 300px; height: 300px; margin-right: -150px; margin-bottom: -150px;"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Stats Section -->
    <div class="col-md-6 col-xl-3">
        <div class="card card-premium h-100 p-2 border-0 shadow-sm rounded-4">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-start mb-4">
                    <div class="p-3 bg-primary bg-opacity-10 text-primary rounded-4">
                        <i class="bi bi-map-fill fs-3"></i>
                    </div>
                </div>
                <div>
                    <h6 class="text-muted fw-700 text-uppercase mb-1" style="font-size: 0.7rem; letter-spacing: 1px;">
                        Data Spasial</h6>
                    <h3 class="fw-800 mb-1 text-dark"><?= $count_rdtr ?> <span
                            class="fs-6 fw-600 opacity-50">Zona</span></h3>
                    <p class="text-muted small mb-0 fw-600">Rencana Detail Tata Ruang</p>
                </div>
                <div class="mt-4 pt-4 border-top">
                    <a href="<?= base_url('admin/rdtr') ?>" class="btn p-0 text-primary fw-800 small">
                        KELOLA DATA <i class="bi bi-arrow-right ms-2"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6 col-xl-3">
        <div class="card card-premium h-100 p-2 border-0 shadow-sm rounded-4">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-start mb-4">
                    <div class="p-3 bg-warning bg-opacity-10 text-warning rounded-4">
                        <i class="bi bi-layers-fill fs-3"></i>
                    </div>
                </div>
                <div>
                    <h6 class="text-muted fw-700 text-uppercase mb-1" style="font-size: 0.7rem; letter-spacing: 1px;">
                        Wilayah Kawasan</h6>
                    <h3 class="fw-800 mb-1 text-dark"><?= $count_rtrw ?> <span
                            class="fs-6 fw-600 opacity-50">Kawasan</span></h3>
                    <p class="text-muted small mb-0 fw-600">Rencana Tata Ruang Wilayah</p>
                </div>
                <div class="mt-4 pt-4 border-top">
                    <a href="<?= base_url('admin/rtrw') ?>" class="btn p-0 text-warning fw-800 small">
                        KELOLA DATA <i class="bi bi-arrow-right ms-2"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <?php if (session()->get('role') == 'admin'): ?>
        <div class="col-md-6 col-xl-3">
            <div class="card card-premium h-100 p-2 border-0 shadow-sm rounded-4">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start mb-4">
                        <div class="p-3 bg-info bg-opacity-10 text-info rounded-4">
                            <i class="bi bi-people-fill fs-3"></i>
                        </div>
                    </div>
                    <div>
                        <h6 class="text-muted fw-700 text-uppercase mb-1" style="font-size: 0.7rem; letter-spacing: 1px;">
                            Staf & Pengguna</h6>
                        <h3 class="fw-800 mb-1 text-dark"><?= $count_users ?> <span
                                class="fs-6 fw-600 opacity-50">Akun</span></h3>
                        <p class="text-muted small mb-0 fw-600">Manajemen Pengguna Sistem</p>
                    </div>
                    <div class="mt-4 pt-4 border-top">
                        <a href="<?= base_url('admin/users') ?>" class="btn p-0 text-info fw-800 small">
                            MANAJEMEN USER <i class="bi bi-arrow-right ms-2"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-xl-3">
            <div class="card card-premium h-100 p-2 border-0 shadow-sm rounded-4">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start mb-4">
                        <div class="p-3 bg-secondary bg-opacity-10 text-secondary rounded-4">
                            <i class="bi bi-gear-fill fs-3"></i>
                        </div>
                    </div>
                    <div>
                        <h6 class="text-muted fw-700 text-uppercase mb-1" style="font-size: 0.7rem; letter-spacing: 1px;">
                            Konfigurasi</h6>
                        <h3 class="fw-800 mb-1 text-dark">Sistem</h3>
                        <p class="text-muted small mb-0 fw-600">Pengaturan Dasar Aplikasi</p>
                    </div>
                    <div class="mt-4 pt-4 border-top">
                        <a href="<?= base_url('admin/settings') ?>" class="btn p-0 text-secondary fw-800 small">
                            PENGATURAN <i class="bi bi-arrow-right ms-2"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <?php
    endif; ?>
</div>

<!-- Usage Analytics Section -->
<div class="row g-4 mt-2">
    <div class="col-12">
        <h5 class="fw-800 text-dark mb-0 mt-2">Statistik Penggunaan Sistem</h5>
        <p class="text-muted small fw-500 mb-0">Pemantauan intensitas penelusuran tata ruang oleh publik & staf.</p>
    </div>

    <div class="col-md-6 col-xl-4 text-white card-premium">
        <div class="card border-0 rounded-4 shadow-sm h-100"
            style="background: linear-gradient(135deg, #6366f1, #4f46e5);">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div class="p-2 bg-white bg-opacity-20 rounded-3 text-white">
                        <i class="bi bi-graph-up-arrow fs-4"></i>
                    </div>
                </div>
                <h6 class="text-white opacity-75 fw-700 text-uppercase small" style="letter-spacing: 1px;">Total
                    Penelusuran</h6>
                <h2 class="fw-800 mb-0"><?= number_format($total_searches) ?> <span
                        class="fs-6 fw-600 opacity-50 text-white">Analisis</span></h2>
                <div class="mt-3 small fw-600 opacity-75">
                    <i class="bi bi-info-circle me-1"></i> Akumulasi sejak sistem diluncurkan
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6 col-xl-4 text-white card-premium">
        <div class="card border-0 rounded-4 shadow-sm h-100"
            style="background: linear-gradient(135deg, #10b981, #059669);">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div class="p-2 bg-white bg-opacity-20 rounded-3 text-white">
                        <i class="bi bi-lightning-charge-fill fs-4"></i>
                    </div>
                    <?php if ($today_searches > 0): ?>
                        <span class="badge bg-white text-success fw-800">AKTIF</span>
                    <?php endif; ?>
                </div>
                <h6 class="text-white opacity-75 fw-700 text-uppercase small" style="letter-spacing: 1px;">Aktivitas
                    Hari Ini</h6>
                <h2 class="fw-800 mb-0"><?= $today_searches ?> <span
                        class="fs-6 fw-600 opacity-50 text-white">Kueri</span></h2>
                <div class="mt-3 small fw-600 opacity-75">
                    <i class="bi bi-calendar-check me-1"></i> Data per tanggal <?= date('d M Y') ?>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .card-premium {
        animation: slideUp 0.5s ease backwards;
    }

    .card-premium:nth-child(2) {
        animation-delay: 0.1s;
    }

    .card-premium:nth-child(3) {
        animation-delay: 0.2s;
    }

    @keyframes slideUp {
        from {
            transform: translateY(20px);
            opacity: 0;
        }

        to {
            transform: translateY(0);
            opacity: 1;
        }
    }
</style>
<?php $this->endSection() ?>