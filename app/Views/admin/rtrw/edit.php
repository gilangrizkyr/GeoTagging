<?php /** @var \CodeIgniter\View\View $this */?>
<?php $this->extend('layouts/admin')?>

<?php $this->section('title')?>
Edit Data RTRW
<?php $this->endSection()?>

<?php $this->section('content')?>
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white py-3">
                <h6 class="mb-0 fw-bold text-warning"><i class="bi bi-pencil me-2"></i> Edit Kawasan RTRW</h6>
            </div>
            <div class="card-body p-4">
                <?php if (session()->getFlashdata('errors')): ?>
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        <?php foreach (session()->getFlashdata('errors') as $error): ?>
                        <li>
                            <?= esc($error)?>
                        </li>
                        <?php
    endforeach; ?>
                    </ul>
                </div>
                <?php
endif; ?>

                <form action="<?= base_url('admin/rtrw/update/' . $area['id'])?>" method="post">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Nama Kawasan <span class="text-danger">*</span></label>
                        <input type="text" name="nama_kawasan" class="form-control"
                            value="<?= esc($area['nama_kawasan'])?>" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Fungsi Kawasan <span class="text-danger">*</span></label>
                        <textarea name="fungsi_kawasan" class="form-control" rows="3"
                            required><?= esc($area['fungsi_kawasan'])?></textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Warna Kawasan</label>
                        <input type="color" name="color" class="form-control form-control-color"
                            value="<?= esc($area['color'] ?? '#f59e0b')?>">
                    </div>

                    <div class="alert alert-info">
                        <i class="bi bi-info-circle me-2"></i>
                        <strong>Catatan:</strong> Geometry polygon tidak dapat diubah melalui form ini. Untuk mengubah
                        area kawasan, silakan hapus dan buat data baru.
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-warning text-white">
                            <i class="bi bi-save me-1"></i> Simpan Perubahan
                        </button>
                        <a href="<?= base_url('admin/rtrw')?>" class="btn btn-secondary">
                            <i class="bi bi-x-circle me-1"></i> Batal
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?php $this->endSection()?>