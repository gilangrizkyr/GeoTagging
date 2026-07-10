$(document).ready(function () {
    // Global AJAX setup for CSRF
    const csrfToken = $('meta[name="csrf-token"]').attr('content');
    const csrfHeader = $('meta[name="csrf-header"]').attr('content') || 'X-CSRF-TOKEN';

    $.ajaxSetup({
        headers: {
            [csrfHeader]: csrfToken,
            'X-Requested-With': 'XMLHttpRequest'
        }
    });

    // Welcome / intro behavior
    const isRedirected = mapConfig.initialLayer && mapConfig.initialLayer !== 'rdtr';
    if (localStorage.getItem('introSeen') || isRedirected) {
        $('#welcome-section').hide();
    }
    $('#btn-open-map').click(function () {
        localStorage.setItem('introSeen', '1');
        $('#welcome-section').fadeOut(400);
        $('html, body').animate({ scrollTop: $('.map-content-wrapper').offset().top }, 600);
    });

    // Panel Logic
    $('#btn-close-panel').click(function () {
        $('.floating-panel').fadeOut(300, function () {
            if (typeof map !== 'undefined') map.invalidateSize();
        });
    });

    // Disclaimer Logic
    const discModalElement = document.getElementById('disclaimerModal');
    if (discModalElement) {
        const discModal = new bootstrap.Modal(discModalElement, { backdrop: 'static', keyboard: false });
        discModal.show();
        $('#agreeCheck').change(function () { $('#btnAgree').prop('disabled', !this.checked); });
        $('#btnAgree').click(function () { discModal.hide(); });
    }

    // Geolocation Support (Locate Me)
    $('#btn-locate-me').click(function () {
        const btn = $(this);
        const icon = btn.find('i');
        if (!navigator.geolocation) {
            alert('Browser Anda tidak mendukung geolokasi.');
            return;
        }
        icon.removeClass('bi-crosshair2').addClass('bi-arrow-repeat pulse');
        btn.prop('disabled', true);

        navigator.geolocation.getCurrentPosition(function (position) {
            const lat = position.coords.latitude;
            const lng = position.coords.longitude;
            const accuracy = position.coords.accuracy;

            if (accuCircle) map.removeLayer(accuCircle);
            accuCircle = L.circle([lat, lng], {
                radius: accuracy, color: '#1e3c72', fillColor: '#1e3c72', fillOpacity: 0.1, weight: 1, dashArray: '5, 5'
            }).addTo(map);

            map.flyTo([lat, lng], 18, { duration: 1.5 });
            checkPoint(lat, lng);

            let accuracyMsg = 'Akurasi lokasi: ±' + Math.round(accuracy) + ' meter.';
            setTimeout(() => {
                icon.removeClass('bi-arrow-repeat pulse').addClass('bi-crosshair2');
                btn.prop('disabled', false);
                if ($('#geo-toast').length === 0) {
                    $('body').append('<div id="geo-toast" style="position:fixed; bottom:20px; left:50%; transform:translateX(-50%); z-index:9999; background:rgba(0,0,0,0.8); color:white; padding:10px 20px; border-radius:30px; font-size:0.8rem; pointer-events:none; display:none;"></div>');
                }
                $('#geo-toast').text(accuracyMsg).fadeIn().delay(3000).fadeOut();
            }, 2000);
        }, function (error) {
            icon.removeClass('bi-arrow-repeat pulse').addClass('bi-crosshair2');
            btn.prop('disabled', false);
            alert('Gagal mendapatkan lokasi: ' + error.message);
        }, { enableHighAccuracy: true, timeout: 10000, maximumAge: 0 });
    });

    // Map Setup
    const map = L.map('map', { zoomControl: false, attributionControl: false }).setView([mapConfig.lat, mapConfig.lng], 12);
    L.control.zoom({ position: 'bottomright' }).addTo(map);
    L.control.fullscreen({ position: 'bottomright' }).addTo(map);

    // Basemaps
    const osm = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', { maxZoom: 19 }).addTo(map);
    const esriImagery = L.tileLayer('https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}', { maxZoom: 19 });
    const cartoDark = L.tileLayer('https://{s}.basemaps.cartocdn.com/dark_all/{z}/{x}/{y}{r}.png', { subdomains: 'abcd', maxZoom: 19 });

    const rdtrGroup = L.layerGroup();
    const rtrwGroup = L.layerGroup();

    if (mapConfig.initialLayer === 'rtrw') rtrwGroup.addTo(map);
    else rdtrGroup.addTo(map);

    const baseMaps = { "OSM": osm, "Satelit": esriImagery, "Dark": cartoDark };
    const overlayMaps = { "Zona RDTR": rdtrGroup, "Kawasan RTRW": rtrwGroup };
    L.control.layers(baseMaps, overlayMaps, { position: 'topright' }).addTo(map);

    function getApiUrl(path) {
        const base = baseUrl.endsWith('/') ? baseUrl.slice(0, -1) : baseUrl;
        const p = path.startsWith('/') ? path : '/' + path;
        return base + p;
    }

    // Load GeoJSON Layers
    $.get(getApiUrl('/api/spatial/layers'), function (res) {
        if (res.status) {
            if (res.data.rdtr) L.geoJSON(res.data.rdtr, {
                style: function (f) { return { color: '#fff', weight: 2, dashArray: '5,5', fillColor: f.properties.color, fillOpacity: 0.5 }; },
                onEachFeature: function (f, l) { l.on('click', function (e) { L.DomEvent.stopPropagation(e); checkPoint(e.latlng.lat, e.latlng.lng, 'rdtr'); }); }
            }).addTo(rdtrGroup);
            if (res.data.rtrw) L.geoJSON(res.data.rtrw, {
                style: function (f) { return { color: '#fff', weight: 2, dashArray: '10,10', fillColor: f.properties.color, fillOpacity: 0.2 }; },
                onEachFeature: function (f, l) { l.on('click', function (e) { L.DomEvent.stopPropagation(e); checkPoint(e.latlng.lat, e.latlng.lng, 'rtrw'); }); }
            }).addTo(rtrwGroup);
        }
    });

    $.get(getApiUrl('/json/boundary.geojson'), function (res) {
        L.geoJSON(res, {
            // style: {
            //     color: '#6366f1',
            // }
            style : {
                color: '#3665be',
                weight: 2,
                dashArray: '6, 6',
                fillOpacity: 0,
                interactive: false
            }
        }).addTo(map);
    });

    let marker, accuCircle;
    map.on('click', function (e) { checkPoint(e.latlng.lat, e.latlng.lng); });
    $('#btn-search-coord').click(function () {
        const lat = parseFloat($('#input-lat').val()), lng = parseFloat($('#input-lng').val());
        if (!isNaN(lat) && !isNaN(lng)) checkPoint(lat, lng);
    });

    function checkPoint(lat, lng, forced) {
        if (marker) map.removeLayer(marker);
        marker = L.marker([lat, lng]).addTo(map);

        const displayMode = window.innerWidth >= 992 ? 'flex' : 'block';

        // Show panel immediately (opacity 0) to trigger layout change, then invalidate map size
        const panel = $('.floating-panel');
        const isNewPanel = panel.css('display') === 'none';

        if (isNewPanel) {
            panel.css({ display: displayMode, opacity: 0 }).animate({ opacity: 1 }, 500);
            if (typeof map !== 'undefined') map.invalidateSize();
        }

        // Smoother flyTo animation
        map.flyTo([lat, lng], 15, {
            animate: true,
            duration: 1.8,
            easeLinearity: 0.25
        });

        $('#input-lat').val(lat.toFixed(6)); $('#input-lng').val(lng.toFixed(6));

        if (window.innerWidth < 992) {
            $('html, body').animate({ scrollTop: $(".floating-panel").offset().top - 20 }, 800);
        }

        // Perform Spatial Analysis API Call
        $.post(getApiUrl('/api/spatial/check'), { lat: lat, lng: lng }, function (res) {
            if (res.status) {
                $('#result-container').show();
                $('#res-coord').text(lat.toFixed(6) + ', ' + lng.toFixed(6));

                // Clear previous badges
                $('#result-container .badge').remove();

                if (res.data.match_type === 'proximity') {
                    $('#res-coord').after('<div class="badge bg-warning text-dark fw-800 mb-3 px-3 py-2 rounded-pill" style="font-size: 0.7rem;"><i class="bi bi-exclamation-circle-fill me-1"></i> DATA INDIKATIF (PROKSIMITAS)</div>');
                } else {
                    $('#res-coord').after('<div class="badge bg-success text-white fw-800 mb-3 px-3 py-2 rounded-pill" style="font-size: 0.7rem;"><i class="bi bi-patch-check-fill me-1"></i> DATA AKURAT (ZONASI TEPAT)</div>');
                }

                if (res.data.rdtr && forced !== 'rtrw') {
                    $('#section-rdtr').show();
                    const d = res.data.rdtr;
                    const itbx = d.itbx || {};
                    $('#res-rdtr').html(`
                        <div class="result-card p-4">
                            <div class="h5 fw-800 text-primary mb-1">${d.nama_zona}</div>
                            <div class="small fw-700 text-muted mb-3">${d.sub_zona || d.peruntukan}</div>
                            <div class="data-row"><span class="data-label">KDB / KLB</span><span class="data-value">${itbx.kdb || 0}% / ${itbx.klb || 0}</span></div>
                            <div class="data-row"><span class="data-label">GSB / GSL</span><span class="data-value">${itbx.gsb || 0}m / ${itbx.gsl || 0}m</span></div>
                            <button class="btn btn-portal btn-activity-detail w-100 mt-3 py-2" data-id="${d.id}" data-name="${d.nama_zona}" data-desc="${d.sub_zona || d.peruntukan}">
                                <i class="bi bi-list-stars me-2"></i> RINCIAN KEGIATAN
                            </button>
                            <button class="btn btn-outline-primary btn-print-report w-100 mt-2 py-2 fw-700" data-url="${baseUrl}/api/spatial/export-analysis?lat=${lat}&lng=${lng}">
                                <i class="bi bi-file-earmark-pdf me-2"></i> UNDUH LAPORAN (PDF)
                            </button>
                        </div>
                    `);
                } else $('#section-rdtr').hide();

                if (res.data.rtrw && forced !== 'rdtr') {
                    $('#section-rtrw').show();
                    const d = res.data.rtrw;
                    $('#res-rtrw').html(`
                        <div class="result-card p-4" style="border-left: 6px solid var(--accent);">
                            <div class="h6 fw-800 mb-1">${d.nama_kawasan}</div>
                            <p class="small text-muted mb-3">${d.fungsi_kawasan}</p>
                            <button class="btn btn-outline-accent btn-print-report w-100 py-2 fw-700" data-url="${baseUrl}/api/spatial/export-analysis?lat=${lat}&lng=${lng}">
                                <i class="bi bi-file-earmark-pdf me-2"></i> UNDUH LAPORAN RTRW
                            </button>
                        </div>
                    `);
                } else $('#section-rtrw').hide();
                initDynamicTooltips();
            }
        });
    }

    // KBLI Logic
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
                $('#kbli-result').html(`
                    <div class="p-4 mt-3 rounded-4 ${statusClass} text-white shadow-sm">
                        <div class="d-flex align-items-center mb-2">
                            <i class="bi ${icon} fs-4 me-3"></i>
                            <div class="fw-800">${d.allowed ? 'DIIZINKAN' : 'TIDAK DIIZINKAN'}</div>
                        </div>
                        <div class="small fw-600 opacity-90">${d.validation_message}</div>
                    </div>
                `);
            } else {
                $('#kbli-result').html('<div class="p-3 mt-3 rounded-4 bg-light text-muted fw-700 text-center">' + (res.message || 'KBLI Tidak Ditemukan') + '</div>');
            }
        });
    });

    $('#kbli-search-input').on('keyup', function () {
        const query = $(this).val().toLowerCase();
        const results = $('#kbli-search-results');
        results.empty();
        if (query.length < 2) return;
        let found = 0;
        for (const [code, name] of Object.entries(KBLI_DATA)) {
            if (code.includes(query) || name.toLowerCase().includes(query)) {
                results.append(`<button type="button" class="list-group-item list-group-item-action p-3 kbli-select-item" data-code="${code}"><div class="fw-800 text-primary">${code}</div><div class="small fw-600">${name}</div></button>`);
                found++;
            }
            if (found >= 20) break;
        }
        if (found === 0) results.append('<div class="p-3 text-muted">KBLI tidak ditemukan.</div>');
    });

    $(document).on('click', '.kbli-select-item', function () {
        const code = $(this).data('code');
        $('#kbli-code').val(code);
        bootstrap.Modal.getInstance(document.getElementById('kbliLookupModal')).hide();
        $('#btn-validate-kbli').click();
    });

    // Activity Details
    $(document).on('click', '.btn-activity-detail', function () {
        const id = $(this).data('id'), name = $(this).data('name'), desc = $(this).data('desc');
        loadActivities(id, name, desc);
    });

    function loadActivities(id, name, desc) {
        $('#activity-zone-name').text(name);
        $('#activity-zone-desc').text(desc);
        const modal = new bootstrap.Modal(document.getElementById('activityModal'));
        $.get(getApiUrl('/api/rdtr/zone/' + id + '/activities'), function (res) {
            if (res.status) {
                let listI = '', listT = '', listB = '', listX = '';
                const format = (a, type, color) => `<div class="mb-2 p-3 bg-white border border-${color} border-opacity-10 rounded-3 shadow-sm"><div class="small fw-800 text-${color} mb-1">${type}</div><div class="small fw-700 text-dark">${a.nama_kegiatan}</div></div>`;
                if (res.data.diizinkan) res.data.diizinkan.forEach(a => listI += format(a, 'DIIZINKAN', 'success'));
                if (res.data.terbatas) res.data.terbatas.forEach(a => listT += format(a, 'TERBATAS', 'warning'));
                if (res.data.bersyarat) res.data.bersyarat.forEach(a => listB += format(a, 'BERSYARAT', 'primary'));
                if (res.data.dilarang) res.data.dilarang.forEach(a => listX += format(a, 'DILARANG', 'danger'));
                $('#list-diizinkan').html(listI || '<div class="text-muted small p-3">Tidak ada data.</div>');
                $('#list-terbatas').html(listT || '<div class="text-muted small p-3">Tidak ada data.</div>');
                $('#list-bersyarat').html(listB || '<div class="text-muted small p-3">Tidak ada data.</div>');
                $('#list-dilarang').html(listX || '<div class="text-muted small p-3">Tidak ada data.</div>');
                modal.show();
            }
        });
    }

    // Print Report
    $(document).on('click', '.btn-print-report', function () {
        let url = $(this).data('url');
        const currentKbli = $('#kbli-code').val() || '';
        if (url.includes('kbli=')) url = url.replace(/kbli=[^&]*/, 'kbli=' + currentKbli);
        else url += '&kbli=' + currentKbli;
        let pFrame = document.getElementById('print-iframe');
        if (!pFrame) { pFrame = document.createElement('iframe'); pFrame.id = 'print-iframe'; pFrame.style.display = 'none'; document.body.appendChild(pFrame); }
        pFrame.src = url;
    });

    function initDynamicTooltips() {
        [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]')).forEach(el => new bootstrap.Tooltip(el));
    }
});
