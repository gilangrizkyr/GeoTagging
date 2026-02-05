<?php /** @var \CodeIgniter\View\View $this */?>
<?php $this->extend('layouts/admin')?>

<?php $this->section('title')?>
Konfigurasi Kawasan RTRW Baru
<?php $this->endSection()?>

<?php $this->section('content')?>
<div class="row justify-content-center">
    <div class="col-xl-8">

        <?php if (session()->getFlashdata('errors')): ?>
        <div class="alert alert-danger border-0 shadow-sm rounded-4 p-3 mb-4">
            <div class="fw-800 small text-uppercase mb-2"><i class="bi bi-exclamation-triangle-fill"></i> Terdapat
                Kesalahan Input:</div>
            <ul class="mb-0 small fw-600">
                <?php foreach (session()->getFlashdata('errors') as $error): ?>
                <li>
                    <?= $error?>
                </li>
                <?php
    endforeach ?>
            </ul>
        </div>
        <?php
endif; ?>

        <div class="card card-premium overflow-hidden">
            <div class="card-header bg-white py-4 px-4 border-0">
                <h5 class="mb-1 fw-800 text-dark">Registrasi Kawasan Wilayah</h5>
                <p class="text-muted small mb-0 fw-500">Definisikan fungsi strategis dan peruntukan kawasan perencanaan
                    makro.</p>
            </div>
            <div class="card-body p-4 p-lg-5 pt-2">
                <form action="<?= base_url('admin/rtrw/store')?>" method="post" enctype="multipart/form-data">

                    <div class="row g-4 mb-4">
                        <div class="col-md-7">
                            <label class="form-label fw-700 small mb-2 text-muted text-uppercase"
                                style="letter-spacing: 0.5px;">Identitas Kawasan <span
                                    class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0"><i
                                        class="bi bi-tag-fill text-muted"></i></span>
                                <input type="text" name="nama_kawasan"
                                    class="form-control form-control-lg fs-6 fw-600 border-start-0 ps-0"
                                    placeholder="Contoh: Kawasan Lindung" required>
                            </div>
                        </div>
                        <div class="col-md-5">
                            <label class="form-label fw-700 small mb-2 text-muted text-uppercase"
                                style="letter-spacing: 0.5px;">Simbol Warna <span class="text-danger">*</span></label>
                            <div class="p-2 border rounded-3 d-flex align-items-center gap-3">
                                <input type="color" name="color"
                                    class="form-control form-control-color border-0 shadow-sm" value="#ff8833"
                                    style="width: 50px; height: 40px;">
                                <span class="small fw-800 text-muted">Pick Legend Color</span>
                            </div>
                        </div>
                    </div>

                    <div class="mb-5">
                        <label class="form-label fw-700 small mb-2 text-muted text-uppercase"
                            style="letter-spacing: 0.5px;">Fungsi Utama Wilayah <span
                                class="text-danger">*</span></label>
                        <textarea name="fungsi_kawasan" class="form-control fw-600 p-3" rows="3"
                            placeholder="Deskripsikan fungsi dan tanggung jawab kawasan ini dalam tata kelola wilayah..."
                            required></textarea>
                    </div>

                    <div class="mb-5 bg-light p-4 rounded-4 border border-dashed border-2">
                        <div class="d-flex align-items-center gap-3 mb-4">
                            <div class="p-2 bg-white rounded-3 shadow-sm text-primary">
                                <i class="bi bi-map-fill fs-4"></i>
                            </div>
                            <div>
                                <h6 class="fw-800 mb-1 text-dark">Data Geopasial (Format GeoJSON)</h6>
                                <p class="small text-muted mb-0">Pastikan koordinat menggunakan sistem proyeksi WGS 84.
                                </p>
                            </div>
                        </div>
                        <div class="p-4 bg-white rounded-3 border">
                            <input type="file" name="geojson_file" class="form-control fw-600" accept=".json,.geojson"
                                required>
                            <p class="small text-muted mt-2 mb-0 fw-500"><i class="bi bi-info-circle me-1"></i> File
                                harus berupa Polygon atau MultiPolygon FeatureCollection.</p>
                        </div>
                    </div>

                    <div class="pt-4 border-top d-flex gap-2">
                        <button type="submit" class="btn btn-primary px-5 py-3 fw-800 rounded-3 shadow-lg flex-grow-1">
                            <i class="bi bi-shield-check me-2"></i> RESMIKAN DATA KAWASAN
                        </button>
                        <a href="<?= base_url('admin/rtrw')?>"
                            class="btn btn-light px-4 py-3 fw-700 rounded-3 border text-muted">CANCEL</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?php $this->endSection()?>