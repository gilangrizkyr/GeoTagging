<?php /** @var \CodeIgniter\View\View $this */?>
<?php $this->extend('layouts/admin')?>

<?php $this->section('title')?>
Data RTRW (Rencana Tata Ruang Wilayah)
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

<div class="card card-premium overflow-hidden">
    <div class="card-header bg-white py-4 px-4 d-flex justify-content-between align-items-center border-0">
        <div>
            <h5 class="mb-1 fw-800 text-dark">Daftar Kawasan Wilayah</h5>
            <p class="text-muted small mb-0 fw-500">Manajemen area dan fungsi kawasan perencanaan wilayah.</p>
        </div>
        <div>
            <a href="<?= base_url('admin/rtrw/create')?>"
                class="btn btn-warning text-white fw-700 rounded-3 px-3 shadow-sm">
                <i class="bi bi-plus-lg me-2"></i> TAMBAH KAWASAN
            </a>
        </div>
    </div>
    <div class="px-4 pb-4">
        <div class="table-responsive rounded-4 border overflow-hidden">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light border-bottom">
                    <tr>
                        <th class="ps-4 py-3 fw-800 text-muted small text-uppercase" style="letter-spacing: 0.5px;">Nama
                            Kawasan</th>
                        <th class="py-3 fw-800 text-muted small text-uppercase" style="letter-spacing: 0.5px;">Fungsi &
                            Peruntukan</th>
                        <th class="text-end pe-4 py-3 fw-800 text-muted small text-uppercase"
                            style="letter-spacing: 0.5px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($areas)): ?>
                    <?php foreach ($areas as $area): ?>
                    <tr>
                        <td class="ps-4 py-3">
                            <div class="d-flex align-items-center">
                                <div class="rounded-pill p-1 me-3 shadow-sm"
                                    style="background-color: <?= $area['color'] ?? '#ccc'?>; width: 12px; height: 12px;">
                                </div>
                                <div class="fw-700 text-dark">
                                    <?= esc($area['nama_kawasan'])?>
                                </div>
                            </div>
                        </td>
                        <td class="py-3">
                            <div class="fw-600 text-secondary">
                                <?= esc($area['fungsi_kawasan'])?>
                            </div>
                        </td>
                        <td class="text-end pe-4 py-3">
                            <div class="btn-group shadow-sm rounded-3 overflow-hidden border">
                                <a href="<?= base_url('admin/rtrw/edit/' . $area['id'])?>"
                                    class="btn btn-white btn-sm px-3 hover-warning border-end" title="Edit">
                                    <i class="bi bi-pencil-square text-warning py-1 d-inline-block"></i>
                                </a>
                                <a href="<?= base_url('admin/rtrw/delete/' . $area['id'])?>"
                                    class="btn btn-white btn-sm px-3 hover-danger" title="Hapus"
                                    onclick="return confirm('Yakin ingin menghapus kawasan ini?');">
                                    <i class="bi bi-trash3 text-danger py-1 d-inline-block"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                    <?php
    endforeach; ?>
                    <?php
else: ?>
                    <tr>
                        <td colspan="3" class="text-center py-5">
                            <div class="py-4">
                                <i class="bi bi-database-slash fs-1 text-muted opacity-25 d-block mb-3"></i>
                                <h6 class="fw-700 text-muted">Belum ada data kawasan RTRW.</h6>
                                <p class="small text-muted mb-0">Silakan tambahkan data baru melalui tombol di atas.</p>
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