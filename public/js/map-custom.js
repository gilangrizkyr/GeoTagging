$(document).ready(function () {
    // Welcome / intro behavior
    if (localStorage.getItem('introSeen')) {
        $('#welcome-section').hide();
    }
    $('#btn-open-map').click(function () {
        localStorage.setItem('introSeen', '1');
        $('#welcome-section').fadeOut(400);
        $('html, body').animate({ scrollTop: $('.map-content-wrapper').offset().top }, 600);
    });

    // Panel Logic
    $('#btn-close-panel').click(function () { $('.floating-panel').fadeOut(300); });
    // Disclaimer Logic
    const discModal = new bootstrap.Modal(document.getElementById('disclaimerModal'), { backdrop: 'static', keyboard: false });
    discModal.show();
    $('#agreeCheck').change(function () { $('#btnAgree').prop('disabled', !this.checked); });
    $('#btnAgree').click(function () { discModal.hide(); });

    // Map Setup
    // Map center is passed via mapConfig global variable
    const map = L.map('map', { zoomControl: false, attributionControl: false }).setView([mapConfig.lat, mapConfig.lng], 12);

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
