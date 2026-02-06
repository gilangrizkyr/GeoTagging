<?php /** @var \CodeIgniter\View\View $this */?>
<?php $this->extend('layouts/main')?>

<?php $this->section('styles')?>
<link rel="stylesheet" href="https://unpkg.com/leaflet.fullscreen@1.6.0/Control.FullScreen.css" />
<style>
    .map-header-title {
        text-align: center;
        margin-bottom: 0.25rem;
    }

    .map-header-title h1 {
        font-size: 2.8rem;
        font-weight: 800;
        background: linear-gradient(to right, #3c4b64 0%, #3c4b64 50%, #27ae60 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        line-height: 1.2;
        margin-bottom: 0px !important;
        letter-spacing: -0.04em;
    }

    .map-header-subtitle {
        font-size: 0.85rem;
        font-weight: 700;
        color: #475569;
        text-transform: uppercase;
        letter-spacing: 4px;
        margin-top: 4px;
        position: relative;
        display: inline-block;
    }

    @media (max-width: 991px) {
        .map-header-title h1 {
            font-size: 1.8rem;
        }

        .map-header-subtitle {
            font-size: 0.7rem;
            letter-spacing: 2px;
        }
    }

    .map-frame {
        border-radius: var(--radius-2xl);
        overflow: hidden;
        border: 1px solid rgba(255, 255, 255, 0.4);
        box-shadow: var(--shadow-premium);
        transition: var(--transition-bounce);
        background: #fff;
        /* Fallback */
    }

    #map {
        width: 100%;
        height: 100%;
        border-radius: inherit;
        z-index: 1;
    }

    .map-header-title {
        text-align: center;
        margin-bottom: 0.25rem;
        animation: fadeInDown 0.8s cubic-bezier(0.16, 1, 0.3, 1);
    }

    @keyframes fadeInDown {
        from {
            opacity: 0;
            transform: translateY(-20px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .btn-portal {
        transition: var(--transition-bounce) !important;
    }

    .btn-portal:hover {
        transform: translateY(-5px) scale(1.05);
        box-shadow: 0 15px 30px rgba(60, 75, 100, 0.3);
        filter: brightness(1.1);
    }

    .result-card {
        border: var(--glass-border);
        background: rgba(255, 255, 255, 0.5);
        backdrop-filter: blur(10px);
        transition: var(--transition-bounce);
    }

    .result-card:hover {
        transform: translateY(-5px) scale(1.02);
        background: rgba(255, 255, 255, 0.8);
        box-shadow: var(--shadow-premium);
    }

    /* Floating Panel Responsive Logic */
    @media (min-width: 992px) {
        .floating-panel {
            width: 440px;
            max-height: calc(100vh - 180px);
            display: none;
            /* Initial state */
            flex-direction: column;
            overflow: hidden;
            z-index: 1000;
        }

        .panel-body {
            overflow-y: auto;
            overflow-x: hidden;
            flex: 1;
            padding: 20px;
            padding-right: 8px;
            scrollbar-gutter: stable;
        }
    }

    @media (max-width: 991px) {
        .floating-panel {
            width: 100% !important;
            max-height: none;
            display: none;
            /* Initial state */
            margin-bottom: 20px;
            margin-top: 20px;
            position: relative !important;
            top: 0 !important;
            left: 0 !important;
            transform: none !important;
            animation: slideUp 0.5s ease-out !important;
            z-index: auto !important;
            /* Ensure panel doesn't overlay map */
        }

        .panel-body {
            overflow: visible;
        }

        .map-frame {
            height: 450px !important;
            min-height: 450px;
            position: relative;
            z-index: 1;
        }

        #map {
            height: 100% !important;
            min-height: 100% !important;
            z-index: 1;
            position: relative;
        }

        /* Force Leaflet Controls Visibility */
        .leaflet-control-container {
            z-index: 2000 !important;
            opacity: 1 !important;
            visibility: visible !important;
        }
    }
</style>
<?php $this->endSection()?>

<?php $this->section('content')?>
<?php
$settingsModel = new \App\Models\SettingsModel();
$role = session()->get('role');
$mapLat = $settingsModel->getValueWithRole('map_center_lat', $role, '-3.45');
$mapLng = $settingsModel->getValueWithRole('map_center_lng', $role, 115.97);
$appName = $settingsModel->getValueWithRole('app_name', $role, 'Geotagging App');
$appSubtitle = $settingsModel->getValueWithRole('app_subtitle', $role, 'Pusat Data Spasial');
?>

<div class="map-content-wrapper d-flex flex-column gap-3 flex-grow-1"
    style="animation: fadeInUp 0.8s cubic-bezier(0.16, 1, 0.3, 1); min-height: 0;">
    <div class="map-header-title">
        <h1 style="font-family: 'Outfit', sans-serif;">
            <?= esc($appName)?>
        </h1>
        <div class="map-header-subtitle">
            <?= esc($appSubtitle)?>
        </div>
    </div>
    <div class="map-frame flex-grow-1" style="min-height: 0;">
        <div id="map" style="height: 100%; min-height: 450px;"></div>
    </div>
</div>

<!-- Floating Widget (Sidebar on Desktop) -->
<div class="floating-panel" style="display: none;">
    <div class="panel-header">
        <div class="d-flex justify-content-between align-items-center">
            <h5>
                <div class="header-icon"><i class="bi bi-info-circle-fill"></i></div>
                Data Spasial
            </h5>
            <button type="button" class="btn-close" id="btn-close-panel" aria-label="Close"></button>
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
                <div class="section-badge mb-3" style="background: rgba(245, 158, 11, 0.1); color: var(--accent);"><i
                        class="bi bi-map-fill me-2"></i> RENCANA WILAYAH (RTRW)</div>
                <div id="res-rtrw"></div>
            </div>

            <!-- KBLI Validation Section -->
            <div class="kbli-card p-4 mt-4" style="background: white; border: 2px dashed #e2e8f0; border-radius: 24px;">
                <h6 class="fw-800 text-dark mb-3 d-flex align-items-center">
                    <i class="bi bi-shield-check text-success fs-4 me-2"></i> VALIDASI KBLI
                </h6>
                <div class="input-group input-group-lg mb-2">
                    <input type="text" id="kbli-code" class="form-control" placeholder="Kode KBLI"
                        style="background: #f8fafc; border: 1px solid #e2e8f0; font-weight: 700; border-radius: 12px 0 0 12px;">
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

<style>
    @keyframes pulse {
        0% {
            transform: scale(1);
            opacity: 1;
        }

        50% {
            transform: scale(1.2);
            opacity: 0.7;
        }

        100% {
            transform: scale(1);
            opacity: 1;
        }
    }

    .pulse {
        animation: pulse 2s infinite ease-in-out;
    }

    @keyframes slideUp {
        from {
            transform: translateY(30px) scale(0.95);
            opacity: 0;
        }

        to {
            transform: translateY(0) scale(1);
            opacity: 1;
        }
    }

    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .section-badge {
        display: inline-flex;
        align-items: center;
        padding: 6px 16px;
        background: rgba(99, 102, 241, 0.1);
        color: var(--primary);
        border-radius: 100px;
        font-size: 0.7rem;
        font-weight: 800;
        letter-spacing: 1px;
    }

    .result-card {
        background: white;
        border-radius: 24px;
        border: 1px solid #f1f5f9;
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.02);
        overflow: hidden;
        transition: var(--transition-bounce);
    }

    .result-card:hover {
        transform: translateY(-5px);
        box-shadow: var(--shadow-premium);
    }

    .data-row {
        padding: 12px 0;
        border-bottom: 1px solid #f1f5f9;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .data-row:last-child {
        border-bottom: none;
    }

    .data-label {
        color: #64748b;
        font-size: 0.75rem;
        font-weight: 600;
    }

    .data-value {
        color: #0f172a;
        font-size: 0.85rem;
        font-weight: 800;
    }

    /* Fullscreen Icon Override */
    .leaflet-control-fullscreen a {
        background: #fff;
        background-image: none !important;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .leaflet-control-fullscreen a::before {
        content: "\f14d";
        /* bi-arrows-fullscreen */
        font-family: "bootstrap-icons";
        font-size: 1.2rem;
        color: #333;
    }

    .leaflet-control-fullscreen.leaflet-fullscreen-on a::before {
        content: "\f3e1";
        /* bi-fullscreen-exit */
    }

    /* Activity Modal Styles */
    .activity-card {
        background: white;
        border-radius: 12px;
        padding: 16px;
        border: 1px solid #e5e7eb;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .activity-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1);
        border-color: #cbd5e1;
    }

    .activity-number {
        min-width: 36px;
        height: 36px;
        background: linear-gradient(135deg, #10b981, #059669);
        color: white;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 800;
        font-size: 0.9rem;
        box-shadow: 0 4px 6px -1px rgba(16, 185, 129, 0.3);
    }

    .activity-number.warning {
        background: linear-gradient(135deg, #f59e0b, #d97706);
        box-shadow: 0 4px 6px -1px rgba(245, 158, 11, 0.3);
    }

    .activity-number.primary {
        background: linear-gradient(135deg, #3b82f6, #2563eb);
        box-shadow: 0 4px 6px -1px rgba(59, 130, 246, 0.3);
    }

    .activity-number.danger {
        background: linear-gradient(135deg, #ef4444, #dc2626);
        box-shadow: 0 4px 6px -1px rgba(239, 68, 68, 0.3);
    }

    .activity-badge {
        display: inline-flex;
        align-items: center;
        padding: 4px 12px;
        border-radius: 6px;
        font-size: 0.7rem;
        font-weight: 800;
        letter-spacing: 0.5px;
        text-transform: uppercase;
    }

    .activity-badge.success {
        background: linear-gradient(135deg, #d1fae5, #a7f3d0);
        color: #065f46;
    }

    .activity-badge.warning {
        background: linear-gradient(135deg, #fef3c7, #fde68a);
        color: #92400e;
    }

    .activity-badge.primary {
        background: linear-gradient(135deg, #dbeafe, #bfdbfe);
        color: #1e3a8a;
    }

    .activity-badge.danger {
        background: linear-gradient(135deg, #fee2e2, #fecaca);
        color: #991b1b;
    }

    .activity-name {
        font-size: 0.95rem;
        font-weight: 700;
        color: #1f2937;
        line-height: 1.5;
    }

    .activity-note {
        background: linear-gradient(135deg, #fffbeb, #fef3c7);
        border-left: 3px solid #f59e0b;
        padding: 10px 12px;
        border-radius: 8px;
        font-size: 0.85rem;
        color: #78350f;
        font-weight: 600;
    }

    .activity-requirement {
        background: linear-gradient(135deg, #eff6ff, #dbeafe);
        border-left: 3px solid #3b82f6;
        padding: 10px 12px;
        border-radius: 8px;
        font-size: 0.85rem;
        color: #1e3a8a;
        font-weight: 600;
    }

    .empty-state {
        text-align: center;
        padding: 40px 20px;
        color: #9ca3af;
    }

    .empty-state i {
        opacity: 0.5;
    }

    .empty-state div {
        font-weight: 600;
        font-size: 0.9rem;
    }

    @keyframes slideInUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* Mobile Responsive Optimizations */
    @media (min-width: 1200px) {
        .modal-xl-custom {
            max-width: 1140px;
        }
    }

    @media (max-width: 991px) {

        /* Reduce modal padding on mobile */
        #activityModal .modal-header {
            padding: 16px !important;
        }

        #activityModal .modal-header h5 {
            font-size: 1.1rem;
        }

        #activityModal .modal-header .small {
            font-size: 0.7rem;
        }

        /* Compact zone info card */
        #activityModal .modal-body>div:first-child {
            padding: 16px !important;
        }

        #activityModal .modal-body>div:first-child .row {
            flex-direction: column;
        }

        #activityModal .modal-body>div:first-child .col-md-4 {
            text-align: left !important;
            margin-top: 16px;
            padding-top: 16px;
            border-top: 2px solid #cbd5e1;
        }

        #activityModal .modal-body>div:first-child .h4 {
            font-size: 1.2rem;
        }

        #activityModal .modal-body>div:first-child .bg-white {
            padding: 12px !important;
        }

        #activityModal .modal-body>div:first-child .ms-5 {
            margin-left: 0 !important;
        }

        #activityModal .modal-body>div:first-child .ps-4 {
            padding-left: 0 !important;
        }

        /* Compact activity categories */
        #activityModal .modal-body>div:last-child {
            padding: 16px !important;
        }

        #activityModal .accordion-button {
            padding: 12px 16px !important;
            font-size: 0.85rem;
        }

        #activityModal .accordion-button i {
            font-size: 1rem !important;
        }

        #activityModal .accordion-button>div>div:first-child {
            font-size: 0.85rem;
        }

        #activityModal .accordion-button>div>div:last-child {
            font-size: 0.7rem;
        }

        #activityModal .accordion-body {
            padding: 12px !important;
        }

        /* Compact activity cards */
        .activity-card {
            padding: 12px !important;
            margin-bottom: 12px !important;
        }

        .activity-number {
            min-width: 32px !important;
            height: 32px !important;
            font-size: 0.8rem !important;
        }

        .activity-badge {
            font-size: 0.65rem !important;
            padding: 3px 8px !important;
        }

        .activity-name {
            font-size: 0.85rem !important;
        }

        .activity-note,
        .activity-requirement {
            padding: 8px 10px !important;
            font-size: 0.75rem !important;
        }

        /* Compact footer */
        #activityModal .modal-footer {
            padding: 12px 16px !important;
        }

        #activityModal .modal-footer .small {
            font-size: 0.7rem;
        }

        /* Reduce accordion item spacing */
        #activityModal .accordion-item {
            margin-bottom: 12px !important;
        }
    }
</style>

<?php $this->endSection()?>

<?php $this->section('scripts')?>
<script src="https://unpkg.com/leaflet.fullscreen@1.6.0/Control.FullScreen.js"></script>
<script>
    $(document).ready(function () {
        // Panel Logic
        $('#btn-close-panel').click(function () { $('.floating-panel').fadeOut(300); });
        // Disclaimer Logic
        const discModal = new bootstrap.Modal(document.getElementById('disclaimerModal'), { backdrop: 'static', keyboard: false });
        discModal.show();
        $('#agreeCheck').change(function () { $('#btnAgree').prop('disabled', !this.checked); });
        $('#btnAgree').click(function () { discModal.hide(); });

        // Map Setup
        const map = L.map('map', { zoomControl: false, attributionControl: false }).setView([<?= $mapLat?>, <?= $mapLng?>], 12);

        // Manual control addition to ensure visibility
        L.control.zoom({ position: 'bottomright' }).addTo(map);
        L.control.fullscreen({
            position: 'bottomright',
            title: {
                'false': 'View Fullscreen',
                'true': 'Exit Fullscreen'
            }
        }).addTo(map);

        // Basemaps
        const osm = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png').addTo(map);
        const googleSat = L.tileLayer('https://{s}.google.com/vt/lyrs=s&x={x}&y={y}&z={z}', {
            subdomains: ['mt0', 'mt1', 'mt2', 'mt3'],
            attribution: 'Google Satellite'
        });
        const googleHybrid = L.tileLayer('https://{s}.google.com/vt/lyrs=y&x={x}&y={y}&z={z}', {
            subdomains: ['mt0', 'mt1', 'mt2', 'mt3'],
            attribution: 'Google Hybrid'
        });

        const rdtrGroup = L.layerGroup().addTo(map);
        const rtrwGroup = L.layerGroup();

        // Layer Control
        const baseMaps = {
            "Peta Standar (OSM)": osm,
            "Satelit": googleSat,
            "Hibrida (Satelit & Jalan)": googleHybrid
        };
        const overlayMaps = {
            "Zona RDTR": rdtrGroup,
            "Kawasan RTRW": rtrwGroup
        };
        L.control.layers(baseMaps, overlayMaps, { position: 'bottomleft' }).addTo(map);

        // Helper to get API URL safely
        function getApiUrl(path) {
            const base = baseUrl.endsWith('/') ? baseUrl.slice(0, -1) : baseUrl;
            const p = path.startsWith('/') ? path : '/' + path;
            return base + p;
        }

        // Layer loading
        $.get(getApiUrl('/api/spatial/layers'), function (res) {
            if (res.status) {
                if (res.data.rdtr) L.geoJSON(res.data.rdtr, {
                    style: function (f) { return { color: '#fff', weight: 2, dashArray: '5,5', fillColor: f.properties.color, fillOpacity: 0.5 }; },
                    onEachFeature: function (f, l) {
                        l.on('click', function (e) {
                            L.DomEvent.stopPropagation(e);
                            checkPoint(e.latlng.lat, e.latlng.lng, 'rdtr');
                        });
                    }
                }).addTo(rdtrGroup);
                if (res.data.rtrw) L.geoJSON(res.data.rtrw, {
                    style: function (f) { return { color: '#fff', weight: 2, dashArray: '10,10', fillColor: f.properties.color, fillOpacity: 0.2 }; },
                    onEachFeature: function (f, l) {
                        l.on('click', function (e) {
                            L.DomEvent.stopPropagation(e);
                            checkPoint(e.latlng.lat, e.latlng.lng, 'rtrw');
                        });
                    }
                }).addTo(rtrwGroup);
            }
        });

        let marker;
        map.on('click', function (e) { checkPoint(e.latlng.lat, e.latlng.lng); });
        $('#btn-search-coord').click(function () {
            const lat = parseFloat($('#input-lat').val()), lng = parseFloat($('#input-lng').val());
            if (!isNaN(lat) && !isNaN(lng)) checkPoint(lat, lng);
        });

        function checkPoint(lat, lng, forced) {
            if (marker) map.removeLayer(marker);
            marker = L.marker([lat, lng]).addTo(map);
            map.flyTo([lat, lng], 16, {
                animate: true,
                duration: 1.5
            });
            $('#input-lat').val(lat.toFixed(6)); $('#input-lng').val(lng.toFixed(6));
            $('.floating-panel').css('display', 'flex').hide().fadeIn(400);

            // Auto-scroll to Data Spasial panel on mobile after zoom completes
            if (window.innerWidth <= 991) {
                setTimeout(function () {
                    const panel = document.querySelector('.floating-panel');
                    if (panel) {
                        panel.scrollIntoView({ behavior: 'smooth', block: 'start' });
                    }
                }, 1600); // Wait for flyTo animation (1500ms) + small buffer
            }

            $.post(baseUrl + '/api/spatial/check', { lat, lng }, function (res) {
                if (res.status) {
                    $('#result-container').show();
                    $('#res-coord').text(lat.toFixed(6) + ', ' + lng.toFixed(6));

                    if (res.data.rdtr && forced !== 'rtrw') {
                        $('#section-rdtr').show();
                        const d = res.data.rdtr;
                        const itbx = d.itbx || {};
                        $('#res-rdtr').html(
                            '<div class="result-card p-4">' +
                            '<div class="h5 fw-800 text-primary mb-1">' + d.nama_zona + '</div>' +
                            '<div class="small fw-700 text-muted mb-3">' + (d.sub_zona || d.peruntukan) + '</div>' +
                            '<div class="data-row"><span class="data-label">KDB / KLB</span><span class="data-value">' + (itbx.kdb || 0) + '% / ' + (itbx.klb || 0) + '</span></div>' +
                            '<div class="data-row"><span class="data-label">GSB / GSL</span><span class="data-value">' + (itbx.gsb || 0) + 'm / ' + (itbx.gsl || 0) + 'm</span></div>' +
                            '<button class="btn btn-portal btn-activity-detail w-100 mt-3 py-2" data-id="' + d.id + '" data-name="' + d.nama_zona + '" data-desc="' + (d.sub_zona || d.peruntukan) + '">' +
                            '<i class="bi bi-list-stars me-2"></i> RINCIAN KEGIATAN' +
                            '</button>' +
                            '</div>'
                        );
                    } else $('#section-rdtr').hide();

                    if (res.data.rtrw && forced !== 'rdtr') {
                        $('#section-rtrw').show();
                        const d = res.data.rtrw;
                        $('#res-rtrw').html('<div class="result-card p-4" style="border-left: 6px solid var(--accent);"><div class="h6 fw-800 mb-1">' + d.nama_kawasan + '</div><p class="small text-muted mb-0">' + d.fungsi_kawasan + '</p></div>');
                    } else $('#section-rtrw').hide();
                }
            });
        }

        // KBLI Validation
        $('#btn-validate-kbli').click(function () {
            const code = $('#kbli-code').val();
            const lat = $('#input-lat').val(), lng = $('#input-lng').val();
            if (!code) return;
            $('#kbli-result').html('<div class="text-center p-3 text-muted">Menganalisis...</div>');
            $.post(getApiUrl('/api/spatial/validate-kbli'), { kbli_code: code, lat, lng }, function (res) {
                if (res.status) {
                    const d = res.data;
                    const statusClass = d.allowed ? 'bg-success' : 'bg-danger';
                    const icon = d.allowed ? 'bi-check-circle-fill' : 'bi-x-circle-fill';
                    $('#kbli-result').html(
                        '<div class="p-4 mt-3 rounded-4 ' + statusClass + ' text-white shadow-sm" style="animation: slideUp 0.4s ease;">' +
                        '<div class="d-flex align-items-center mb-2">' +
                        '<i class="bi ' + icon + ' fs-4 me-3"></i>' +
                        '<div class="fw-800">' + (d.allowed ? 'DIIZINKAN' : 'TIDAK DIIZINKAN') + '</div>' +
                        '</div>' +
                        '<div class="small fw-600 opacity-90">' + d.validation_message + '</div>' +
                        '</div>'
                    );
                } else {
                    $('#kbli-result').html('<div class="p-3 mt-3 rounded-4 bg-light text-muted fw-700 text-center">' + (res.message || 'KBLI Tidak Ditemukan') + '</div>');
                }
            });
        });
    });

    // Event delegation for dynamically created activity detail button
    $(document).on('click', '.btn-activity-detail', function () {
        const id = $(this).data('id');
        const name = $(this).data('name');
        const desc = $(this).data('desc');
        loadActivities(id, name, desc);
    });

    function loadActivities(id, name, desc) {
        $('#activity-zone-name').text(name);
        $('#activity-zone-desc').text(desc);
        const modal = new bootstrap.Modal(document.getElementById('activityModal'));
        const apiUrl = (baseUrl.endsWith('/') ? baseUrl.slice(0, -1) : baseUrl) + '/api/rdtr/zone/' + id + '/activities';

        $.get(apiUrl, function (res) {
            if (res.status) {
                let listI = '', listT = '', listB = '', listX = '';

                if (res.data.diizinkan) {
                    res.data.diizinkan.forEach(function (a) {
                        listI += '<div class="mb-2 p-3 bg-white border border-success border-opacity-10 rounded-3 shadow-sm"><div class="small fw-800 text-success mb-1">DIIZINKAN</div><div class="small fw-700 text-dark">' + a.nama_kegiatan + '</div></div>';
                    });
                }

                if (res.data.terbatas) {
                    res.data.terbatas.forEach(function (a) {
                        listT += '<div class="mb-2 p-3 bg-white border border-warning border-opacity-10 rounded-3 shadow-sm"><div class="small fw-800 text-warning mb-1">TERBATAS</div><div class="small fw-700 text-dark">' + a.nama_kegiatan + '</div><div class="mt-2 p-2 bg-light rounded small text-muted">' + (a.keterangan || 'Lihat aturan zonasi standar.') + '</div></div>';
                    });
                }

                if (res.data.bersyarat) {
                    res.data.bersyarat.forEach(function (a) {
                        listB += '<div class="mb-2 p-3 bg-white border border-primary border-opacity-10 rounded-3 shadow-sm"><div class="small fw-800 text-primary mb-1">BERSYARAT</div><div class="small fw-700 text-dark">' + a.nama_kegiatan + '</div><div class="mt-2 p-2 bg-light rounded small text-muted">Syarat: ' + (a.syarat || '-') + '</div></div>';
                    });
                }

                if (res.data.dilarang) {
                    res.data.dilarang.forEach(function (a) {
                        listX += '<div class="mb-2 p-3 bg-white border border-danger border-opacity-10 rounded-3 shadow-sm"><div class="small fw-800 text-danger mb-1">DILARANG</div><div class="small fw-700 text-dark">' + a.nama_kegiatan + '</div></div>';
                    });
                }

                $('#list-diizinkan').html(listI || '<div class="text-muted small p-3">Tidak ada data kegiatan diizinkan.</div>');
                $('#list-terbatas').html(listT || '<div class="text-muted small p-3">Tidak ada data kegiatan terbatas.</div>');
                $('#list-bersyarat').html(listB || '<div class="text-muted small p-3">Tidak ada data kegiatan bersyarat.</div>');
                $('#list-dilarang').html(listX || '<div class="text-muted small p-3">Tidak ada data kegiatan dilarang.</div>');
                modal.show();
            }
        });
    }
</script>
<?php $this->endSection()?>