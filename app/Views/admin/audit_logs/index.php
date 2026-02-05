<?php /** @var \CodeIgniter\View\View $this */?>
<?php $this->extend('layouts/admin')?>

<?php $this->section('title')?>
Audit Activity Logs
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

<!-- Analytics Summary -->
<div class="row g-4 mb-4">
    <div class="col-md-4">
        <div class="card card-premium p-3 border-start border-4 border-primary">
            <div class="card-body py-2">
                <h6 class="text-muted small fw-800 text-uppercase mb-2" style="letter-spacing: 1px;">Spatial Queries
                </h6>
                <h3 class="fw-800 mb-0">
                    <?= count($logs)?> <span class="fs-6 fw-600 text-muted ms-1">Record Aktif</span>
                </h3>
            </div>
        </div>
    </div>
</div>

<div class="card card-premium overflow-hidden">
    <div class="card-header bg-white py-4 px-4 d-flex justify-content-between align-items-center border-0">
        <div>
            <h5 class="mb-1 fw-800 text-dark">Riwayat Intelijen Spasial</h5>
            <p class="text-muted small mb-0 fw-500">Log aktivitas penelusuran koordinat dan validasi tata ruang.</p>
        </div>
        <?php if (session()->get('role') == 'admin' && !empty($logs)): ?>
        <a href="<?= base_url('admin/audit-logs/clear')?>"
            class="btn btn-light fw-700 rounded-3 px-3 border border-danger border-opacity-10 text-danger"
            onclick="return confirm('Yakin ingin menghapus seluruh log aktivitas? Operasi ini tidak dapat dibatalkan.');">
            <i class="bi bi-shield-slash me-2"></i> KOSONGKAN LOG
        </a>
        <?php
endif; ?>
    </div>
    <div class="px-4 pb-4">
        <div class="table-responsive rounded-4 border overflow-hidden">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light border-bottom">
                    <tr>
                        <th class="ps-4 py-3 fw-800 text-muted small text-uppercase" style="letter-spacing: 0.5px;">
                            Waktu & Personel</th>
                        <th class="py-3 fw-800 text-muted small text-uppercase" style="letter-spacing: 0.5px;">Parameter
                            Koordinat</th>
                        <th class="py-3 fw-800 text-muted small text-uppercase" style="letter-spacing: 0.5px;">Hasil
                            Analisis Layer</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($logs)): ?>
                    <?php foreach ($logs as $log): ?>
                    <?php $result = json_decode($log['result_summary'], true); ?>
                    <tr>
                        <td class="ps-4 py-3">
                            <div class="d-flex align-items-center">
                                <div class="p-2 rounded-3 bg-secondary bg-opacity-10 me-3 text-secondary">
                                    <i class="bi bi-clock-fill"></i>
                                </div>
                                <div>
                                    <div class="fw-800 text-dark small">
                                        <?= date('d M Y, H:i', strtotime($log['search_time']))?>
                                    </div>
                                    <div class="small fw-600">
                                        <?php if ($log['user_id']): ?>
                                        <span class="text-primary"><i class="bi bi-person-fill"></i> System User #
                                            <?= $log['user_id']?>
                                        </span>
                                        <?php
        else: ?>
                                        <span class="text-muted"><i class="bi bi-globe"></i> Public Access</span>
                                        <?php
        endif; ?>
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td class="py-3">
                            <div class="p-2 bg-light rounded-3 border d-inline-block">
                                <code
                                    class="fw-800 text-primary small"><?= number_format($log['search_lat'], 6)?>, <?= number_format($log['search_lng'], 6)?></code>
                            </div>
                        </td>
                        <td class="py-3">
                            <div class="d-flex gap-2">
                                <?php if ($result['rdtr_found']): ?>
                                <span
                                    class="badge border bg-success bg-opacity-10 text-success px-3 py-2 rounded-pill fw-800"
                                    style="font-size: 0.65rem;">
                                    <i class="bi bi-layers-fill me-1"></i> RDTR:
                                    <?= esc($result['rdtr_zona'] ?? 'DETECTED')?>
                                </span>
                                <?php
        else: ?>
                                <span class="badge border bg-light text-muted px-3 py-2 rounded-pill fw-800"
                                    style="font-size: 0.65rem;">
                                    <i class="bi bi-dash-circle me-1"></i> NO RDTR
                                </span>
                                <?php
        endif; ?>

                                <?php if ($result['rtrw_found']): ?>
                                <span
                                    class="badge border bg-warning bg-opacity-10 text-dark px-3 py-2 rounded-pill fw-800"
                                    style="font-size: 0.65rem;">
                                    <i class="bi bi-geo-fill me-1"></i> RTRW FOUND
                                </span>
                                <?php
        else: ?>
                                <span class="badge border bg-light text-muted px-3 py-2 rounded-pill fw-800"
                                    style="font-size: 0.65rem;">
                                    <i class="bi bi-dash-circle me-1"></i> NO RTRW
                                </span>
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
                        <td colspan="3" class="text-center py-5">
                            <div class="py-4">
                                <i class="bi bi-shield-slash fs-1 text-muted opacity-25 d-block mb-3"></i>
                                <h6 class="fw-700 text-muted">Belum ada riwayat aktivitas.</h6>
                                <p class="small text-muted mb-0">Seluruh penelusuran koordinat oleh pengguna akan
                                    tercatat di sini.</p>
                            </div>
                        </td>
                    </tr>
                    <?php
endif; ?>
                </tbody>
            </table>
        </div>

        <?php if (!empty($logs)): ?>
        <div class="mt-4 d-flex justify-content-center">
            <?= $pager->links()?>
        </div>
        <?php
endif; ?>
    </div>
</div>
<?php $this->endSection()?>