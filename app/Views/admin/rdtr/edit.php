<?php /** @var \CodeIgniter\View\View $this */ ?>
<?php $this->extend('layouts/admin') ?>

<?php $this->section('title') ?>
Edit Profil Zona:
<?= esc($zone['nama_zona']) ?>
<?php $this->endSection() ?>

<?php $this->section('styles') ?>
<style>
    .wizard-nav {
        display: flex;
        gap: 1rem;
        margin-bottom: 2.5rem;
        padding-bottom: 1rem;
        border-bottom: 1px solid #e2e8f0;
    }

    .wizard-step {
        flex: 1;
        padding: 1rem;
        border-radius: 1rem;
        background: #fff;
        border: 1px solid #e2e8f0;
        cursor: pointer;
        transition: all 0.3s;
        display: flex;
        align-items: center;
        gap: 1rem;
    }

    .wizard-step.active {
        border-color: var(--primary);
        background: var(--bg-body);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
    }

    .wizard-step.active .step-num {
        background: var(--primary);
        color: #fff;
    }

    .step-num {
        width: 40px;
        height: 40px;
        border-radius: 10px;
        background: #f1f5f9;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 800;
        color: #64748b;
        transition: all 0.3s;
    }

    .step-info .step-title {
        font-weight: 800;
        font-size: 0.85rem;
        margin-bottom: 0.15rem;
        color: #1e293b;
    }

    .step-info .step-desc {
        font-size: 0.7rem;
        color: #64748b;
    }

    .range-control-card {
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 1rem;
        padding: 1.5rem;
        transition: all 0.3s;
    }

    .range-value-badge {
        font-family: 'Outfit', sans-serif;
        font-weight: 800;
        color: var(--primary);
        background: #fff;
        padding: 0.5rem 1rem;
        border-radius: 0.75rem;
        border: 1px solid #e2e8f0;
        font-size: 1.1rem;
    }

    .activity-row {
        transition: all 0.2s;
        border-left: 4px solid transparent;
    }

    .activity-row:hover {
        background: #f8fafc !important;
        border-left-color: var(--primary);
    }

    .status-pill {
        font-size: 0.65rem;
        font-weight: 800;
        padding: 4px 12px;
        border-radius: 100px;
        display: inline-block;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .status-I {
        background: #dcfce7;
        color: #166534;
    }

    .status-T {
        background: #fef9c3;
        color: #854d0e;
    }

    .status-B {
        background: #dbeafe;
        color: #1e40af;
    }

    .status-X {
        background: #fee2e2;
        color: #991b1b;
    }
</style>
<?php $this->endSection() ?>

<?php $this->section('content') ?>
<div class="row justify-content-center">
    <div class="col-xl-11">
        <?php if (session()->getFlashdata('success')): ?>
            <div class="alert alert-success border-0 shadow-sm rounded-4 p-3 mb-4">
                <div class="d-flex align-items-center gap-2">
                    <i class="bi bi-check-circle-fill fs-5"></i>
                    <div class="fw-700 small">
                        <?= session()->getFlashdata('success') ?>
                    </div>
                </div>
            </div>
            <?php
        endif; ?>

        <form action="<?= base_url('admin/rdtr/update/' . $zone['id']) ?>" method="post" id="rdtrEditForm">
            <!-- Wizard Navigation -->
            <div class="wizard-nav overflow-auto">
                <div class="wizard-step active" onclick="showTab('tab-info')" id="step-info">
                    <div class="step-num">01</div>
                    <div class="step-info">
                        <div class="step-title text-uppercase">Informasi Dasar</div>
                        <div class="step-desc">Profil & Legal Zona</div>
                    </div>
                </div>
                <div class="wizard-step" onclick="showTab('tab-itbx')" id="step-itbx">
                    <div class="step-num">02</div>
                    <div class="step-info">
                        <div class="step-title text-uppercase">ITBX & Intensitas</div>
                        <div class="step-desc">Parametrik Bangunan</div>
                    </div>
                </div>
                <div class="wizard-step" onclick="showTab('tab-activities')" id="step-activities">
                    <div class="step-num">03</div>
                    <div class="step-info">
                        <div class="step-title text-uppercase">Aturan Zonasi</div>
                        <div class="step-desc">Kegiatan Kelompok</div>
                    </div>
                </div>
            </div>

            <div class="card card-premium overflow-hidden">
                <div class="card-body p-4 p-lg-5">
                    <!-- Tab 1: Info -->
                    <div class="tab-content-wizard" id="tab-info">
                        <div class="row g-4">
                            <div class="col-md-6">
                                <label class="form-label fw-700 small text-uppercase text-muted">Kode Zona <span
                                        class="text-danger">*</span></label>
                                <input type="text" name="nama_zona" class="form-control form-control-lg fs-6 fw-600"
                                    value="<?= esc($zone['nama_zona']) ?>" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-700 small text-uppercase text-muted">Sub Zona</label>
                                <input type="text" name="sub_zona" class="form-control form-control-lg fs-6 fw-600"
                                    value="<?= esc($zone['sub_zona'] ?? '') ?>">
                            </div>
                            <div class="col-12">
                                <label class="form-label fw-700 small text-uppercase text-muted">Deskripsi Peruntukan
                                    <span class="text-danger">*</span></label>
                                <textarea name="peruntukan" class="form-control fw-600" rows="3"
                                    required><?= esc($zone['peruntukan']) ?></textarea>
                            </div>
                            <div class="col-12">
                                <label class="form-label fw-700 small text-uppercase text-muted">Arahan
                                    Pemanfaatan</label>
                                <textarea name="arahan_pemanfaatan" class="form-control fw-600"
                                    rows="3"><?= esc($zone['arahan_pemanfaatan'] ?? '') ?></textarea>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-700 small text-uppercase text-muted">Warna Map
                                    Legend</label>
                                <div class="p-2 border rounded-3 d-flex align-items-center gap-3 bg-light">
                                    <input type="color" name="color" class="form-control form-control-color border-0"
                                        value="<?= esc($zone['color'] ?? '#3b82f6') ?>">
                                    <span class="small fw-800 text-muted">Pick Identity Color</span>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <label class="form-label fw-700 small text-uppercase text-muted">Rujukan
                                    Regulasi</label>
                                <input type="text" name="regulation_text" class="form-control fw-600"
                                    value="<?= esc($zone['regulation_text'] ?? '') ?>">
                            </div>

                            <!-- KBLI Allowed Multi-select -->
                            <div class="col-12 mt-2">
                                <label class="form-label fw-700 small d-flex align-items-center gap-2">
                                    <i class="bi bi-grid-3x3-gap-fill text-primary"></i>
                                    Kegiatan KBLI yang Diizinkan
                                    <span class="badge bg-primary-subtle text-primary fw-700"
                                        style="font-size:0.65rem;">Standar 2025</span>
                                    <span class="text-muted fw-500 small">(kosongkan = semua kegiatan boleh)</span>
                                </label>
                                <div id="kbli-tags-edit"
                                    class="d-flex flex-wrap gap-2 p-3 border rounded-3 bg-light mb-2"
                                    style="min-height:52px;">
                                    <span class="text-muted small fw-500 fst-italic" id="kbli-empty-hint-edit">Belum ada
                                        kode KBLI dipilih</span>
                                </div>
                                <input type="hidden" name="kbli_allowed" id="kbli-hidden-edit"
                                    value="<?= esc($zone['kbli_allowed'] ?? '') ?>">
                                <div class="input-group">
                                    <span class="input-group-text bg-white"><i
                                            class="bi bi-search text-muted"></i></span>
                                    <input type="text" id="kbli-search-edit" class="form-control fw-600"
                                        placeholder="Cari kode atau nama kegiatan (cth: apotek, 86201)...">
                                    <button type="button" class="btn btn-outline-secondary" id="kbli-clear-edit">
                                        <i class="bi bi-x-circle"></i>
                                    </button>
                                </div>
                                <div id="kbli-results-edit" class="border rounded-3 mt-1 bg-white shadow-sm d-none"
                                    style="max-height:220px;overflow-y:auto;position:relative;z-index:10;"></div>
                                <div class="mt-1 small text-muted fw-500">
                                    <i class="bi bi-info-circle me-1"></i>
                                    Hanya kegiatan yang dipilih yang akan divalidasi saat analisis zonasi.
                                </div>
                            </div>

                            <!-- Section: Data Provenance -->
                            <div class="col-12 mt-4 pt-4 border-top">
                                <div class="form-section-title mb-3" style="font-size: 0.9rem;">
                                    <i class="bi bi-shield-check text-primary"></i> Sumber & Legalitas Data
                                </div>
                                <div class="row g-3 p-3 bg-light rounded-4 border">
                                    <div class="col-md-6">
                                        <label class="form-label fw-700 small">Sumber Instansi Data <span
                                                class="text-danger">*</span></label>
                                        <input type="text" name="sumber_data" class="form-control fw-600"
                                            value="<?= esc($zone['sumber_data'] ?? '') ?>"
                                            placeholder="Contoh: Dinas PUPR / Bappeda" required>
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label fw-700 small">Tanggal Berlaku</label>
                                        <input type="date" name="tanggal_berlaku" class="form-control fw-600"
                                            value="<?= esc($zone['tanggal_berlaku'] ?? '') ?>">
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label fw-700 small">Versi Data</label>
                                        <input type="text" name="versi_data" class="form-control fw-600"
                                            value="<?= esc($zone['versi_data'] ?? '') ?>" placeholder="v1.0">
                                    </div>
                                    <div class="col-12 mt-2">
                                        <label class="form-label fw-700 small">Keterangan Sumber / Dasar Hukum</label>
                                        <textarea name="keterangan_sumber" class="form-control fw-500 small" rows="2"
                                            placeholder="Keterangan tambahan mengenai asal usul data..."><?= esc($zone['keterangan_sumber'] ?? '') ?></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="mt-5 d-flex justify-content-end">
                            <button type="button" class="btn btn-primary px-5 py-2 fw-700 rounded-3 shadow-sm"
                                onclick="showTab('tab-itbx')">
                                DATA INTENSITAS <i class="bi bi-arrow-right ms-2"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Tab 2: ITBX -->
                    <div class="tab-content-wizard d-none" id="tab-itbx">
                        <div class="row g-4">
                            <div class="col-md-6">
                                <div class="range-control-card">
                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                        <label class="fw-800 small text-muted text-uppercase">KDB (%) <i
                                                class="bi bi-info-circle ms-1" data-bs-toggle="tooltip"
                                                title="Koefisien Dasar Bangunan: Batas maksimal luas lantai dasar."></i></label>
                                        <span class="range-value-badge" id="kdb-val">
                                            <?= esc($zone['kdb'] ?? 0) ?>%
                                        </span>
                                    </div>
                                    <input type="range" name="kdb" class="form-range" min="0" max="100" step="5"
                                        value="<?= esc($zone['kdb'] ?? 0) ?>" id="kdb-in">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="range-control-card">
                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                        <label class="fw-800 small text-muted text-uppercase">KLB (Ratio) <i
                                                class="bi bi-info-circle ms-1" data-bs-toggle="tooltip"
                                                title="Koefisien Lantai Bangunan: Batas maksimal total luas seluruh lantai."></i></label>
                                        <span class="range-value-badge" id="klb-val">
                                            <?= esc($zone['klb'] ?? 0) ?>
                                        </span>
                                    </div>
                                    <input type="range" name="klb" class="form-range" min="0" max="10" step="0.5"
                                        value="<?= esc($zone['klb'] ?? 0) ?>" id="klb-in">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="range-control-card">
                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                        <label class="fw-800 small text-muted text-uppercase">KDH (%) <i
                                                class="bi bi-info-circle ms-1" data-bs-toggle="tooltip"
                                                title="Koefisien Dasar Hijau: Minimal luas area terbuka untuk resapan air."></i></label>
                                        <span class="range-value-badge" id="kdh-val">
                                            <?= esc($zone['kdh'] ?? 0) ?>%
                                        </span>
                                    </div>
                                    <input type="range" name="kdh" class="form-range" min="0" max="100" step="5"
                                        value="<?= esc($zone['kdh'] ?? 0) ?>" id="kdh-in">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="range-control-card">
                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                        <label class="fw-800 small text-muted text-uppercase">KTB (%) <i
                                                class="bi bi-info-circle ms-1" data-bs-toggle="tooltip"
                                                title="Koefisien Tapak Basement: Batas maksimal luas lantai bawah tanah."></i></label>
                                        <span class="range-value-badge" id="ktb-val">
                                            <?= esc($zone['ktb'] ?? 0) ?>%
                                        </span>
                                    </div>
                                    <input type="range" name="ktb" class="form-range" min="0" max="100" step="5"
                                        value="<?= esc($zone['ktb'] ?? 0) ?>" id="ktb-in">
                                </div>
                            </div>

                            <div class="col-md-4">
                                <label class="form-label fw-800 small text-muted">KETINGGIAN (M) <i
                                        class="bi bi-info-circle ms-1" data-bs-toggle="tooltip"
                                        title="Batas maksimal tinggi bangunan dari permukaan tanah."></i></label>
                                <input type="number" name="ketinggian_max" class="form-control"
                                    value="<?= esc($zone['ketinggian_max'] ?? '') ?>">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-800 small text-muted">GSB (M) <i
                                        class="bi bi-info-circle ms-1" data-bs-toggle="tooltip"
                                        title="Garis Sempadan Bangunan: Batas minimal bangunan dari tepi jalan."></i></label>
                                <input type="number" name="gsb" class="form-control"
                                    value="<?= esc($zone['gsb'] ?? '') ?>">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-800 small text-muted">GSL (M) <i
                                        class="bi bi-info-circle ms-1" data-bs-toggle="tooltip"
                                        title="Garis Sempadan Lahan: Batas minimal pekarangan."></i></label>
                                <input type="number" name="gsl" class="form-control"
                                    value="<?= esc($zone['gsl'] ?? '') ?>">
                            </div>
                        </div>

                        <div class="mt-5 d-flex justify-content-between">
                            <button type="button" class="btn btn-light px-4 py-2 fw-700 rounded-3 border"
                                onclick="showTab('tab-info')">
                                <i class="bi bi-arrow-left me-2"></i> KEMBALI
                            </button>
                            <button type="button" class="btn btn-primary px-5 py-2 fw-700 rounded-3 shadow-sm"
                                onclick="showTab('tab-activities')">
                                ATURAN KEGIATAN <i class="bi bi-arrow-right ms-2"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Tab 3: Activities -->
                    <div class="tab-content-wizard d-none" id="tab-activities">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <div>
                                <h6 class="fw-800 text-dark mb-1">Manajemen Matriks ITBX</h6>
                                <p class="small text-muted mb-0">Atur perizinan kelompok kegiatan untuk zona ini.</p>
                            </div>
                            <button type="button" class="btn btn-primary btn-sm px-3 rounded-3" data-bs-toggle="modal"
                                data-bs-target="#addActivityModal">
                                <i class="bi bi-plus-lg me-1"></i> TAMBAH ATURAN
                            </button>
                        </div>

                        <div class="table-responsive rounded-4 border">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="bg-light">
                                    <tr>
                                        <th class="ps-4 small fw-800 text-muted">KELOMPOK KEGIATAN</th>
                                        <th class="small fw-800 text-muted">STATUS</th>
                                        <th class="small fw-800 text-muted">SYARAT / KETERANGAN</th>
                                        <th class="text-end pe-4 small fw-800 text-muted" style="width: 100px;">OPSI
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (empty($activities)): ?>
                                        <tr>
                                            <td colspan="4" class="text-center py-5 text-muted small fw-600">Belum ada
                                                aturan kegiatan yang didefinisikan.</td>
                                        </tr>
                                        <?php
                                    else: ?>
                                        <?php foreach ($activities as $act): ?>
                                            <tr class="activity-row">
                                                <td class="ps-4">
                                                    <div class="fw-800 text-dark">
                                                        <?= esc($act['nama_kegiatan']) ?>
                                                    </div>
                                                    <div class="small text-muted fw-600">
                                                        <?= esc($act['kategori_kegiatan']) ?>
                                                    </div>
                                                </td>
                                                <td>
                                                    <span class="status-pill status-<?= $act['status'] ?>">
                                                        <?= $act['status'] == 'I' ? 'Diizinkan' : ($act['status'] == 'T' ? 'Terbatas' : ($act['status'] == 'B' ? 'Bersyarat' : 'Dilarang')) ?>
                                                    </span>
                                                </td>
                                                <td class="small fw-600 text-muted">
                                                    <?= esc($act['syarat'] ?? '-') ?>
                                                </td>
                                                <td class="text-end pe-4">
                                                    <button type="button" class="btn btn-link text-danger delete-activity p-0"
                                                        data-id="<?= $act['id'] ?>">
                                                        <i class="bi bi-trash-fill"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                            <?php
                                        endforeach; ?>
                                        <?php
                                    endif; ?>
                                </tbody>
                            </table>
                        </div>

                        <div class="mt-5 d-flex justify-content-between">
                            <button type="button" class="btn btn-light px-4 py-2 fw-700 rounded-3 border"
                                onclick="showTab('tab-itbx')">
                                <i class="bi bi-arrow-left me-2"></i> KEMBALI
                            </button>
                            <div class="d-flex gap-2">
                                <a href="<?= base_url('admin/rdtr') ?>"
                                    class="btn btn-light px-4 py-2 fw-700 rounded-3 text-muted">CANCEL</a>
                                <button type="submit" class="btn btn-primary px-5 py-2 fw-700 rounded-3 shadow">
                                    <i class="bi bi-cloud-check-fill me-2"></i> UPDATE SEMUA DATA
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Modal Activity -->
<div class="modal fade" id="addActivityModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">
            <div class="modal-header border-0 p-4 bg-primary text-white">
                <h5 class="modal-title fw-800"><i class="bi bi-plus-square-fill me-2"></i> Tambah Aturan Baru</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form id="addActivityForm">
                <?= csrf_field() ?>
                <input type="hidden" name="rdtr_zone_id" value="<?= $zone['id'] ?>">

                <div class="modal-body p-4">
                    <div class="mb-4">
                        <label class="form-label small fw-800 text-muted text-uppercase">Gunakan Template</label>
                        <select class="form-select fw-600" id="templateSelect">
                            <option value="">-- Pilih Preset --</option>
                            <?php foreach ($templates as $tpl): ?>
                                <option value="<?= esc($tpl['nama_kegiatan']) ?>"
                                    data-kategori="<?= esc($tpl['kategori']) ?>">
                                    <?= esc($tpl['nama_kegiatan']) ?>
                                </option>
                                <?php
                            endforeach; ?>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-800 text-muted text-uppercase">Nama Kegiatan <span
                                class="text-danger">*</span></label>
                        <input type="text" name="nama_kegiatan" id="input_nama_kegiatan" class="form-control fw-600"
                            required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-800 text-muted text-uppercase">Kategori</label>
                        <input type="text" name="kategori_kegiatan" id="input_kategori" class="form-control fw-600">
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-800 text-muted text-uppercase">Status Perizinan <span
                                class="text-danger">*</span></label>
                        <select name="status" class="form-select fw-700" required>
                            <option value="I">DIIZINKAN (I)</option>
                            <option value="T">TERBATAS (T)</option>
                            <option value="B">BERSYARAT (B)</option>
                            <option value="X">DILARANG (X)</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-800 text-muted text-uppercase">Syarat / Keterangan
                            Khusus</label>
                        <textarea name="syarat" class="form-control fw-600" rows="3"></textarea>
                    </div>
                </div>
                <div class="modal-footer border-0 p-4 pt-0">
                    <button type="button" class="btn btn-light fw-700 px-4" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary fw-800 px-5" id="btnSubmitActivity">Simpan Ke
                        Zona</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php $this->endSection() ?>

<?php $this->section('scripts') ?>
<script>
    function showTab(tabId) {
        document.querySelectorAll('.tab-content-wizard').forEach(t => t.classList.add('d-none'));
        document.getElementById(tabId).classList.remove('d-none');
        document.querySelectorAll('.wizard-step').forEach(s => s.classList.remove('active'));
        document.getElementById(tabId.replace('tab-', 'step-')).classList.add('active');
        window.scrollTo({ top: 0, behavior: 'smooth' });
    }

    // Sliders
    const sliders = [
        { in: 'kdb-in', val: 'kdb-val', suffix: '%' },
        { in: 'klb-in', val: 'klb-val', suffix: '' },
        { in: 'kdh-in', val: 'kdh-val', suffix: '%' },
        { in: 'ktb-in', val: 'ktb-val', suffix: '%' }
    ];

    sliders.forEach(s => {
        const input = document.getElementById(s.in);
        const display = document.getElementById(s.val);
        input.addEventListener('input', () => {
            let val = input.value;
            if (s.in === 'klb-in') val = parseFloat(val).toFixed(1);
            display.textContent = val + s.suffix;
        });
    });

    document.getElementById('templateSelect').addEventListener('change', function () {
        if (this.value) {
            document.getElementById('input_nama_kegiatan').value = this.value;
            document.getElementById('input_kategori').value = this.options[this.selectedIndex].getAttribute('data-kategori');
        }
    });

    document.getElementById('addActivityForm').addEventListener('submit', function (e) {
        e.preventDefault();
        const btn = document.getElementById('btnSubmitActivity');
        btn.disabled = true;
        btn.innerHTML = 'Saving...';

        fetch('<?= base_url('admin/rdtr/add-activity') ?>', {
            method: 'POST', body: new FormData(this),
            headers: { 'X-Requested-With': 'XMLHttpRequest' }
        })
            .then(r => r.json())
            .then(d => { if (d.status) location.reload(); else alert(d.message); })
            .catch(() => { alert('System Error'); btn.disabled = false; });
    });

    document.querySelectorAll('.delete-activity').forEach(btn => {
        btn.addEventListener('click', function () {
            if (!confirm('Hapus aturan ini?')) return;
            fetch('<?= base_url('admin/rdtr/delete-activity') ?>/' + this.dataset.id, {
                method: 'POST', headers: { 'X-Requested-With': 'XMLHttpRequest' }
            })
                .then(r => r.json())
                .then(d => { if (d.status) this.closest('tr').remove(); });
        });
    });
</script>
<?php $this->endSection() ?>

<?php $this->section('scripts') ?>
<script>
    // Range slider handlers
    const sliders = ['kdb', 'klb', 'kdh', 'ktb'];
    sliders.forEach(s => {
        const el = document.getElementById(s + '-slider');
        if (el) {
            el.addEventListener('input', function () {
                const valEl = document.getElementById(s + '-value');
                valEl.textContent = this.value + (s !== 'klb' ? '%' : '');
            });
        }
    });

    // Template selection
    document.getElementById('templateSelect').addEventListener('change', function () {
        if (this.value) {
            document.getElementById('input_nama_kegiatan').value = this.value;
            const selectedOption = this.options[this.selectedIndex];
            document.getElementById('input_kategori').value = selectedOption.getAttribute('data-kategori');
        }
    });

    // Add Activity via AJAX
    document.getElementById('addActivityForm').addEventListener('submit', function (e) {
        e.preventDefault();
        const formData = new FormData(this);
        const btn = document.getElementById('btnSubmitActivity');
        btn.disabled = true;
        btn.innerHTML = '<span class="spinner-border spinner-border-sm"></span> Menyimpan...';

        fetch('<?= base_url('admin/rdtr/add-activity') ?>', {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                '<?= csrf_header() ?>': '<?= csrf_hash() ?>'
            }
        })
            .then(response => response.json())
            .then(data => {
                if (data.status) {
                    location.reload(); // Quickest way to update the list
                } else {
                    alert('Gagal: ' + (data.message || 'Error tidak diketahui'));
                    btn.disabled = false;
                    btn.innerHTML = 'Tambahkan';
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Terjadi kesalahan sistem.');
                btn.disabled = false;
                btn.innerHTML = 'Tambahkan';
            });
    });

    // Delete Activity via AJAX
    document.querySelectorAll('.delete-activity').forEach(btn => {
        btn.addEventListener('click', function () {
            if (!confirm('Yakin ingin menghapus kegiatan ini dari zona?')) return;

            const id = this.getAttribute('data-id');
            fetch('<?= base_url('admin/rdtr/delete-activity') ?>/' + id, {
                method: 'POST',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    '<?= csrf_header() ?>': '<?= csrf_hash() ?>'
                }
            })
                .then(response => response.json())
                .then(data => {
                    if (data.status) {
                        this.closest('tr').remove();
                    } else {
                        alert('Gagal: ' + data.message);
                    }
                });
        });
    });
</script>
<?php $this->endSection() ?>