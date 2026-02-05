<?php /** @var \CodeIgniter\View\View $this */?>
<?php $this->extend('layouts/admin')?>

<?php $this->section('title')?>
Dashboard Overview
<?php $this->endSection()?>

<?php $this->section('content')?>
<div class="row g-4">
    <!-- Welcome Section -->
    <div class="col-12">
        <div class="card border-0 rounded-4 overflow-hidden shadow-sm"
            style="background: linear-gradient(135deg, var(--primary), var(--primary-dark));">
            <div class="card-body p-4 p-lg-5 position-relative">
                <div class="row align-items-center position-relative" style="z-index: 2;">
                    <div class="col-lg-8">
                        <h2 class="text-white fw-800 mb-2">Selamat Datang Kembali,
                            <?= session()->get('username')?>!
                        </h2>
                        <p class="text-white opacity-75 fw-500 mb-0 fs-5">Anda masuk sebagai <span
                                class="badge bg-white bg-opacity-25">
                                <?= ucfirst(session()->get('role'))?>
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
        <div class="card card-premium h-100 p-2">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-start mb-4">
                    <div class="p-3 bg-primary bg-opacity-10 text-primary rounded-4">
                        <i class="bi bi-map-fill fs-3"></i>
                    </div>
                    <div class="dropdown">
                        <button class="btn btn-link link-secondary p-0" data-bs-toggle="dropdown"><i
                                class="bi bi-three-dots-vertical"></i></button>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="<?= base_url('admin/rdtr')?>">Lihat Detail</a></li>
                        </ul>
                    </div>
                </div>
                <div>
                    <h6 class="text-muted fw-700 text-uppercase mb-1" style="font-size: 0.7rem; letter-spacing: 1px;">
                        Data Spasial</h6>
                    <h3 class="fw-800 mb-1 text-dark">RDTR Zones</h3>
                    <p class="text-muted small mb-0">Rencana Detail Tata Ruang</p>
                </div>
                <div class="mt-4 pt-4 border-top">
                    <a href="<?= base_url('admin/rdtr')?>" class="btn p-0 text-primary fw-800 small">
                        KELOLA DATA <i class="bi bi-arrow-right ms-2"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6 col-xl-3">
        <div class="card card-premium h-100 p-2">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-start mb-4">
                    <div class="p-3 bg-warning bg-opacity-10 text-warning rounded-4">
                        <i class="bi bi-layers-fill fs-3"></i>
                    </div>
                    <div class="dropdown">
                        <button class="btn btn-link link-secondary p-0" data-bs-toggle="dropdown"><i
                                class="bi bi-three-dots-vertical"></i></button>
                    </div>
                </div>
                <div>
                    <h6 class="text-muted fw-700 text-uppercase mb-1" style="font-size: 0.7rem; letter-spacing: 1px;">
                        Wilayah Kawasan</h6>
                    <h3 class="fw-800 mb-1 text-dark">RTRW Areas</h3>
                    <p class="text-muted small mb-0">Rencana Tata Ruang Wilayah</p>
                </div>
                <div class="mt-4 pt-4 border-top">
                    <a href="<?= base_url('admin/rtrw')?>" class="btn p-0 text-warning fw-800 small">
                        KELOLA DATA <i class="bi bi-arrow-right ms-2"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <?php if (session()->get('role') == 'admin'): ?>
    <div class="col-md-6 col-xl-3">
        <div class="card card-premium h-100 p-2">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-start mb-4">
                    <div class="p-3 bg-info bg-opacity-10 text-info rounded-4">
                        <i class="bi bi-people-fill fs-3"></i>
                    </div>
                </div>
                <div>
                    <h6 class="text-muted fw-700 text-uppercase mb-1" style="font-size: 0.7rem; letter-spacing: 1px;">
                        Akses Keamanan</h6>
                    <h3 class="fw-800 mb-1 text-dark">User Staff</h3>
                    <p class="text-muted small mb-0">Manajemen Pengguna Sistem</p>
                </div>
                <div class="mt-4 pt-4 border-top">
                    <a href="<?= base_url('admin/users')?>" class="btn p-0 text-info fw-800 small">
                        MANAJEMEN USER <i class="bi bi-arrow-right ms-2"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6 col-xl-3">
        <div class="card card-premium h-100 p-2">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-start mb-4">
                    <div class="p-3 bg-secondary bg-opacity-10 text-secondary rounded-4">
                        <i class="bi bi-gear-fill fs-3"></i>
                    </div>
                </div>
                <div>
                    <h6 class="text-muted fw-700 text-uppercase mb-1" style="font-size: 0.7rem; letter-spacing: 1px;">
                        Konfigurasi</h6>
                    <h3 class="fw-800 mb-1 text-dark">System settings</h3>
                    <p class="text-muted small mb-0">Pengaturan Dasar Aplikasi</p>
                </div>
                <div class="mt-4 pt-4 border-top">
                    <a href="<?= base_url('admin/settings')?>" class="btn p-0 text-secondary fw-800 small">
                        PENGATURAN <i class="bi bi-arrow-right ms-2"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
    <?php
endif; ?>
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
<?php $this->endSection()?>
