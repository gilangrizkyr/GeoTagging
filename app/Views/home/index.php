<?php $this->extend('layouts/main') ?>

<?php $this->section('styles') ?>
<style>
    /* ===== HOME PAGE ===== */
    .home-page-container {
        max-width: 1400px;
        margin: 0 auto;
        width: 100%;
        padding-bottom: 40px;
    }

    /* --- Hero --- */
    .hero-section {
        background: linear-gradient(135deg, rgba(30, 60, 114, 0.08) 0%, rgba(42, 82, 152, 0.06) 100%);
        border-radius: 20px;
        padding: 36px 32px;
        margin-bottom: 32px;
        border: 1px solid rgba(255, 255, 255, 0.4);
        backdrop-filter: blur(10px);
    }

    .hero-section h1 {
        font-size: 2.4rem;
        font-weight: 900;
        background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        line-height: 1.2;
        margin-bottom: 10px;
    }

    .hero-section p {
        font-size: 1rem;
        color: #64748b;
        font-weight: 600;
        margin: 0;
    }

    /* --- Stat Cards --- */
    .stat-card {
        background: linear-gradient(135deg, rgba(255,255,255,0.95) 0%, rgba(255,255,255,0.85) 100%);
        border-radius: 16px;
        padding: 24px 20px;
        border: 1px solid rgba(255, 255, 255, 0.7);
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.07);
        transition: all 0.35s cubic-bezier(0.34, 1.56, 0.64, 1);
        backdrop-filter: blur(10px);
        height: 100%;
        display: flex;
        flex-direction: column;
    }

    .stat-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 16px 40px rgba(0, 0, 0, 0.11);
        border-color: rgba(30, 60, 114, 0.15);
    }

    .stat-icon {
        width: 56px;
        height: 56px;
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.7rem;
        margin-bottom: 16px;
        flex-shrink: 0;
    }

    .stat-icon.rdtr  { background: linear-gradient(135deg, rgba(30,60,114,0.15), rgba(42,82,152,0.08)); color: #1e3c72; }
    .stat-icon.rtrw  { background: linear-gradient(135deg, rgba(245,158,11,0.15), rgba(245,158,11,0.08)); color: #f59e0b; }
    .stat-icon.search{ background: linear-gradient(135deg, rgba(39,174,96,0.15), rgba(39,174,96,0.08)); color: #27ae60; }
    .stat-icon.avg   { background: linear-gradient(135deg, rgba(99,102,241,0.15), rgba(99,102,241,0.08)); color: #6366f1; }

    .stat-number {
        font-size: 2rem;
        font-weight: 900;
        background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        line-height: 1;
        margin-bottom: 6px;
    }

    .stat-label {
        font-size: 0.9rem;
        font-weight: 700;
        color: #334155;
        margin-bottom: 4px;
    }

    .stat-sub {
        font-size: 0.78rem;
        color: #94a3b8;
        font-weight: 500;
        margin-top: auto;
    }

    /* --- Content Cards --- */
    .content-card {
        background: linear-gradient(135deg, rgba(255,255,255,0.95) 0%, rgba(255,255,255,0.85) 100%);
        border-radius: 18px;
        padding: 26px 24px;
        border: 1px solid rgba(255, 255, 255, 0.7);
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.07);
        backdrop-filter: blur(10px);
        transition: box-shadow 0.3s ease;
        height: 100%;
    }

    .content-card:hover {
        box-shadow: 0 14px 40px rgba(0, 0, 0, 0.1);
    }

    .section-title {
        font-size: 1.1rem;
        font-weight: 800;
        color: #1e293b;
        margin-bottom: 20px;
        display: flex;
        align-items: center;
        gap: 10px;
        padding-bottom: 14px;
        border-bottom: 2px solid rgba(30, 60, 114, 0.08);
    }

    .section-title i {
        font-size: 1.1rem;
        color: #1e3c72;
        background: rgba(30,60,114,0.1);
        width: 34px;
        height: 34px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    /* --- Peruntukan List --- */
    .peruntukan-item {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 10px 0;
        border-bottom: 1px solid rgba(0, 0, 0, 0.04);
    }

    .peruntukan-item:last-child { border-bottom: none; }

    .peruntukan-rank {
        width: 26px;
        height: 26px;
        border-radius: 8px;
        background: rgba(30, 60, 114, 0.1);
        color: #1e3c72;
        font-size: 0.75rem;
        font-weight: 800;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    .peruntukan-name {
        flex: 1;
        font-size: 0.85rem;
        font-weight: 600;
        color: #334155;
        min-width: 0;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .peruntukan-count {
        font-weight: 800;
        color: #1e3c72;
        font-size: 1rem;
        flex-shrink: 0;
    }

    .progress-bar-custom {
        height: 6px;
        border-radius: 6px;
        background: rgba(0, 0, 0, 0.05);
        overflow: hidden;
        margin-top: 4px;
    }

    .progress-bar-custom .bar {
        height: 100%;
        background: linear-gradient(90deg, #1e3c72 0%, #2a5298 60%, #3b82f6 100%);
        border-radius: 6px;
        transition: width 0.6s ease;
    }

    /* --- Chart --- */
    .chart-container {
        position: relative;
        height: 260px;
    }

    /* --- Info Tiles --- */
    .info-tile {
        border-radius: 14px;
        padding: 20px 16px;
        text-align: center;
        transition: transform 0.3s ease;
    }

    .info-tile:hover { transform: translateY(-3px); }

    .info-tile .tile-number {
        font-size: 1.8rem;
        font-weight: 900;
        line-height: 1;
        margin-bottom: 6px;
    }

    .info-tile .tile-label {
        font-size: 0.78rem;
        font-weight: 600;
        color: #64748b;
    }

    /* --- Quick Links --- */
    .quick-link {
        display: flex;
        align-items: center;
        gap: 14px;
        padding: 14px 16px;
        border-radius: 12px;
        background: rgba(30, 60, 114, 0.04);
        border: 1px solid rgba(30, 60, 114, 0.08);
        text-decoration: none;
        color: #1e293b;
        transition: all 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
        margin-bottom: 10px;
    }

    .quick-link:last-child { margin-bottom: 0; }

    .quick-link:hover {
        background: rgba(30, 60, 114, 0.1);
        border-color: rgba(30, 60, 114, 0.2);
        transform: translateX(4px);
        color: #1e3c72;
    }

    .quick-link-icon {
        width: 40px;
        height: 40px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.2rem;
        flex-shrink: 0;
    }

    .quick-link-text strong {
        display: block;
        font-size: 0.88rem;
        font-weight: 700;
    }

    .quick-link-text small {
        font-size: 0.75rem;
        color: #94a3b8;
    }

    /* --- CTA --- */
    .cta-section {
        background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
        border-radius: 18px;
        padding: 36px 28px;
        text-align: center;
        color: white;
        margin-top: 32px;
        box-shadow: 0 16px 40px rgba(30, 60, 114, 0.25);
    }

    .cta-section h2 {
        font-size: 1.7rem;
        font-weight: 900;
        margin-bottom: 10px;
    }

    .cta-section p {
        font-size: 0.95rem;
        margin-bottom: 22px;
        opacity: 0.9;
    }

    .btn-explore {
        background: white;
        color: #1e3c72;
        padding: 13px 36px;
        border-radius: 10px;
        font-weight: 800;
        border: none;
        transition: all 0.35s cubic-bezier(0.34, 1.56, 0.64, 1);
        display: inline-block;
        text-decoration: none;
        font-size: 0.95rem;
    }

    .btn-explore:hover {
        transform: translateY(-3px) scale(1.04);
        box-shadow: 0 12px 32px rgba(0, 0, 0, 0.2);
        color: #1e3c72;
    }

    .empty-state {
        text-align: center;
        padding: 36px 20px;
        color: #94a3b8;
    }

    .empty-state i {
        font-size: 2.5rem;
        color: #cbd5e1;
        display: block;
        margin-bottom: 12px;
    }

    /* --- Responsive --- */
    @media (max-width: 991px) {
        .hero-section { padding: 28px 20px; margin-bottom: 24px; }
        .hero-section h1 { font-size: 1.8rem; }
        .stat-card { padding: 20px 16px; }
        .stat-number { font-size: 1.7rem; }
        .stat-icon { width: 48px; height: 48px; font-size: 1.5rem; }
        .content-card { padding: 20px 18px; }
        .cta-section { padding: 28px 20px; }
        .cta-section h2 { font-size: 1.4rem; }
    }

    @media (max-width: 576px) {
        .hero-section { padding: 20px 16px; margin-bottom: 20px; }
        .hero-section h1 { font-size: 1.4rem; }
        .hero-section p { font-size: 0.85rem; }
        .stat-number { font-size: 1.4rem; }
        .stat-icon { width: 44px; height: 44px; font-size: 1.3rem; margin-bottom: 12px; }
        .content-card { padding: 16px 14px; }
        .section-title { font-size: 0.95rem; }
        .chart-container { height: 220px; }
        .cta-section { padding: 24px 16px; margin-top: 24px; }
        .cta-section h2 { font-size: 1.15rem; }
        .btn-explore { padding: 11px 28px; font-size: 0.88rem; }
    }
</style>
<?php $this->endSection() ?>

<?php $this->section('content') ?>

<div class="home-page-container">

    <!-- Hero -->
    <div class="hero-section">
        <h1>Selamat Datang di GeoTagging</h1>
        <p>Sistem Informasi Geografis Tata Ruang Tanah Bumbu &mdash; Analisis spasial untuk investasi yang transparan</p>
    </div>

    <!-- Stat Cards Row -->
    <div class="row g-3 mb-4">
        <div class="col-6 col-lg-3">
            <div class="stat-card">
                <div class="stat-icon rdtr"><i class="bi bi-grid-3x3-gap-fill"></i></div>
                <div class="stat-number"><?= number_format($totalRdtr) ?></div>
                <div class="stat-label">Zona RDTR</div>
                <div class="stat-sub">Rencana Detail Tata Ruang</div>
            </div>
        </div>
        <div class="col-6 col-lg-3">
            <div class="stat-card">
                <div class="stat-icon rtrw"><i class="bi bi-map-fill"></i></div>
                <div class="stat-number"><?= number_format($totalRtrw) ?></div>
                <div class="stat-label">Kawasan RTRW</div>
                <div class="stat-sub">Rencana Tata Ruang Wilayah</div>
            </div>
        </div>
        <div class="col-6 col-lg-3">
            <div class="stat-card">
                <div class="stat-icon search"><i class="bi bi-search"></i></div>
                <div class="stat-number"><?= number_format($totalSearches) ?></div>
                <div class="stat-label">Total Pencarian</div>
                <div class="stat-sub">Analisis spasial dilakukan</div>
            </div>
        </div>
        <div class="col-6 col-lg-3">
            <div class="stat-card">
                <div class="stat-icon avg"><i class="bi bi-graph-up-arrow"></i></div>
                <div class="stat-number"><?= $avgSearchesPerDay ?></div>
                <div class="stat-label">Pencarian / Hari</div>
                <div class="stat-sub">Rata-rata 7 hari terakhir</div>
            </div>
        </div>
    </div>

    <!-- Main Content: 2 Columns -->
    <div class="row g-4 align-items-stretch">

        <!-- LEFT: Top Peruntukan + Chart -->
        <div class="col-12 col-lg-7 d-flex flex-column gap-4">

            <!-- Top Peruntukan -->
            <div class="content-card">
                <div class="section-title">
                    <i class="bi bi-bar-chart-fill"></i> Top Peruntukan Zona
                </div>

                <?php if (!empty($topPeruntukan)): ?>
                    <?php $maxCount = max(array_column($topPeruntukan, 'jumlah')); ?>
                    <div class="peruntukan-list">
                        <?php foreach ($topPeruntukan as $idx => $item):
                            $percentage = ($item['jumlah'] / $maxCount) * 100;
                        ?>
                            <div class="peruntukan-item">
                                <div class="peruntukan-rank"><?= $idx + 1 ?></div>
                                <div class="flex-fill min-width-0">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span class="peruntukan-name"><?= esc($item['peruntukan']) ?></span>
                                        <span class="peruntukan-count ms-2"><?= number_format($item['jumlah']) ?></span>
                                    </div>
                                    <div class="progress-bar-custom mt-1">
                                        <div class="bar" style="width: <?= $percentage ?>%"></div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <div class="empty-state">
                        <i class="bi bi-info-circle"></i>
                        <p>Belum ada data peruntukan zona</p>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Distribusi Chart -->
            <div class="content-card">
                <div class="section-title">
                    <i class="bi bi-pie-chart-fill"></i> Distribusi Zona RDTR
                </div>
                <div class="chart-container">
                    <canvas id="peruntukkanChart"></canvas>
                </div>
            </div>

        </div>

        <!-- RIGHT: Info + Quick Links -->
        <div class="col-12 col-lg-5 d-flex flex-column gap-4">

            <!-- Info Tiles -->
            <div class="content-card">
                <div class="section-title">
                    <i class="bi bi-info-circle-fill"></i> Ringkasan Data
                </div>
                <div class="row g-3">
                    <div class="col-6">
                        <div class="info-tile" style="background: rgba(30,60,114,0.07);">
                            <div class="tile-number" style="color: #1e3c72;"><?= number_format($totalRdtr / max(1, $totalRtrw), 2) ?></div>
                            <div class="tile-label">Rasio RDTR : RTRW</div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="info-tile" style="background: rgba(245,158,11,0.08);">
                            <div class="tile-number" style="color: #f59e0b;"><?= count($rdtrByPeruntukan) ?></div>
                            <div class="tile-label">Jenis Peruntukan</div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="info-tile" style="background: rgba(39,174,96,0.08);">
                            <div class="tile-number" style="color: #27ae60;"><?= number_format($totalSearches) ?></div>
                            <div class="tile-label">Total Analisis</div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="info-tile" style="background: rgba(99,102,241,0.08);">
                            <div class="tile-number" style="color: #6366f1;"><?= $avgSearchesPerDay ?></div>
                            <div class="tile-label">Avg. / Hari</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Links -->
            <div class="content-card">
                <div class="section-title">
                    <i class="bi bi-lightning-charge-fill"></i> Akses Cepat
                </div>

                <a href="<?= base_url('map') ?>" class="quick-link">
                    <div class="quick-link-icon" style="background: rgba(30,60,114,0.12); color: #1e3c72;">
                        <i class="bi bi-map-fill"></i>
                    </div>
                    <div class="quick-link-text">
                        <strong>Peta Interaktif</strong>
                        <small>Klik koordinat untuk analisis tata ruang</small>
                    </div>
                    <i class="bi bi-chevron-right ms-auto text-muted"></i>
                </a>

                <a href="<?= base_url('map') ?>?layer=rdtr" class="quick-link">
                    <div class="quick-link-icon" style="background: rgba(99,102,241,0.12); color: #6366f1;">
                        <i class="bi bi-grid-3x3-gap-fill"></i>
                    </div>
                    <div class="quick-link-text">
                        <strong>Layer RDTR</strong>
                        <small>Lihat zona rencana detail tata ruang</small>
                    </div>
                    <i class="bi bi-chevron-right ms-auto text-muted"></i>
                </a>

                <a href="<?= base_url('map') ?>?layer=rtrw" class="quick-link">
                    <div class="quick-link-icon" style="background: rgba(245,158,11,0.12); color: #f59e0b;">
                        <i class="bi bi-layers-fill"></i>
                    </div>
                    <div class="quick-link-text">
                        <strong>Layer RTRW</strong>
                        <small>Lihat kawasan tata ruang wilayah</small>
                    </div>
                    <i class="bi bi-chevron-right ms-auto text-muted"></i>
                </a>

                <a href="<?= base_url('auth/login') ?>" class="quick-link">
                    <div class="quick-link-icon" style="background: rgba(39,174,96,0.12); color: #27ae60;">
                        <i class="bi bi-shield-lock-fill"></i>
                    </div>
                    <div class="quick-link-text">
                        <strong>Portal Petugas</strong>
                        <small>Login ke dashboard admin</small>
                    </div>
                    <i class="bi bi-chevron-right ms-auto text-muted"></i>
                </a>
            </div>

        </div>

    </div>

    <!-- CTA -->
    <div class="cta-section">
        <h2>🗺️ Mulai Analisis Spasial Anda</h2>
        <p>Klik di peta untuk mendapatkan informasi detail tentang zona, regulasi, dan aktivitas usaha yang diperbolehkan</p>
        <a href="<?= base_url('map') ?>" class="btn-explore">
            <i class="bi bi-map me-2"></i> Buka Peta Interaktif
        </a>
    </div>

</div>

<?php $this->endSection() ?>

<?php $this->section('scripts') ?>
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
    const peruntukkanChartCanvas = document.getElementById('peruntukkanChart');
    if (peruntukkanChartCanvas && <?= !empty($rdtrByPeruntukan) ? 'true' : 'false' ?>) {
        const ctx = peruntukkanChartCanvas.getContext('2d');

        const labels = [
            <?php foreach ($rdtrByPeruntukan as $item): ?>
                '<?= addslashes(mb_substr($item['peruntukan'], 0, 18) . (mb_strlen($item['peruntukan']) > 18 ? '…' : '')) ?>',
            <?php endforeach; ?>
        ];

        const data = [
            <?php foreach ($rdtrByPeruntukan as $item): ?>
                <?= $item['count'] ?>,
            <?php endforeach; ?>
        ];

        const colors = [
            '#1e3c72', '#2a5298', '#3b82f6', '#06b6d4',
            '#10b981', '#f59e0b', '#ef4444', '#8b5cf6'
        ];

        new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: labels,
                datasets: [{
                    data: data,
                    backgroundColor: colors.slice(0, labels.length),
                    borderColor: 'rgba(255,255,255,0.6)',
                    borderWidth: 3,
                    hoverOffset: 8,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutout: '60%',
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            font: { size: 11, weight: 'bold' },
                            color: '#64748b',
                            padding: 14,
                            usePointStyle: true,
                            pointStyleWidth: 8,
                        }
                    }
                }
            }
        });
    }
</script>
<?php $this->endSection() ?>