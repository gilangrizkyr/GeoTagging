<?php $this->extend('layouts/main') ?>

<?php $this->section('styles') ?>
<style>
    /* ===== PREMIUM HOME PAGE ===== */
    .home-page-wrapper {
        max-width: 1400px;
        /* Synchronized max-width */
        width: 100%;
        margin: 0 auto;
        padding: 40px 0;
        /* No horizontal padding here, use layout padding */
        position: relative;
    }

    /* --- Asymmetric Hero --- */
    .hero-container {
        display: grid;
        grid-template-columns: 0.75fr 1.25fr;
        gap: 40px;
        align-items: center;
        padding: 60px 32px;
        /* Internal content padding - matches navbar 2rem */
        background: rgba(255, 255, 255, 0.45);
        border-radius: 48px;
        border: 1px solid var(--glass-border);
        backdrop-filter: blur(30px);
        -webkit-backdrop-filter: blur(30px);
        margin-bottom: 60px;
        position: relative;
        overflow: visible;
        /* Allow decorative elements to pop out */
        box-shadow: 0 40px 100px -20px rgba(0, 0, 0, 0.08);
    }

    /* Decorative Floating Elements */
    .hero-badge {
        position: absolute;
        background: var(--glass-bg);
        backdrop-filter: var(--glass-blur);
        border: 1px solid var(--glass-border);
        padding: 16px 24px;
        border-radius: 24px;
        box-shadow: var(--shadow-premium);
        z-index: 20;
        display: flex;
        align-items: center;
        gap: 12px;
        animation: float 5s infinite alternate ease-in-out;
    }

    .badge-top {
        top: -20px;
        right: 10%;
        animation-delay: 0.5s;
    }

    .badge-bottom {
        bottom: -30px;
        left: 5%;
        animation-delay: 1s;
    }

    .hero-content h1 {
        font-size: 4.2rem;
        font-weight: 900;
        line-height: 0.95;
        margin-bottom: 30px;
        color: var(--primary-dark);
        letter-spacing: -3px;
    }

    .hero-content h1 span {
        display: block;
        background: linear-gradient(135deg, var(--primary) 0%, var(--accent-teal) 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }

    .hero-content p {
        font-size: 1.3rem;
        color: #475569;
        font-weight: 600;
        margin-bottom: 45px;
        line-height: 1.6;
        max-width: 550px;
    }

    .hero-visual {
        position: relative;
        display: flex;
        justify-content: center;
        align-items: center;
        padding: 0;
        height: 500px;
        /* Fixed height for slider area */
    }

    .hero-slider-wrapper {
        width: 100%;
        height: 100%;
        position: relative;
        z-index: 10;
        border-radius: 60px;
        /* Matching the creative frame radius */
        overflow: hidden;
        border: 8px solid rgba(255, 255, 255, 0.5);
        /* Premium Frame Box */
        box-shadow:
            0 30px 60px rgba(0, 0, 0, 0.1),
            inset 0 0 20px rgba(0, 0, 0, 0.05);
        backdrop-filter: blur(5px);
    }

    .hero-slider-wrapper img {
        animation: none !important;
        /* Disable floating for slider images */
    }

    .carousel-item {
        transition: transform 1.2s ease-in-out, opacity 1.2s ease-in-out;
    }

    /* --- Premium Stat Cards --- */
    .stat-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
        gap: 24px;
        margin-bottom: 50px;
    }

    .premium-stat-card {
        background: var(--glass-bg);
        border-radius: var(--radius-2xl);
        padding: 30px;
        border: 1px solid var(--glass-border);
        box-shadow: var(--shadow-premium);
        transition: all 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
        text-align: left;
        position: relative;
        overflow: hidden;
    }

    .premium-stat-card:hover {
        transform: translateY(-8px) scale(1.02);
        box-shadow: 0 30px 60px -12px rgba(0, 0, 0, 0.15);
    }

    .premium-stat-card::after {
        content: '';
        position: absolute;
        bottom: -20px;
        right: -20px;
        width: 80px;
        height: 80px;
        background: var(--primary);
        opacity: 0.03;
        border-radius: 50%;
    }

    .stat-icon-box {
        width: 64px;
        height: 64px;
        border-radius: var(--radius-lg);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.8rem;
        margin-bottom: 24px;
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.05);
    }

    .stat-val {
        font-size: 2.5rem;
        font-weight: 900;
        line-height: 1;
        color: var(--primary);
        margin-bottom: 8px;
    }

    .stat-tit {
        font-size: 1rem;
        font-weight: 800;
        color: #334155;
        margin-bottom: 4px;
    }

    .stat-des {
        font-size: 0.8rem;
        font-weight: 600;
        color: #94a3b8;
    }

    /* Colors */
    .icon-rdtr {
        background: rgba(30, 60, 114, 0.08);
        color: var(--primary);
    }

    .icon-rtrw {
        background: rgba(245, 158, 11, 0.08);
        color: var(--accent-amber);
    }

    .icon-search {
        background: rgba(39, 174, 96, 0.08);
        color: var(--accent);
    }

    .icon-trend {
        background: rgba(6, 182, 212, 0.08);
        color: var(--accent-teal);
    }

    /* --- Section Styling --- */
    .glass-section-card {
        background: var(--glass-bg);
        border-radius: var(--radius-2xl);
        border: 1px solid var(--glass-border);
        box-shadow: var(--shadow-premium);
        padding: 35px;
        height: 100%;
    }

    .section-header {
        display: flex;
        align-items: center;
        gap: 15px;
        margin-bottom: 30px;
    }

    .section-header i {
        width: 45px;
        height: 45px;
        border-radius: 12px;
        background: rgba(30, 60, 114, 0.1);
        color: var(--primary);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.3rem;
    }

    .section-header h4 {
        margin: 0;
        font-size: 1.4rem;
        font-weight: 800;
        color: var(--primary-dark);
    }

    /* --- List Ranking --- */
    .rank-item {
        display: flex;
        align-items: center;
        gap: 16px;
        padding: 15px;
        border-radius: 16px;
        transition: all 0.3s ease;
        margin-bottom: 8px;
    }

    .rank-item:hover {
        background: rgba(0, 0, 0, 0.02);
    }

    .rank-number {
        width: 32px;
        height: 32px;
        border-radius: 10px;
        background: var(--primary);
        color: white;
        font-weight: 800;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    .rank-info {
        flex: 1;
    }

    .rank-name {
        font-weight: 700;
        font-size: 0.95rem;
        color: #1e293b;
    }

    .rank-bar {
        height: 6px;
        background: rgba(0, 0, 0, 0.04);
        border-radius: 6px;
        margin-top: 8px;
        overflow: hidden;
    }

    .rank-bar-fill {
        height: 100%;
        background: var(--primary);
        border-radius: 6px;
    }

    .rank-val {
        font-weight: 900;
        color: var(--primary);
        font-size: 1.1rem;
    }

    /* --- CTA Glass --- */
    .main-cta {
        margin-top: 60px;
        background: linear-gradient(135deg, var(--primary) 0%, var(--primary-light) 100%);
        border-radius: var(--radius-3xl);
        padding: 60px 40px;
        text-align: center;
        color: white;
        box-shadow: 0 25px 50px -12px rgba(30, 60, 114, 0.4);
        position: relative;
        overflow: hidden;
    }

    .cta-btn {
        background: white;
        color: var(--primary);
        padding: 16px 40px;
        border-radius: 16px;
        font-weight: 800;
        font-size: 1.1rem;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 12px;
        transition: all 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
        margin-top: 25px;
    }

    .cta-btn:hover {
        transform: scale(1.05) translateY(-5px);
        box-shadow: 0 15px 30px rgba(0, 0, 0, 0.2);
        color: var(--primary-dark);
    }

    @media (max-width: 991px) {
        .home-page-wrapper {
            padding: 20px 15px;
        }

        .hero-container {
            grid-template-columns: 1fr;
            padding: 40px 24px;
            text-align: center;
            border-radius: 32px;
            margin-bottom: 40px;
        }

        .hero-content h1 {
            font-size: 2.5rem;
            letter-spacing: -1.5px;
        }

        .hero-content p {
            font-size: 1.1rem;
            margin: 0 auto 30px auto;
        }

        .hero-visual {
            height: 350px;
            /* Shorter on mobile */
        }

        .hero-slider-wrapper {
            border-radius: 40px;
            border-width: 4px;
        }
    }

    @media (max-width: 480px) {
        .hero-content h1 {
            font-size: 2.1rem;
        }

        .hero-visual {
            height: 280px;
        }
    }
</style>
<?php $this->endSection() ?>

<?php $this->section('content') ?>

<div class="home-page-wrapper">

    <!-- Hero asimetris -->
    <div class="hero-container">
        <!-- Decorative Floating Badges -->
        <div class="hero-badge badge-top">
            <i class="bi bi-patch-check-fill text-primary" style="font-size: 1.5rem;"></i>
           <div class="d-flex flex-column">
                <span class="fw-800 text-dark" style="font-size: 0.85rem; line-height: 1.1;">Analisis Instan</span>
                <span class="small text-muted fw-600" style="font-size: 0.7rem;">Hasil Real-time RDTR & RTRW</span>
            </div>
        </div>
        <!-- <div class="hero-badge badge-bottom">
            <i class="bi bi-lightning-charge-fill text-warning" style="font-size: 1.5rem;"></i>
            <div class="d-flex flex-column">
                <span class="fw-800 text-dark" style="font-size: 0.85rem; line-height: 1.1;">Analisis Instan</span>
                <span class="small text-muted fw-600" style="font-size: 0.7rem;">Hasil Real-time RDTR & RTRW</span>
            </div>
        </div> -->

        <div class="hero-content">
            <h1>Transparansi <span>Tata Ruang</span> Tanah Bumbu</h1>
            <p>Pusat data spasial terpadu untuk pemantauan rencana tata ruang, analisis investasi,
                dan keterbukaan informasi publik Kabupaten Tanah Bumbu.</p>
            <div class="d-flex gap-3 justify-content-center justify-content-lg-start">
                <a href="<?= base_url('map') ?>"
                    class="btn btn-lg btn-primary rounded-pill px-5 py-3 fw-800 shadow-lg border-0">
                    Mulai Jelajah <i class="bi bi-arrow-right-short"></i>
                </a>
            </div>
        </div>
        <div class="hero-visual">
            <div class="hero-slider-wrapper">
                <?php if (!empty($heroImages)): ?>
                    <div id="heroCarousel" class="carousel slide carousel-fade h-100" data-bs-ride="carousel"
                        data-bs-interval="<?= $heroSlideInterval ?>">
                        <div class="carousel-inner h-100">
                            <?php foreach ($heroImages as $i => $img): ?>
                                <div class="carousel-item <?= $i === 0 ? 'active' : '' ?> h-100">
                                    <img src="<?= base_url($img['image_path']) ?>" class="d-block w-100 h-100"
                                        style="object-fit: cover;" alt="Hero Image <?= $i + 1 ?>">
                                </div>
                            <?php endforeach; ?>
                        </div>
                        <?php if (count($heroImages) > 1): ?>
                            <button class="carousel-control-prev" type="button" data-bs-target="#heroCarousel"
                                data-bs-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            </button>
                            <button class="carousel-control-next" type="button" data-bs-target="#heroCarousel"
                                data-bs-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            </button>
                        <?php endif; ?>
                    </div>
                <?php else: ?>
                    <img src="<?= base_url('img/hero-ornament.png') ?>" alt="Spatial Data Visualization">
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Stat Grid -->
    <div class="stat-grid">
        <div class="premium-stat-card">
            <div class="stat-icon-box icon-rdtr"><i class="bi bi-grid-3x3-gap-fill"></i></div>
            <div class="stat-val"><?= number_format($totalRdtr) ?></div>
            <div class="stat-tit">Zona RDTR</div>
            <div class="stat-des">Rencana Detail Tata Ruang</div>
        </div>
        <div class="premium-stat-card">
            <div class="stat-icon-box icon-rtrw"><i class="bi bi-map-fill"></i></div>
            <div class="stat-val"><?= number_format($totalRtrw) ?></div>
            <div class="stat-tit">Kawasan RTRW</div>
            <div class="stat-des">Tata Ruang Wilayah</div>
        </div>
        <div class="premium-stat-card">
            <div class="stat-icon-box icon-search"><i class="bi bi-search"></i></div>
            <div class="stat-val"><?= number_format($totalSearches) ?></div>
            <div class="stat-tit">Analisis Spasial</div>
            <div class="stat-des">Total Pencarian Data</div>
        </div>
        <div class="premium-stat-card">
            <div class="stat-icon-box icon-trend"><i class="bi bi-graph-up-arrow"></i></div>
            <div class="stat-val"><?= $avgSearchesPerDay ?></div>
            <div class="stat-tit">Tren Harian</div>
            <div class="stat-des">Akses Rata-rata 7 Hari</div>
        </div>
    </div>

    <div class="row g-4 mb-5">
        <div class="col-lg-7">
            <div class="glass-section-card">
                <div class="section-header">
                    <i class="bi bi-bar-chart-fill"></i>
                    <h4>Pemanfaatan Ruang Tertinggi</h4>
                </div>

                <?php if (!empty($topPeruntukan)): ?>
                    <?php $maxVal = max(array_column($topPeruntukan, 'jumlah')); ?>
                    <div class="rank-list">
                        <?php foreach ($topPeruntukan as $i => $it):
                            $pct = ($it['jumlah'] / $maxVal) * 100;
                            ?>
                            <div class="rank-item">
                                <div class="rank-number"><?= $i + 1 ?></div>
                                <div class="rank-info">
                                    <div class="d-flex justify-content-between align-items-center mb-1">
                                        <span class="rank-name"><?= esc($it['peruntukan']) ?></span>
                                        <span class="rank-val"><?= number_format($it['jumlah']) ?></span>
                                    </div>
                                    <div class="rank-bar">
                                        <div class="rank-bar-fill" style="width: <?= $pct ?>%"></div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <div class="text-center py-5 text-muted">
                        <i class="bi bi-inbox-fill mb-3" style="font-size: 3rem; opacity: 0.3;"></i>
                        <p class="fw-600">Belum ada data analisis terkumpul</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
        <div class="col-lg-5">
            <div class="glass-section-card">
                <div class="section-header">
                    <i class="bi bi-pie-chart-fill"></i>
                    <h4>Proporsi Zona RDTR</h4>
                </div>
                <div style="height: 350px;">
                    <canvas id="distChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- CTA Glass Area -->
    <div class="main-cta">
        <h2 class="fw-900 mb-3" style="font-size: 2.5rem;">Cek Lokasi Investasi Anda</h2>
        <p class="mb-4 opacity-75 fw-600">Dapatkan informasi detail mengenai peruntukan zona dan regulasi pemanfaatan
            ruang secara instan langsung dari peta.</p>
        <a href="<?= base_url('map') ?>" class="cta-btn">
            <i class="bi bi-geo-alt-fill"></i> Buka Peta Sekarang
        </a>
    </div>

</div>

<?php $this->endSection() ?>

<?php $this->section('scripts') ?>
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
    const canvas = document.getElementById('distChart');
    if (canvas && <?= !empty($rdtrByPeruntukan) ? 'true' : 'false' ?>) {
        new Chart(canvas.getContext('2d'), {
            type: 'doughnut',
            data: {
                labels: [<?php foreach ($rdtrByPeruntukan as $it) {
                    $lbl = $it['peruntukan'];
                    $short = mb_strlen($lbl) > 15 ? mb_substr($lbl, 0, 15) . '...' : $lbl;
                    echo "'" . addslashes($short) . "',";
                } ?>],
                datasets: [{
                    data: [<?php foreach ($rdtrByPeruntukan as $it)
                        echo $it['count'] . ","; ?>],
                    backgroundColor: ['#1e3c72', '#2a5298', '#3b82f6', '#06b6d4', '#10b981', '#f59e0b', '#ef4444'],
                    borderWidth: 0,
                    hoverOffset: 20
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutout: '75%',
                plugins: {
                    legend: { position: 'bottom', labels: { padding: 20, font: { size: 11, weight: 'bold' }, usePointStyle: true } }
                }
            }
        });
    }
</script>
<?php $this->endSection() ?>