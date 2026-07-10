<?php /** @var \CodeIgniter\View\View $this */ ?>
<?php $this->extend('layouts/admin') ?>

<?php $this->section('title') ?>
Konfigurasi Zona RDTR Baru
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

    .form-section-title {
        font-size: 1.1rem;
        font-weight: 800;
        color: var(--primary);
        margin-bottom: 2rem;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .form-section-title i {
        opacity: 0.5;
    }

    .range-control-card {
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 1rem;
        padding: 1.5rem;
        transition: all 0.3s;
    }

    .range-control-card:hover {
        border-color: var(--primary);
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
</style>
<?php $this->endSection() ?>

<?php $this->section('content') ?>
<div class="row justify-content-center">
    <div class="col-xl-10">
        <?php if (session()->getFlashdata('errors')): ?>
            <div class="alert alert-danger border-0 shadow-sm rounded-4 p-3 mb-4">
                <div class="fw-800 small text-uppercase mb-2"><i class="bi bi-exclamation-triangle-fill"></i> Terdapat
                    Kesalahan Input:</div>
                <ul class="mb-0 small fw-600">
                    <?php foreach (session()->getFlashdata('errors') as $error): ?>
                        <li>
                            <?= $error ?>
                        </li>
                        <?php
                    endforeach ?>
                </ul>
            </div>
            <?php
        endif; ?>

        <form action="<?= base_url('admin/rdtr/store') ?>" method="post" enctype="multipart/form-data" id="rdtrForm">
            <!-- Wizard Navigation -->
            <div class="wizard-nav overflow-auto">
                <div class="wizard-step active" onclick="showTab('tab-info')" id="step-info">
                    <div class="step-num">01</div>
                    <div class="step-info">
                        <div class="step-title text-uppercase">Informasi Dasar</div>
                        <div class="step-desc">Identitas & Warna Zona</div>
                    </div>
                </div>
                <div class="wizard-step" onclick="showTab('tab-itbx')" id="step-itbx">
                    <div class="step-num">02</div>
                    <div class="step-info">
                        <div class="step-title text-uppercase">Parameter ITBX</div>
                        <div class="step-desc">Intensitas Bangunan</div>
                    </div>
                </div>
                <div class="wizard-step" onclick="showTab('tab-geometry')" id="step-geometry">
                    <div class="step-num">03</div>
                    <div class="step-info">
                        <div class="step-title text-uppercase">Data Spasial</div>
                        <div class="step-desc">Geometry & Lokasi</div>
                    </div>
                </div>
            </div>

            <div class="card card-premium overflow-hidden">
                <div class="card-body p-4 p-lg-5">
                    <!-- Tab 1: Informasi Dasar -->
                    <div class="tab-content-wizard" id="tab-info">
                        <div class="form-section-title"><i class="bi bi-info-circle-fill"></i> Identifikasi Zona RDTR
                        </div>
                        <div class="row g-4">
                            <div class="col-md-6">
                                <label class="form-label fw-700 small">Kode Nama Zona <span
                                        class="text-danger">*</span></label>
                                <input type="text" name="nama_zona" class="form-control form-control-lg fs-6 fw-600"
                                    placeholder="Contoh: KP-1" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-700 small">Label Sub Zona</label>
                                <input type="text" name="sub_zona" class="form-control form-control-lg fs-6 fw-600"
                                    placeholder="Opsional">
                            </div>
                            <div class="col-12">
                                <label class="form-label fw-700 small">Deskripsi Peruntukan Lahan <span
                                        class="text-danger">*</span></label>
                                <textarea name="peruntukan" class="form-control fw-600" rows="3"
                                    placeholder="Contoh: Zona Perkantoran Pemerintah Kota" required></textarea>
                            </div>
                            <div class="col-12">
                                <label class="form-label fw-700 small">Arahan Pemanfaatan Ruang</label>
                                <textarea name="arahan_pemanfaatan" class="form-control fw-600" rows="3"
                                    placeholder="Instruksi spesifik pemanfaatan lahan..."></textarea>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-700 small">Simbol Warna Peta</label>
                                <div class="p-2 border rounded-3 d-flex align-items-center gap-3">
                                    <input type="color" name="color"
                                        class="form-control form-control-color border-0 shadow-sm" value="#3b82f6"
                                        style="width: 50px; height: 40px;">
                                    <span class="small fw-800 text-muted">Pilih Warna Zona</span>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <label class="form-label fw-700 small">Referensi Teks Regulasi</label>
                                <input type="text" name="regulation_text" class="form-control fw-600"
                                    placeholder="Contoh: Perda No 01 Tahun 2024 Tentang RTRW">
                            </div>

                            <!-- KBLI Allowed Multi-select -->
                            <div class="col-12 mt-2" id="kbli-selector-section">
                                <label class="form-label fw-700 small d-flex align-items-center gap-2">
                                    <i class="bi bi-grid-3x3-gap-fill text-primary"></i>
                                    Kegiatan KBLI yang Diizinkan
                                    <span class="badge bg-primary-subtle text-primary fw-700"
                                        style="font-size: 0.65rem;">Standar 2025</span>
                                    <span class="text-muted fw-500 small">(kosongkan = semua kegiatan boleh)</span>
                                </label>

                                <!-- Tag display area -->
                                <div id="kbli-tags-create"
                                    class="d-flex flex-wrap gap-2 p-3 border rounded-3 bg-light mb-2"
                                    style="min-height: 52px;">
                                    <span class="text-muted small fw-500 fst-italic" id="kbli-empty-hint-create">Belum
                                        ada kode KBLI dipilih — klik "Tambah KBLI" atau ketik untuk mencari</span>
                                </div>

                                <!-- Hidden input carries comma-separated codes -->
                                <input type="hidden" name="kbli_allowed" id="kbli-hidden-create" value="">

                                <!-- Search input -->
                                <div class="input-group">
                                    <span class="input-group-text bg-white"><i
                                            class="bi bi-search text-muted"></i></span>
                                    <input type="text" id="kbli-search-create" class="form-control fw-600"
                                        placeholder="Cari kode atau nama kegiatan (cth: apotek, 86201, restoran)...">
                                    <button type="button" class="btn btn-outline-secondary" id="kbli-clear-create">
                                        <i class="bi bi-x-circle"></i>
                                    </button>
                                </div>

                                <!-- Results dropdown -->
                                <div id="kbli-results-create" class="border rounded-3 mt-1 bg-white shadow-sm d-none"
                                    style="max-height: 220px; overflow-y: auto; position: relative; z-index: 10;">
                                </div>

                                <div class="mt-1 small text-muted fw-500">
                                    <i class="bi bi-info-circle me-1"></i>
                                    Pilih satu atau lebih kode KBLI. Hanya kegiatan yang dipilih yang akan divalidasi
                                    saat analisis zonasi.
                                </div>
                            </div>

                        </div><!-- end row -->

                        <div class="mt-5 d-flex justify-content-end">
                            <button type="button" class="btn btn-primary px-5 py-2 fw-700 rounded-3 shadow-sm"
                                onclick="showTab('tab-itbx')">
                                LANJUT KE ITBX <i class="bi bi-arrow-right ms-2"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Tab 2: ITBX -->
                    <div class="tab-content-wizard d-none" id="tab-itbx">
                        <div class="form-section-title"><i class="bi bi-building-fill-gear"></i> Intensitas & Tata
                            Bangunan</div>
                        <div class="row g-4">
                            <!-- Sliders -->
                            <div class="col-md-6">
                                <div class="range-control-card">
                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                        <label class="fw-800 small text-muted text-uppercase">KDB (Dasar
                                            Bangunan)</label>
                                        <span class="range-value-badge" id="kdb-val">60%</span>
                                    </div>
                                    <input type="range" name="kdb" class="form-range" min="0" max="100" step="5"
                                        value="60" id="kdb-in">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="range-control-card">
                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                        <label class="fw-800 small text-muted text-uppercase">KLB (Lantai
                                            Bangunan)</label>
                                        <span class="range-value-badge" id="klb-val">2.0</span>
                                    </div>
                                    <input type="range" name="klb" class="form-range" min="0" max="10" step="0.5"
                                        value="2" id="klb-in">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="range-control-card">
                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                        <label class="fw-800 small text-muted text-uppercase">KDH (Dasar Hijau)</label>
                                        <span class="range-value-badge" id="kdh-val">30%</span>
                                    </div>
                                    <input type="range" name="kdh" class="form-range" min="0" max="100" step="5"
                                        value="30" id="kdh-in">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="range-control-card">
                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                        <label class="fw-800 small text-muted text-uppercase">KTB (Basement)</label>
                                        <span class="range-value-badge" id="ktb-val">0%</span>
                                    </div>
                                    <input type="range" name="ktb" class="form-range" min="0" max="100" step="5"
                                        value="0" id="ktb-in">
                                </div>
                            </div>

                            <!-- Numeric Inputs -->
                            <div class="col-md-4">
                                <label class="form-label fw-700 small">Ketinggian Max (M)</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-white border-end-0"><i
                                            class="bi bi-arrows-vertical"></i></span>
                                    <input type="number" name="ketinggian_max" class="form-control border-start-0"
                                        placeholder="0">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-700 small">Lantai Max</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-white border-end-0"><i
                                            class="bi bi-layers-half"></i></span>
                                    <input type="number" name="jumlah_lantai_max" class="form-control border-start-0"
                                        placeholder="0">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-700 small">Garis Sempadan (GSB)</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-white border-end-0"><i
                                            class="bi bi-rulers"></i></span>
                                    <input type="number" name="gsb" class="form-control border-start-0" placeholder="0">
                                </div>
                            </div>
                        </div>

                        <div class="mt-5 d-flex justify-content-between">
                            <button type="button" class="btn btn-light px-4 py-2 fw-700 rounded-3 border"
                                onclick="showTab('tab-info')">
                                <i class="bi bi-arrow-left me-2"></i> KEMBALI
                            </button>
                            <button type="button" class="btn btn-primary px-5 py-2 fw-700 rounded-3 shadow-sm"
                                onclick="showTab('tab-geometry')">
                                LANJUT KE DATA SPASIAL <i class="bi bi-arrow-right ms-2"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Tab 3: Geometry -->
                    <div class="tab-content-wizard d-none" id="tab-geometry">
                        <div class="form-section-title"><i class="bi bi-geo-alt-fill"></i> Konfigurasi Data Spasial
                        </div>

                        <div class="mb-5 bg-light p-4 rounded-4 border">
                            <label class="form-label fw-700 small mb-3">Protocol Upload Data Geopasial</label>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <div class="form-check card-premium p-3 border h-100" style="cursor: pointer;">
                                        <input class="form-check-input ms-0 me-3" type="radio" name="upload_type"
                                            id="up-geojson" value="geojson" checked>
                                        <label class="form-check-label fw-800 text-dark" for="up-geojson">
                                            Format GeoJSON
                                            <div class="fw-500 small text-muted mt-1 opacity-75">Unggah berkas .json
                                                atau .geojson standar industri GIS.</div>
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-check card-premium p-3 border h-100" style="cursor: pointer;">
                                        <input class="form-check-input ms-0 me-3" type="radio" name="upload_type"
                                            id="up-shp" value="shapefile">
                                        <label class="form-check-label fw-800 text-dark" for="up-shp">
                                            ESRI Shapefile
                                            <div class="fw-500 small text-muted mt-1 opacity-75">Unggah set berkas .shp,
                                                .shx, dan .dbf terkompresi.</div>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Dropzones simulated with styled inputs -->
                        <div id="geojson-input-area">
                            <label class="form-label fw-700 small">Pilih Berkas GeoJSON <span
                                    class="text-danger">*</span></label>
                            <div class="p-4 border border-2 border-dashed rounded-4 text-center bg-white">
                                <i class="bi bi-cloud-arrow-up fs-1 text-primary opacity-50 mb-3 d-block"></i>
                                <input type="file" name="geojson_file" class="form-control fw-600" id="gj-file"
                                    accept=".json,.geojson">
                                <p class="small text-muted mt-2 mb-0 fw-500">Format yang didukung: .json, .geojson |
                                    Disarankan Feature tunggal.</p>
                            </div>
                        </div>

                        <div id="shp-input-area" class="d-none">
                            <div class="row g-3">
                                <div class="col-md-4">
                                    <label class="small fw-800 text-muted">SHP FILE <span
                                            class="text-danger">*</span></label>
                                    <input type="file" name="shp_file" class="form-control" accept=".shp">
                                </div>
                                <div class="col-md-4">
                                    <label class="small fw-800 text-muted">SHX FILE <span
                                            class="text-danger">*</span></label>
                                    <input type="file" name="shx_file" class="form-control" accept=".shx">
                                </div>
                                <div class="col-md-4">
                                    <label class="small fw-800 text-muted">DBF FILE <span
                                            class="text-danger">*</span></label>
                                    <input type="file" name="dbf_file" class="form-control" accept=".dbf">
                                </div>
                            </div>
                        </div>

                        <div class="mt-5 d-flex justify-content-between">
                            <button type="button" class="btn btn-light px-4 py-2 fw-700 rounded-3 border"
                                onclick="showTab('tab-itbx')">
                                <i class="bi bi-arrow-left me-2"></i> KEMBALI
                            </button>
                            <div class="d-flex gap-2">
                                <a href="<?= base_url('admin/rdtr') ?>"
                                    class="btn btn-light px-4 py-2 fw-700 rounded-3 text-muted">BATAL</a>
                                <button type="submit" class="btn btn-primary px-5 py-2 fw-700 rounded-3 shadow">
                                    <i class="bi bi-cloud-check-fill me-2"></i> KUKUHKAN DATA ZONA
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
<?php $this->endSection() ?>

<?php $this->section('scripts') ?>
<script>
    function showTab(tabId) {
        // Hide all tabs
        document.querySelectorAll('.tab-content-wizard').forEach(t => t.classList.add('d-none'));
        // Show target tab
        document.getElementById(tabId).classList.remove('d-none');

        // Update wizard nav
        document.querySelectorAll('.wizard-step').forEach(s => s.classList.remove('active'));
        const stepId = tabId.replace('tab-', 'step-');
        document.getElementById(stepId).classList.add('active');

        // Scroll to top
        window.scrollTo({ top: 0, behavior: 'smooth' });
    }

    // Live Slider Updates
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

    // Toggle Upload Inputs
    document.querySelectorAll('input[name="upload_type"]').forEach(radio => {
        radio.addEventListener('change', (e) => {
            const isGeojson = e.target.value === 'geojson';
            document.getElementById('geojson-input-area').classList.toggle('d-none', !isGeojson);
            document.getElementById('shp-input-area').classList.toggle('d-none', isGeojson);

            // Required hacks
            document.getElementById('gj-file').required = isGeojson;
            document.querySelectorAll('#shp-input-area input').forEach(i => i.required = !isGeojson);
        });
    });

    // Initial required state
    document.getElementById('gj-file').required = true;

    // ============================================================
    // KBLI 2025 Autocomplete Engine — create form
    // ============================================================
    (function kbliSelector(suffix) {
        const searchEl = document.getElementById('kbli-search-' + suffix);
        const resultsEl = document.getElementById('kbli-results-' + suffix);
        const tagsEl = document.getElementById('kbli-tags-' + suffix);
        const hiddenEl = document.getElementById('kbli-hidden-' + suffix);
        const hintEl = document.getElementById('kbli-empty-hint-' + suffix);
        const clearBtn = document.getElementById('kbli-clear-' + suffix);

        if (!searchEl) return;

        let kbliData = {};
        let selected = {}; // {code: name}

        // Load JSON once
        fetch('<?= base_url('json/kbli2025.json') ?>')
            .then(r => r.json())
            .then(j => { kbliData = j.data || {}; })
            .catch(() => console.warn('KBLI JSON load failed'));

        function updateHidden() {
            hiddenEl.value = Object.keys(selected).join(',');
        }

        function renderTags() {
            tagsEl.innerHTML = '';
            const codes = Object.keys(selected);
            if (codes.length === 0) {
                tagsEl.appendChild(hintEl);
                return;
            }
            codes.forEach(code => {
                const tag = document.createElement('span');
                tag.className = 'badge d-flex align-items-center gap-1 fw-700 px-3 py-2';
                tag.style.cssText = 'background:#eff6ff;color:#1d4ed8;border:1px solid #bfdbfe;font-size:0.75rem;border-radius:8px;';
                tag.innerHTML = `<span>${code}</span><span class="text-muted fw-500" style="font-size:0.65rem;max-width:160px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;">${selected[code]}</span><button type="button" class="btn-close ms-1" style="font-size:0.5rem;" data-code="${code}"></button>`;
                tag.querySelector('.btn-close').addEventListener('click', () => {
                    delete selected[code];
                    renderTags();
                    updateHidden();
                });
                tagsEl.appendChild(tag);
            });
        }

        function renderResults(keyword) {
            keyword = keyword.trim().toLowerCase();
            resultsEl.innerHTML = '';
            if (!keyword) { resultsEl.classList.add('d-none'); return; }

            const matches = Object.entries(kbliData).filter(([code, name]) =>
                code.startsWith(keyword) || name.toLowerCase().includes(keyword)
            ).slice(0, 25);

            if (matches.length === 0) {
                resultsEl.innerHTML = '<div class="p-3 text-muted small fw-600">Tidak ada hasil untuk "' + keyword + '"</div>';
                resultsEl.classList.remove('d-none');
                return;
            }

            matches.forEach(([code, name]) => {
                const item = document.createElement('div');
                const isSelected = !!selected[code];
                item.className = 'px-3 py-2 d-flex gap-2 align-items-center small fw-600 ' + (isSelected ? 'bg-primary-subtle' : 'hover-bg');
                item.style.cursor = 'pointer';
                item.innerHTML = `<span class="badge bg-primary-subtle text-primary fw-800 me-1" style="min-width:54px;font-size:0.7rem;">${code}</span><span class="text-dark">${name}</span>${isSelected ? '<i class="bi bi-check-circle-fill text-primary ms-auto"></i>' : ''}`;
                item.addEventListener('click', () => {
                    if (isSelected) { delete selected[code]; }
                    else { selected[code] = name; }
                    renderTags();
                    updateHidden();
                    renderResults(searchEl.value);
                });
                resultsEl.appendChild(item);
            });

            resultsEl.classList.remove('d-none');
        }

        searchEl.addEventListener('input', () => renderResults(searchEl.value));
        searchEl.addEventListener('focus', () => { if (searchEl.value) renderResults(searchEl.value); });
        document.addEventListener('click', e => {
            if (!resultsEl.contains(e.target) && e.target !== searchEl) resultsEl.classList.add('d-none');
        });
        clearBtn.addEventListener('click', () => {
            searchEl.value = '';
            resultsEl.classList.add('d-none');
        });
    })('create');
</script>
<?php $this->endSection() ?>