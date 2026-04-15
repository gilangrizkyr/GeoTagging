<!DOCTYPE html>
<?php
/** @var \CodeIgniter\View\View $this */
$settingsModel = new \App\Models\SettingsModel();
$role = session()->get('role'); // Use role if logged in, otherwise null
$appName = $settingsModel->getValueWithRole('app_name', $role, 'Geotagging App');
$logoNavbar1 = $settingsModel->getValueWithRole('logo_navbar_1', $role, '');
$logoNavbar2 = $settingsModel->getValueWithRole('logo_navbar_2', $role, '');
$logoNavbar3 = $settingsModel->getValueWithRole('logo_navbar_3', $role, '');
$headerColorGlobal = $settingsModel->getValue('header_color', '#b6b7deff');
$headerColor = $settingsModel->getValueWithRole('header_color', $role, $headerColorGlobal);
$appSubtitle = $settingsModel->getValueWithRole('app_subtitle', $role, 'Pusat Data Spasial');
// footer text customizable via settings
$footerText = $settingsModel->getValueWithRole('footer_text', $role, 'Dinas Penanaman Modal dan PTSP');

// Fetch Social Media & Map Settings
$fbUrl = $settingsModel->getValueWithRole('facebook_url', $role, '');
$igUrl = $settingsModel->getValueWithRole('instagram_url', $role, '');
$ytUrl = $settingsModel->getValueWithRole('youtube_url', $role, '');
$twUrl = $settingsModel->getValueWithRole('twitter_url', $role, '');
$mapIframe = $settingsModel->getValueWithRole('office_map_iframe', $role, '');

// Helper to clean paths that might have 'public/' prefix from database
if (!function_exists('clean_asset_url')) {
    function clean_asset_url($path)
    {
        if (empty($path))
            return '';
        // If path starts with public/, remove it
        if (strpos($path, 'public/') === 0) {
            $path = substr($path, 7);
        }
        return base_url($path);
    }
}
?>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        <?= esc($appName) ?>
    </title>
    <meta name="csrf-token" content="<?= csrf_hash() ?>">
    <meta name="csrf-header" content="<?= csrf_header() ?>">

    <!-- Fonts & Assets -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=plus-jakarta-sans:300,400,500,600,700,800|outfit:400,500,600,700"
        rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/leaflet@1.9.4/dist/leaflet.min.css" />

    <style>
        :root {
            --primary: #1e3c72;
            --primary-dark: #0f172a;
            --primary-light: #2a5298;
            --accent: #10b981;
            --accent-teal: #06b6d4;
            --accent-amber: #f59e0b;
            --bg-main: #f8fafc;

            /* Luxury Glassmorphism */
            --glass-bg: rgba(255, 255, 255, 0.82);
            --glass-border: rgba(255, 255, 255, 0.6);
            --glass-blur: blur(24px);

            /* Flagship Shadows */
            --shadow-premium: 0 30px 60px -15px rgba(0, 0, 0, 0.12);
            --shadow-glow: 0 10px 30px -5px rgba(30, 60, 114, 0.25);

            --radius-3xl: 40px;
            --radius-2xl: 28px;
            --radius-xl: 18px;
        }

        @keyframes mesh-animation {
            0% {
                background-position: 0% 50%;
            }

            50% {
                background-position: 100% 50%;
            }

            100% {
                background-position: 0% 50%;
            }
        }

        .mesh-background {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: -2;
            background: linear-gradient(-45deg, #f8fafc, #f1f5f9, #eef2ff, #f0fdf4, #f8fafc);
            background-size: 400% 400%;
            animation: mesh-animation 20s ease infinite;
        }

        .bg-blob {
            position: fixed;
            width: 900px;
            height: 900px;
            border-radius: 50%;
            z-index: -1;
            filter: blur(150px);
            opacity: 0.15;
            pointer-events: none;
        }

        .blob-1 {
            top: -300px;
            right: -200px;
            background: var(--primary);
            animation: float-blob 25s infinite alternate;
        }

        .blob-2 {
            bottom: -400px;
            left: -300px;
            background: var(--accent);
            animation: float-blob 30s infinite alternate-reverse;
        }

        .blob-3 {
            top: 20%;
            left: -100px;
            width: 400px;
            height: 400px;
            background: var(--accent-teal);
            animation: float-blob 20s infinite;
            opacity: 0.08;
        }

        @keyframes float-blob {
            0% {
                transform: translate(0, 0) scale(1);
            }

            100% {
                transform: translate(100px, 150px) scale(1.15);
            }
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: transparent;
            color: #1e293b;
            letter-spacing: -0.015em;
            overflow-x: hidden;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        h1,
        h2,
        h3,
        h4,
        h5,
        .navbar-brand {
            font-family: 'Outfit', sans-serif;
        }

        .fw-500 {
            font-weight: 500;
        }

        .fw-600 {
            font-weight: 600;
        }

        .fw-700 {
            font-weight: 700;
        }

        .fw-800 {
            font-weight: 800;
        }

        .fw-900 {
            font-weight: 900;
        }

        /* --- Flagship Floating Navbar --- */
        .navbar-container {
            padding: 1.5rem 2rem 0.5rem 2rem;
            position: sticky;
            top: 0;
            z-index: 1050;
            transition: all 0.4s ease;
        }

        .navbar {
            max-width: 1400px;
            margin: 0 auto;
            background: var(--glass-bg) !important;
            backdrop-filter: var(--glass-blur);
            -webkit-backdrop-filter: var(--glass-blur);
            border: 1.5px solid var(--glass-border);
            border-radius: var(--radius-2xl);
            padding: 0.9rem 2rem;
            box-shadow: var(--shadow-premium);
            transition: all 0.5s cubic-bezier(0.16, 1, 0.3, 1);
        }

        .navbar.scrolled {
            padding: 0.6rem 2rem;
            margin-top: -0.5rem;
            border-radius: 0 0 30px 30px;
            border-top-color: transparent;
        }

        .navbar-brand {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .brand-logos img {
            height: 44px;
            width: auto;
            object-fit: contain;
            filter: drop-shadow(0 4px 8px rgba(0, 0, 0, 0.05));
        }

        .app-name {
            font-weight: 900;
            font-size: 1.35rem;
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-light) 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            letter-spacing: -1px;
        }

        .app-subtitle {
            font-weight: 700;
            font-size: 0.7rem;
            color: #64748b;
            letter-spacing: 1px;
            text-transform: uppercase;
        }

        @media (max-width: 991px) {
            .navbar {
                padding: 0.7rem 1.2rem !important;
            }

            .app-name {
                font-size: 1.05rem !important;
                letter-spacing: -0.5px !important;
            }

            .app-subtitle {
                font-size: 0.55rem !important;
                letter-spacing: 0.5px !important;
            }

            .brand-logos img {
                height: 36px !important;
            }
        }

        .nav-link.active {
            color: var(--primary) !important;
            background: rgba(30, 60, 114, 0.06);
        }

        .btn-portal {
            background: var(--primary);
            color: white !important;
            padding: 12px 28px !important;
            border-radius: 14px;
            font-weight: 800;
            box-shadow: var(--shadow-glow);
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        }

        .btn-portal:hover {
            transform: translateY(-4px) scale(1.03);
            background: var(--primary-light);
            box-shadow: 0 15px 35px rgba(30, 60, 114, 0.35);
        }

        .navbar-toggler-icon {
            filter: brightness(0) saturate(100%) invert(18%) sepia(43%) saturate(1967%) hue-rotate(204deg) brightness(91%) contrast(92%);
        }

        /* --- Flagship Footer --- */
        footer {
            background: rgba(255, 255, 255, 0.45);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            padding: 80px 0 40px 0;
            margin-top: 100px;
            border-top: 1px solid rgba(0, 0, 0, 0.04);
            position: relative;
        }

        .footer-heading {
            font-weight: 800;
            font-size: 1.1rem;
            margin-bottom: 24px;
            color: var(--primary-dark);
            letter-spacing: -0.5px;
            text-transform: uppercase;
        }

        .footer-links {
            list-style: none;
            padding-left: 0;
            margin-bottom: 0;
        }

        .footer-links li {
            margin-bottom: 12px;
        }

        .footer-links a {
            color: #64748b;
            text-decoration: none;
            font-weight: 500;
            font-size: 0.95rem;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
        }

        .footer-links a:hover {
            color: var(--primary);
            transform: translateX(4px);
        }

        .social-btn {
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 12px;
            background: white;
            color: var(--primary);
            border: 1px solid rgba(0, 0, 0, 0.05);
            transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            text-decoration: none;
        }

        .social-btn:hover {
            background: var(--primary);
            color: white;
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(30, 60, 114, 0.2);
        }

        .map-frame {
            border-radius: 24px;
            overflow: hidden;
            border: 4px solid white;
            box-shadow: var(--shadow-premium);
            height: 200px;
            background: #eee;
        }

        .map-frame iframe {
            width: 100% !important;
            height: 100% !important;
            border: 0;
        }

        .footer-bottom {
            margin-top: 60px;
            padding-top: 32px;
            border-top: 1.5px solid rgba(0, 0, 0, 0.05);
            font-size: 0.85rem;
            font-weight: 500;
            color: #94a3b8;
        }

        /* --- Content Layout --- */
        .app-main-content {
            padding: 0 48px 40px 48px;
            display: flex;
            flex-direction: column;
            flex: 1 1 auto;
            min-height: 0;
            position: relative;
        }

        /* Essential Fix for Map Visibility */
        body.is-map-page {
            height: 100vh;
            overflow: hidden !important;
        }

        @media (max-width: 991px) {
            body.is-map-page {
                height: auto;
                overflow: auto !important;
            }
        }

        body.is-map-page .navbar-container {
            padding: 1rem 1.5rem 0.5rem 1.5rem;
        }

        body.is-map-page .app-main-content {
            padding: 16px;
            gap: 0;
            height: calc(100vh - 100px);
            /* Adjust based on navbar height */
            overflow: hidden;
        }

        @media (max-width: 991px) {
            body.is-map-page .app-main-content {
                height: auto;
                /* Mobile navbar height */
                padding: 10px;
                overflow: visible;
            }
        }

        body.is-map-page footer {
            display: none;
        }

        @media (max-width: 991px) {
            .navbar-container {
                padding: 1rem 1rem 0 1rem;
            }

            .navbar {
                padding: 0.7rem 1.2rem;
                border-radius: 20px;
            }

            .app-main-content {
                padding: 0 20px 20px 20px;
                gap: 20px;
            }

            body.is-map-page .app-main-content {
                padding: 10px;
                height: calc(100vh - 85px);
            }

            .app-name {
                font-size: 1.15rem;
            }
        }
    </style>
    </style>
    <?= $this->renderSection('styles') ?>
</head>

<body
    class="d-flex flex-column min-vh-100 role-<?= $role ?> <?= (strpos(current_url(), '/map') !== false) ? 'is-map-page' : '' ?>">
    <!-- Fluid Deco Background -->
    <div class="mesh-background"></div>
    <div class="bg-blob blob-p"></div>
    <div class="bg-blob blob-a"></div>

    <div class="navbar-container">
        <nav class="navbar navbar-expand-lg">
            <div class="container-fluid">
                <a class="navbar-brand" href="<?= base_url() ?>">
                    <div class="brand-logos d-flex gap-1 gap-md-2 align-items-center">
                        <?php if (isset($logoNavbar1) && $logoNavbar1): ?>
                            <img src="<?= clean_asset_url($logoNavbar1) ?>" alt="Logo 1">
                        <?php endif; ?>
                        <?php if (isset($logoNavbar2) && $logoNavbar2): ?>
                            <img src="<?= clean_asset_url($logoNavbar2) ?>" alt="Logo 2" class="d-none d-lg-block">
                        <?php endif; ?>
                    </div>
                    <div class="d-flex flex-column">
                        <span class="app-name">Geotagging DPMPTSP <span class="d-none d-lg-inline">TANAH
                                BUMBU</span></span>
                        <span class="app-subtitle">Sistem Informasi Geospasial Terintegrasi</span>
                    </div>
                </a>

                <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarNav">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ms-auto align-items-center">
                        <li class="nav-item">
                            <a class="nav-link <?= (current_url() == base_url() || current_url() == base_url('/')) ? 'active' : '' ?>"
                                href="<?= base_url() ?>">Beranda</a>
                        </li>
                        <li class="nav-item ms-lg-2">
                            <a class="nav-link <?= (strpos(current_url(), '/map') !== false) ? 'active' : '' ?>"
                                href="<?= base_url('map') ?>">Peta Interaktif</a>
                        </li>
                        <li class="nav-item ms-lg-4">
                            <a class="nav-link btn-portal" href="<?= base_url('auth/login') ?>">
                                <i class="bi bi-shield-lock-fill me-2"></i> Portal Petugas
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </div>

    <main class="flex-grow-1 app-main-content">
        <?= $this->renderSection('content') ?>
    </main>

    <footer>
        <div class="container">
            <div class="row g-4 justify-content-between">
                <div class="col-lg-4 col-md-6">
                    <div class="footer-brand mb-4">
                        <h4 class="fw-900 text-primary mb-1"><?= esc($appName) ?></h4>
                        <p class="text-muted small"><?= esc($appSubtitle) ?></p>
                    </div>
                    <p class="text-muted mb-4 pe-lg-4">Sistem Informasi Geospasial Terintegrasi Kabupaten Tanah Bumbu
                        untuk transparansi data tata ruang dan investasi.</p>

                    <!-- Dynamic Social Media -->
                    <?php if ($fbUrl || $igUrl || $ytUrl || $twUrl): ?>
                        <div class="d-flex gap-3">
                            <?php if ($fbUrl): ?><a href="<?= esc($fbUrl) ?>" target="_blank" class="social-btn"><i
                                        class="bi bi-facebook"></i></a><?php endif; ?>
                            <?php if ($igUrl): ?><a href="<?= esc($igUrl) ?>" target="_blank" class="social-btn"><i
                                        class="bi bi-instagram"></i></a><?php endif; ?>
                            <?php if ($ytUrl): ?><a href="<?= esc($ytUrl) ?>" target="_blank" class="social-btn"><i
                                        class="bi bi-youtube"></i></a><?php endif; ?>
                            <?php if ($twUrl): ?><a href="<?= esc($twUrl) ?>" target="_blank" class="social-btn"><i
                                        class="bi bi-twitter-x"></i></a><?php endif; ?>
                        </div>
                    <?php endif; ?>
                </div>

                <div class="col-lg-2 col-md-6">
                    <h5 class="footer-heading">Navigasi</h5>
                    <ul class="footer-links">
                        <li><a href="<?= base_url() ?>">Halaman Utama</a></li>
                        <li><a href="<?= base_url('map') ?>">Peta Interaktif</a></li>
                        <li><a href="<?= base_url('map?layer=rdtr') ?>">Layer RDTR</a></li>
                        <li><a href="<?= base_url('map?layer=rtrw') ?>">Layer RTRW</a></li>
                    </ul>
                </div>

                <div class="col-lg-2 col-md-6">
                    <h5 class="footer-heading">Kontak</h5>
                    <ul class="footer-links">
                        <li><a href="#"><i class="bi bi-geo-alt-fill me-2 text-primary"></i> <?= esc($footerText) ?></a>
                        </li>
                        <li><a href="mailto:info@tanahbumbu.go.id"><i class="bi bi-envelope-fill me-2 text-primary"></i>
                                info@tanahbumbu.go.id</a></li>
                        <li><a href="tel:#"><i class="bi bi-telephone-fill me-2 text-primary"></i> (0518) Hubungi
                                Kami</a></li>
                    </ul>
                </div>

                <div class="col-lg-3 col-md-6">
                    <h5 class="footer-heading">Lokasi Kami</h5>
                    <div class="map-frame">
                        <?php if ($mapIframe): ?>
                            <?= $mapIframe ?>
                        <?php else: ?>
                            <div class="w-100 h-100 d-flex align-items-center justify-content-center text-muted bg-light">
                                <small>Peta belum dikonfigurasi</small>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <div
                class="footer-bottom d-flex flex-column flex-md-row justify-content-between align-items-center text-center text-md-start">
                <p class="mb-3 mb-md-0">&copy; <?= date('Y') ?> Pemerintah Kabupaten Tanah Bumbu. Seluruh Hak Cipta
                    Dilindungi.</p>
                <div class="d-flex gap-4">
                    <a href="#" class="text-decoration-none text-muted hover-primary">Kebijakan Privasi</a>
                    <a href="#" class="text-decoration-none text-muted hover-primary">Syarat & Ketentuan</a>
                </div>
            </div>
        </div>
    </footer>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script>
        const baseUrl = "<?= base_url() ?>";
        // Navbar Scrolled Effect
        window.addEventListener('scroll', function () {
            if (window.scrollY > 50) {
                document.querySelector('.navbar').classList.add('scrolled');
            } else {
                document.querySelector('.navbar').classList.remove('scrolled');
            }
        });
    </script>
    <?= $this->renderSection('scripts') ?>
</body>

</html>