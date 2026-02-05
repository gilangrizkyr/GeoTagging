<?php /** @var \CodeIgniter\View\View $this */?>
<?php $this->extend('layouts/main')?>

<?php $this->section('content')?>
<?php
$settingsModel = new \App\Models\SettingsModel();
$role = session()->get('role');
$mapLat = $settingsModel->getValueWithRole('map_center_lat', $role, '-3.45');
$mapLng = $settingsModel->getValueWithRole('map_center_lng', $role, 115.97);
?>
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

        <div id="result-container" style="display:none; animation: slideUp 0.5s ease;">
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

<div class="map-frame">
    <div id="map"></div>
</div>

<!-- Disclaimer Modal -->
<div class="modal fade" id="disclaimerModal" tabindex="-1" data-bs-backdrop="static">
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
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 24px;">
            <div class="modal-header border-0 p-4" style="background: var(--grad-primary); color: white;">
                <h5 class="modal-title fw-800"><i class="bi bi-clipboard-data-fill me-2"></i> RINCIAN KEGIATAN ZONA</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-0">
                <div class="p-4 bg-light border-bottom">
                    <div class="h5 fw-800 text-dark mb-1" id="activity-zone-name">-</div>
                    <div class="small text-muted fw-600" id="activity-zone-desc">-</div>
                </div>
                <div class="accordion accordion-flush" id="activityAccordion">
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button fw-800" type="button" data-bs-toggle="collapse"
                                data-bs-target="#col-i">✨ DIIZINKAN (I)</button>
                        </h2>
                        <div id="col-i" class="accordion-collapse collapse show">
                            <div class="accordion-body fw-500" id="list-diizinkan"></div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed fw-800" type="button" data-bs-toggle="collapse"
                                data-bs-target="#col-t">⚠️ TERBATAS (T)</button>
                        </h2>
                        <div id="col-t" class="accordion-collapse collapse">
                            <div class="accordion-body fw-500" id="list-terbatas"></div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed fw-800" type="button" data-bs-toggle="collapse"
                                data-bs-target="#col-b">📝 BERSYARAT (B)</button>
                        </h2>
                        <div id="col-b" class="accordion-collapse collapse">
                            <div class="accordion-body fw-500" id="list-bersyarat"></div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed fw-800 text-danger" type="button"
                                data-bs-toggle="collapse" data-bs-target="#col-x">🚫 DILARANG (X)</button>
                        </h2>
                        <div id="col-x" class="accordion-collapse collapse">
                            <div class="accordion-body fw-500" id="list-dilarang"></div>
                        </div>
                    </div>
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
            transform: translateY(20px);
            opacity: 0;
        }

        to {
            transform: translateY(0);
            opacity: 1;
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
</style>

<?php $this->endSection()?>

<?php $this->section('scripts')?>
<script>
    $(document).ready(function () {
        // Panel Logic
        $('#btn-close-panel').click(function () { $('.floating-panel').fadeOut(300); });
        // Disclaimer Logic
        const discModal = new bootstrap.Modal(document.getElementById('disclaimerModal'));
        discModal.show();
        $('#agreeCheck').change(function () { $('#btnAgree').prop('disabled', !this.checked); });
        $('#btnAgree').click(function () { discModal.hide(); });

        // Map Setup
        const map = L.map('map', { zoomControl: false, attributionControl: false }).setView([<?= $mapLat?>, <?= $mapLng?>], 12);
        L.control.zoom({ position: 'bottomright' }).addTo(map);

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
            $('.floating-panel').fadeIn(400);

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
                            '<button class="btn btn-portal w-100 mt-3 py-2" onclick="loadActivities(' + d.id + ', \'' + d.nama_zona + '\', \'' + (d.sub_zona || d.peruntukan) + '\')">' +
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