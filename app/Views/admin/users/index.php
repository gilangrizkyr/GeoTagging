<?php /** @var \CodeIgniter\View\View $this */?>
<?php $this->extend('layouts/admin')?>

<?php $this->section('title')?>
Staff Management
<?php $this->endSection()?>

<?php $this->section('content')?>

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

<!-- Stats Summary -->
<div class="row g-4 mb-4">
    <div class="col-md-4">
        <div class="card card-premium p-3 border-start border-4 border-info">
            <div class="card-body py-2">
                <h6 class="text-muted small fw-800 text-uppercase mb-2" style="letter-spacing: 1px;">Total Personel</h6>
                <h3 class="fw-800 mb-0">
                    <?= count($users)?> <span class="fs-6 fw-600 text-muted ms-1">Staff Aktif</span>
                </h3>
            </div>
        </div>
    </div>
</div>

<div class="card card-premium overflow-hidden">
    <div class="card-header bg-white py-4 px-4 d-flex justify-content-between align-items-center border-0">
        <div>
            <h5 class="mb-1 fw-800 text-dark">Daftar Pengguna Sistem</h5>
            <p class="text-muted small mb-0 fw-500">Kelola hak akses administrator dan operator lapangan.</p>
        </div>
        <div>
            <a href="<?= base_url('admin/users/create')?>" class="btn btn-primary fw-700 rounded-3 px-4 shadow-sm">
                <i class="bi bi-person-plus-fill me-2"></i> TAMBAH USER
            </a>
        </div>
    </div>
    <div class="px-4 pb-4">
        <div class="table-responsive rounded-4 border overflow-hidden">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light border-bottom">
                    <tr>
                        <th class="ps-4 py-3 fw-800 text-muted small text-uppercase"
                            style="letter-spacing: 0.5px; width: 80px;">ID</th>
                        <th class="py-3 fw-800 text-muted small text-uppercase" style="letter-spacing: 0.5px;">Informasi
                            Akun</th>
                        <th class="py-3 fw-800 text-muted small text-uppercase" style="letter-spacing: 0.5px;">Level
                            Akses</th>
                        <th class="py-3 fw-800 text-muted small text-uppercase" style="letter-spacing: 0.5px;">Status
                        </th>
                        <th class="text-end pe-4 py-3 fw-800 text-muted small text-uppercase"
                            style="letter-spacing: 0.5px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($users)): ?>
                    <?php foreach ($users as $user): ?>
                    <tr>
                        <td class="ps-4 py-3">
                            <span class="fw-800 text-muted opacity-50">#
                                <?= $user['id']?>
                            </span>
                        </td>
                        <td class="py-3">
                            <div class="d-flex align-items-center">
                                <img src="https://ui-avatars.com/api/?name=<?= urlencode($user['username'])?>&background=random&size=40"
                                    class="rounded-circle me-3 border border-2 border-white shadow-sm" alt="Avatar">
                                <div>
                                    <div class="fw-800 text-dark">
                                        <?= esc($user['username'])?>
                                    </div>
                                    <div class="small text-muted opacity-75 fw-500 text-truncate"
                                        style="max-width: 150px;">Member since
                                        <?= date('d M Y')?>
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td class="py-3">
                            <?php if ($user['role'] == 'admin'): ?>
                            <span class="badge rounded-pill px-3 py-2 bg-danger bg-opacity-10 text-danger fw-800"
                                style="font-size: 0.65rem;">ADMINISTRATOR</span>
                            <?php
        else: ?>
                            <span class="badge rounded-pill px-3 py-2 bg-info bg-opacity-10 text-info fw-800"
                                style="font-size: 0.65rem;">OPERATOR PANEL</span>
                            <?php
        endif; ?>
                        </td>
                        <td class="py-3">
                            <div class="d-flex align-items-center gap-2">
                                <span class="p-1 rounded-circle bg-success shadow-sm"></span>
                                <span class="small fw-700 text-success">Active Connection</span>
                            </div>
                        </td>
                        <td class="text-end pe-4 py-3">
                            <div class="btn-group shadow-sm rounded-3 overflow-hidden border">
                                <a href="<?= base_url('admin/users/edit/' . $user['id'])?>"
                                    class="btn btn-white btn-sm px-3 hover-warning border-end" title="Edit Staff">
                                    <i class="bi bi-pencil-square text-warning py-1 d-inline-block"></i>
                                </a>
                                <?php if (session()->get('id') != $user['id']): ?>
                                <a href="<?= base_url('admin/users/delete/' . $user['id'])?>"
                                    class="btn btn-white btn-sm px-3 hover-danger" title="Terminate Access"
                                    onclick="return confirm('Yakin ingin memberhentikan akses user ini?');">
                                    <i class="bi bi-shield-x text-danger py-1 d-inline-block"></i>
                                </a>
                                <?php
        else: ?>
                                <button class="btn btn-white btn-sm px-3 disabled border-0 bg-light opacity-50"
                                    title="You cannot delete yourself">
                                    <i class="bi bi-lock-fill text-muted py-1 d-inline-block"></i>
                                </button>
                                <?php
        endif; ?>
                            </div>
                        </td>
                    </tr>
                    <?php
    endforeach; ?>
                    <?php
else: ?>
                    <tr>
                        <td colspan="5" class="text-center py-5">
                            <div class="py-4">
                                <i class="bi bi-people fs-1 text-muted opacity-25 d-block mb-3"></i>
                                <h6 class="fw-700 text-muted">Belum ada user terdaftar.</h6>
                                <p class="small text-muted mb-0">Silakan tambahkan personel baru melalui tombol di atas.
                                </p>
                            </div>
                        </td>
                    </tr>
                    <?php
endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<style>
    .btn-white {
        background-color: #fff;
        color: #475569;
        border: none;
    }

    .btn-white:hover {
        background-color: #f8fafc;
    }

    .hover-warning:hover i {
        color: #f59e0b !important;
    }

    .hover-danger:hover i {
        color: #dc2626 !important;
    }
</style>
<?php $this->endSection()?>