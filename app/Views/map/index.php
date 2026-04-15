<?php /** @var \CodeIgniter\View\View $this */ ?>
<?php $this->extend('layouts/main') ?>

<?php $this->section('styles') ?>
<link rel="stylesheet" href="https://unpkg.com/leaflet.fullscreen@1.6.0/Control.FullScreen.css" />
<link rel="stylesheet" href="<?= base_url('css/map-custom.css') ?>">
<?php $this->endSection() ?>

<?php $this->section('content') ?>
<?php
$settingsModel = new \App\Models\SettingsModel();
$role = session()->get('role');
$mapLat = $settingsModel->getValueWithRole('map_center_lat', $role, '-3.45');
$mapLng = $settingsModel->getValueWithRole('map_center_lng', $role, 115.97);
$appName = $settingsModel->getValueWithRole('app_name', $role, 'Geotagging App');
$appSubtitle = $settingsModel->getValueWithRole('app_subtitle', $role, 'Pusat Data Spasial');
?>

<div class="map-layout-container d-lg-flex flex-lg-row-reverse flex-grow-1 overflow-hidden">
    <!-- Map Content First in Source for Mobile (Stacks on top) -->
    <div class="map-content-wrapper d-flex flex-column gap-3 flex-grow-1"
        style="animation: fadeInUp 0.8s cubic-bezier(0.16, 1, 0.3, 1); min-height: 0;">
        <div class="map-frame flex-grow-1" style="min-height: 0;">
            <div id="map" style="height: 100%;"></div>
        </div>
    </div>

    <!-- Floating Widget (Sidebar on Desktop, Bottom on Mobile) -->
    <div class="floating-panel shadow-premium" style="display: none;">
        <div class="panel-header glass-header">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="d-flex align-items-center gap-2 mb-0">
                    <div class="header-icon"><i class="bi bi-info-circle-fill"></i></div>
                    <span class="panel-title-text">DATA SPASIAL</span>
                </h5>
                <button type="button" class="btn-close shadow-none" id="btn-close-panel" aria-label="Close"></button>
            </div>
        </div>
        <div class="panel-body" id="info-panel">
            <div class="alert alert-primary border-0 mb-4"
                style="background: rgba(99, 102, 241, 0.1); border-radius: 16px;">
                <div class="d-flex gap-3 align-items-center">
                    <i class="bi bi-cursor-fill pulse text-primary"></i>
                    <div class="small fw-600 text-dark">Klik pada peta untuk menganalisis lokasi secara instan.</div>
                </div>
            </div>

            <!-- Search Coordinates -->
            <div class="search-container mb-4">
                <div class="row g-0">
                    <div class="col-6 border-end">
                        <div class="form-floating">
                            <input type="text" id="input-lat" class="form-control" placeholder="Lat">
                            <label for="input-lat">Latitude</label>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-floating">
                            <input type="text" id="input-lng" class="form-control" placeholder="Lng">
                            <label for="input-lng">Longitude</label>
                        </div>
                    </div>
                </div>
                <button class="btn btn-portal w-100 mt-2 py-3" id="btn-search-coord">
                    <i class="bi bi-search me-2"></i> PERIKSA KOORDINAT
                </button>
            </div>

            <div id="result-container" class="mt-4" style="display:none; animation: slideUp 0.5s ease;">
                <!-- Coordinate Hero -->
                <div class="coordinate-hero p-4 mb-4"
                    style="background: var(--grad-primary); border-radius: 20px; color: white; box-shadow: var(--shadow-glow);">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="small opacity-75 fw-bold mb-1"><i class="bi bi-geo-alt-fill me-1"></i> KOORDINAT
                                PENGECEKAN</div>
                            <div class="h5 fw-800 mb-0" id="res-coord">-</div>
                        </div>
                        <div class="bg-white bg-opacity-25 rounded-circle p-2">
                            <i class="bi bi-broadcast fs-3"></i>
                        </div>
                    </div>
                </div>

                <div id="section-rdtr" class="mb-4">
                    <div class="section-badge mb-3"><i class="bi bi-layers-fill me-2"></i> RENCANA DETAIL (RDTR)</div>
                    <div id="res-rdtr"></div>
                </div>

                <div id="section-rtrw" class="mb-4">
                    <div class="section-badge mb-3" style="background: rgba(245, 158, 11, 0.1); color: var(--accent);">
                        <i class="bi bi-map-fill me-2"></i> RENCANA WILAYAH (RTRW)
                    </div>
                    <div id="res-rtrw"></div>
                </div>

                <!-- KBLI Validation Section -->
                <div class="kbli-card p-4 mt-4"
                    style="background: white; border: 2px dashed #e2e8f0; border-radius: 24px;">
                    <h6 class="fw-800 text-dark mb-3 d-flex align-items-center">
                        <i class="bi bi-shield-check text-success fs-4 me-2"></i> VALIDASI KERUANGAN KBLI
                    </h6>
                    <div class="input-group input-group-lg mb-2">
                        <input type="text" id="kbli-code" class="form-control" placeholder="Kode KBLI"
                            style="background: #f8fafc; border: 1px solid #e2e8f0; font-weight: 700; border-radius: 12px 0 0 12px;">
                        <button class="btn btn-outline-primary px-3" type="button" data-bs-toggle="modal"
                            data-bs-target="#kbliLookupModal">
                            <i class="bi bi-search"></i>
                        </button>
                        <button class="btn btn-success px-4" type="button" id="btn-validate-kbli"
                            style="border-radius: 0 12px 12px 0;">
                            <i class="bi bi-check-lg"></i>
                        </button>
                    </div>
                    <div id="kbli-result"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Disclaimer Modal -->
<div class="modal fade" id="disclaimerModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 24px; overflow: hidden;">
            <div class="modal-header border-0 p-4"
                style="background: linear-gradient(135deg, #f59e0b, #d97706); color: white;">
                <h5 class="modal-title fw-800"><i class="bi bi-exclamation-triangle-fill me-2"></i> PERHATIAN PENTING
                </h5>
            </div>
            <div class="modal-body p-4">
                <p class="fw-700 text-dark">Informasi ini bersifat indikatif dan bukan merupakan rujukan legal formal.
                </p>
                <div class="p-3 bg-light rounded-4 mb-4" style="font-size: 0.85rem; border: 1px solid #e2e8f0;">
                    <ul class="mb-0 text-muted fw-500">
                        <li class="mb-2">Data mengacu pada ketersediaan spasial terbaru.</li>
                        <li class="mb-2">Bukan rujukan resmi untuk KKPR/Izin Lokasi tetap.</li>
                        <li>Verifikasi resmi silakan hubungi kantor DPMPTSP setempat.</li>
                    </ul>
                </div>
                <div class="form-check form-switch p-0 d-flex align-items-center gap-3">
                    <input class="form-check-input ms-0 mt-0" type="checkbox" id="agreeCheck"
                        style="width: 50px; height: 26px;">
                    <label class="form-check-label fw-800 text-dark" for="agreeCheck">Saya Mengerti & Setuju</label>
                </div>
            </div>
            <div class="modal-footer border-0 p-4 pt-0 text-end">
                <button type="button" class="btn btn-portal w-100 py-3" id="btnAgree" disabled>MASUK KE PETA</button>
            </div>
        </div>
    </div>
</div>

<!-- Activity Detail Modal -->
<div class="modal fade" id="activityModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 24px; overflow: hidden;">
            <!-- Modern Header -->
            <div class="modal-header border-0 p-3"
                style="background: linear-gradient(135deg, #1e40af 0%, #3b82f6 100%); color: white;">
                <div>
                    <h6 class="modal-title fw-800 mb-0">
                        <i class="bi bi-clipboard-check-fill me-2"></i> RINCIAN KEGIATAN ZONA
                    </h6>
                </div>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body p-0">
                <!-- Zone Information Card -->
                <div class="p-3"
                    style="background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%); border-bottom: 2px solid #cbd5e1;">
                    <div class="d-flex align-items-center justify-content-between gap-3">
                        <div class="d-flex align-items-center gap-2">
                            <div class="bg-white rounded-3 p-2 shadow-sm">
                                <i class="bi bi-geo-alt-fill text-primary fs-5"></i>
                            </div>
                            <div>
                                <div class="small text-muted fw-600">Zona Peruntukan</div>
                                <div class="fw-800 text-dark" style="font-size: 1.1rem;" id="activity-zone-name">-</div>
                                <div class="badge bg-primary bg-opacity-10 text-primary fw-600 px-2 py-1 mt-1"
                                    style="font-size: 0.7rem;" id="activity-zone-desc">-</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Activity Categories -->
                <div class="p-3" style="max-height: 400px; overflow-y: auto;">
                    <div class="accordion" id="activityAccordion">
                        <!-- Diizinkan -->
                        <div class="accordion-item border-0 mb-3 shadow-sm"
                            style="border-radius: 16px; overflow: hidden; border-left: 5px solid #10b981 !important;">
                            <h2 class="accordion-header">
                                <button class="accordion-button fw-700 py-2" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#col-i"
                                    style="background: linear-gradient(to right, #ecfdf5, #ffffff); color: #065f46; border-radius: 16px; font-size: 0.9rem;">
                                    <i class="bi bi-check-circle-fill text-success me-2"></i>
                                    <span class="fw-800">KEGIATAN DIIZINKAN</span>
                                </button>
                            </h2>
                            <div id="col-i" class="accordion-collapse collapse show">
                                <div class="accordion-body p-3" id="list-diizinkan"
                                    style="background: #fafafa; font-size: 0.85rem;"></div>
                            </div>
                        </div>

                        <!-- Terbatas -->
                        <div class="accordion-item border-0 mb-3 shadow-sm"
                            style="border-radius: 16px; overflow: hidden; border-left: 5px solid #f59e0b !important;">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed fw-700 py-2" type="button"
                                    data-bs-toggle="collapse" data-bs-target="#col-t"
                                    style="background: linear-gradient(to right, #fffbeb, #ffffff); color: #92400e; border-radius: 16px; font-size: 0.9rem;">
                                    <i class="bi bi-exclamation-triangle-fill text-warning me-2"></i>
                                    <span class="fw-800">KEGIATAN TERBATAS</span>
                                </button>
                            </h2>
                            <div id="col-t" class="accordion-collapse collapse">
                                <div class="accordion-body p-3" id="list-terbatas"
                                    style="background: #fafafa; font-size: 0.85rem;"></div>
                            </div>
                        </div>

                        <!-- Bersyarat -->
                        <div class="accordion-item border-0 mb-3 shadow-sm"
                            style="border-radius: 16px; overflow: hidden; border-left: 5px solid #3b82f6 !important;">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed fw-700 py-2" type="button"
                                    data-bs-toggle="collapse" data-bs-target="#col-b"
                                    style="background: linear-gradient(to right, #eff6ff, #ffffff); color: #1e3a8a; border-radius: 16px; font-size: 0.9rem;">
                                    <i class="bi bi-file-earmark-text-fill text-primary me-2"></i>
                                    <span class="fw-800">KEGIATAN BERSYARAT</span>
                                </button>
                            </h2>
                            <div id="col-b" class="accordion-collapse collapse">
                                <div class="accordion-body p-3" id="list-bersyarat"
                                    style="background: #fafafa; font-size: 0.85rem;"></div>
                            </div>
                        </div>

                        <!-- Dilarang -->
                        <div class="accordion-item border-0 mb-3 shadow-sm"
                            style="border-radius: 16px; overflow: hidden; border-left: 5px solid #ef4444 !important;">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed fw-700 py-2" type="button"
                                    data-bs-toggle="collapse" data-bs-target="#col-x"
                                    style="background: linear-gradient(to right, #fef2f2, #ffffff); color: #991b1b; border-radius: 16px; font-size: 0.9rem;">
                                    <i class="bi bi-x-circle-fill text-danger me-2"></i>
                                    <span class="fw-800">KEGIATAN DILARANG</span>
                                </button>
                            </h2>
                            <div id="col-x" class="accordion-collapse collapse">
                                <div class="accordion-body p-3" id="list-dilarang"
                                    style="background: #fafafa; font-size: 0.85rem;"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Footer -->
            <div class="modal-footer border-0 bg-light p-2">
                <div class="text-muted fw-600" style="font-size: 0.75rem;">
                    <i class="bi bi-info-circle me-1"></i>
                    Informasi berdasarkan Peraturan Daerah RDTR
                </div>
            </div>
        </div>
    </div>
</div>

<!-- KBLI Lookup Modal -->
<div class="modal fade" id="kbliLookupModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 24px; overflow: hidden;">
            <div class="modal-header border-0 p-4"
                style="background: linear-gradient(135deg, #2a5298, #1e3c72); color: white;">
                <h5 class="modal-title fw-800"><i class="bi bi-search me-2"></i> CARI KODE KBLI 2020</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4">
                <div class="input-group input-group-lg shadow-sm mb-4">
                    <span class="input-group-text bg-white border-end-0"><i class="bi bi-search text-muted"></i></span>
                    <input type="text" id="kbli-search-input" class="form-control border-start-0 ps-0"
                        placeholder="Ketik kode atau nama kegiatan usaha (min. 2 karakter)...">
                </div>
                <div id="kbli-search-results" class="list-group list-group-flush rounded-4 overflow-hidden shadow-sm"
                    style="max-height: 400px; overflow-y: auto;">
                    <div class="p-4 text-center text-muted fw-600">Silakan cari kode KBLI untuk divalidasi dengan zonasi
                        peta.</div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php $this->endSection() ?>

<?php $this->section('scripts') ?>
<script src="https://unpkg.com/leaflet.fullscreen@1.6.0/Control.FullScreen.js"></script>
<script>
    // Pass PHP values to JS
    const mapConfig = {
        lat: <?= $mapLat ?>,
        lng: <?= $mapLng ?>,
        appName: '<?= esc($appName) ?>'
    };

    // KBLI Data for Lookup
    const KBLI_DATA = {
        "47111": "Toko Kelontong / Perdagangan Eceran Berbagai Macam Barang",
        "47112": "Minimarket",
        "47113": "Supermarket",
        "47711": "Perdagangan Eceran Pakaian",
        "47411": "Perdagangan Eceran Alat Komunikasi & Elektronik",
        "47721": "Apotek / Perdagangan Eceran Barang Farmasi",
        "56101": "Restoran / Rumah Makan",
        "56301": "Kafe / Kedai Kopi",
        "56102": "Warung Makan (Skala Mikro/Kecil)",
        "96021": "Salon Kecantikan & Perawatan Tubuh",
        "45401": "Bengkel Motor & Reparasi Kendaraan Bermotor",
        "96011": "Laundry / Jasa Pencucian Kebutuhan Rumah Tangga",
        "82191": "Fotokopi, Penyiapan Dokumen & Jasa Khusus Kantor Lainnya",
        "84111": "Administrasi Pemerintahan Umum & Pelayanan Publik",
        "68100": "Real Estat Yang Dimiliki Sendiri Atau Disewa (Kantor/Ruko)",
        "64191": "Perbankan / Bank Umum",
        "65111": "Asuransi Jiwa",
        "10611": "Industri Penggilingan Padi & Penyosopan Beras",
        "11011": "Industri Minuman / Pengolahan Minuman Beralkohol/Bukan",
        "31001": "Industri Furnitur Dari Kayu",
        "14101": "Industri Pakaian Jadi (Konveksi) Dari Tekstil",
        "85101": "Pendidikan Taman Kanak-Kanak / PAUD",
        "85102": "Pendidikan Dasar (SD/MI)",
        "85311": "Pendidikan Menengah Pertama (SMP/MTs)",
        "85321": "Pendidikan Menengah Atas/Kejuruan (SMA/SMK)",
        "85491": "Bimbingan Belajar & Pelatihan Swasta",
        "86101": "Aktivitas Rumah Sakit Pemerintah/Swasta",
        "86102": "Aktivitas Puskesmas",
        "86201": "Praktik Dokter Umum",
        "86202": "Praktik Dokter Spesialis",
        "41001": "Konstruksi Gedung Hunian (Rumah Tinggal)",
        "41002": "Konstruksi Gedung Hunian (Apartemen/Rumah Susun)",
        "55101": "Hotel Bintang & Akomodasi Sejenisnya",
        "55103": "Penginapan Remaja (Hostel) & Pondok Wisata",
        "94911": "Organisasi Peribadatan Islam (Masjid/Musholla)",
        "94912": "Organisasi Peribadatan Kristen (Gereja)",
        "94913": "Organisasi Peribadatan Hindu (Pura)",
        "94914": "Organisasi Peribadatan Buddha (Vihara)"
    };
</script>
<script src="<?= base_url('js/map-custom.js') ?>"></script>
<?php $this->endSection() ?>