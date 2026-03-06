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
?>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        <?= esc($appName) ?>
    </title>

    <!-- Fonts & Assets -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=plus-jakarta-sans:300,400,500,600,700,800|outfit:400,500,600,700"
        rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/leaflet@1.9.4/dist/leaflet.min.css" />

    <style>
        :root {
            --primary: #3c4b64;
            --primary-dark: #2c3e50;
            --primary-light: #526684;
            --secondary: #64748b;
            --accent: #27ae60;
            --accent-teal: #3db4c8;
            --bg-main: #f8fafc;

            /* Modern Gradients */
            --grad-primary: linear-gradient(135deg, var(--primary), var(--primary-dark));
            --grad-surface: linear-gradient(180deg, rgba(255, 255, 255, 0.9) 0%, rgba(255, 255, 255, 0.7) 100%);

            /* Premium Tokens */
            --radius-3xl: 32px;
            --radius-2xl: 24px;
            --radius-xl: 18px;

            /* Layered Shadows (Ambient Occlusion style) */
            --shadow-sm: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
            --shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            --shadow-premium: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
            --shadow-glow: 0 10px 15px -3px rgba(60, 75, 100, 0.3);

            --glass-bg: rgba(255, 255, 255, 0.7);
            --glass-border: 1px solid rgba(255, 255, 255, 0.4);
            --glass-blur: blur(20px);

            --transition-bounce: all 0.5s cubic-bezier(0.34, 1.56, 0.64, 1);
            --transition-smooth: all 0.3s ease;
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
            z-index: -1;
            background: linear-gradient(-45deg, #f8fafc, #f1f5f9, #e2e8f0, #f8fafc);
            background-size: 400% 400%;
            animation: mesh-animation 15s ease infinite;
            opacity: 0.8;
        }

        .mesh-blob {
            position: fixed;
            width: 600px;
            height: 600px;
            filter: blur(120px);
            z-index: -1;
            opacity: 0.15;
            border-radius: 50%;
            pointer-events: none;
        }

        .blob-1 {
            top: -100px;
            right: -100px;
            background: var(--primary);
            animation: float 20s infinite alternate;
        }

        .blob-2 {
            bottom: -200px;
            left: -200px;
            background: var(--accent);
            animation: float 25s infinite alternate-reverse;
        }

        @keyframes float {
            from {
                transform: translate(0, 0);
            }

            to {
                transform: translate(100px, 100px);
            }
        }

        @media (min-width: 992px) {

            html,
            body {
                height: auto;
                overflow-y: auto;
            }

            body {
                display: flex;
                flex-direction: column;
            }
        }

        @media (max-width: 991px) {

            html,
            body {
                height: auto;
                overflow: visible;
            }

            body {
                display: block;
                overflow: visible;
            }
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: transparent;
            color: #1e293b;
            letter-spacing: -0.01em;
        }

        /* Decorative Background Elements */
        .bg-blob {
            position: fixed;
            width: 500px;
            height: 500px;
            background: radial-gradient(circle, rgba(99, 102, 241, 0.15) 0%, rgba(240, 242, 245, 0) 70%);
            z-index: -1;
            filter: blur(40px);
            pointer-events: none;
        }

        .blob-1 {
            top: -100px;
            right: -100px;
        }

        .blob-2 {
            bottom: -100px;
            left: -100px;
            background: radial-gradient(circle, rgba(245, 158, 11, 0.1) 0%, rgba(240, 242, 245, 0) 70%);
        }

        /* Navbar: Crystal Clear */
        .navbar {
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.75) 0%, rgba(255, 255, 255, 0.5) 100%) !important;
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.5);
            border-radius: 16px;
            padding: 0.7rem 0;
            z-index: 1050;
            box-shadow: 0 20px 50px -12px rgba(0, 0, 0, 0.15);
            margin: 14px 16px 8px 16px;
            top: 8px;
            transition: all 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
        }

        .navbar:hover {
            box-shadow: 0 25px 60px -12px rgba(0, 0, 0, 0.2);
        }

        .navbar-brand {
            font-weight: 900;
            font-family: 'Outfit', sans-serif;
            display: flex;
            align-items: center;
            gap: 14px;
            font-size: 1.4rem;
            background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            transform: translateZ(0);
            transition: all 0.4s ease;
            flex-wrap: wrap;
        }

        .navbar-brand:hover {
            transform: scale(1.05);
        }

        .navbar-title-group {
            display: flex;
            flex-direction: column;
            margin-left: 12px;
            min-width: 0;
        }

        .navbar-app-name {
            font-weight: 900;
            font-size: 1.1rem;
            background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            line-height: 1.2;
            word-break: break-word;
        }

        .navbar-app-subtitle {
            font-weight: 600;
            font-size: 0.7rem;
            color: #64748b;
            line-height: 1;
        }

        @media (max-width: 991px) {
            .navbar-title-group {
                margin-left: 8px;
            }

            .navbar-app-name {
                font-size: 0.95rem;
            }

            .navbar-app-subtitle {
                font-size: 0.65rem;
            }
        }

        @media (max-width: 576px) {
            .navbar-title-group {
                margin-left: 6px;
            }

            .navbar-app-name {
                font-size: 0.85rem;
            }

            .navbar-app-subtitle {
                font-size: 0.6rem;
            }
        }

        .brand-logo-container {
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 8px;
        }

        .brand-logo-group {
            display: flex;
            align-items: center;
        }

        .brand-logo-container.has-icon {
            background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
            color: white;
            font-size: 2rem;
            transition: all 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
            border-radius: 12px;
            width: 52px;
            height: 52px;
        }

        .brand-logo-container.has-image img {
            max-height: 48px;
            width: auto;
        }

        .navbar-brand:hover .brand-logo-container {
            transform: scale(1.15) rotate(8deg);
            box-shadow: 0 10px 25px rgba(30, 60, 114, 0.3);
        }

        .nav-link {
            font-weight: 800;
            color: #64748b !important;
            padding: 10px 20px !important;
            border-radius: 10px;
            transition: all 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
            font-size: 0.95rem;
            position: relative;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            display: flex;
            align-items: center;
        }

        .nav-link.active,
        .nav-link:hover {
            color: #1e3c72 !important;
            background: linear-gradient(135deg, rgba(99, 102, 241, 0.12) 0%, rgba(99, 102, 241, 0.06) 100%);
            box-shadow: 0 4px 12px rgba(99, 102, 241, 0.15);
            transform: translateY(-2px);
        }

        @media (max-width: 991px) {
            .nav-link {
                display: flex;
                align-items: center;
                font-size: 0.9rem;
                padding: 12px 16px !important;
            }
        }

        @media (max-width: 576px) {
            .nav-link {
                font-size: 0.8rem;
                padding: 10px 12px !important;
            }
        }

        .btn-portal {
            background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%) !important;
            border: none;
            color: white !important;
            padding: 12px 28px !important;
            border-radius: 10px;
            font-weight: 800;
            box-shadow: 0 10px 25px rgba(30, 60, 114, 0.3);
            transition: all 0.5s cubic-bezier(0.34, 1.56, 0.64, 1);
            position: relative;
            overflow: hidden;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            font-size: 0.85rem;
        }

        .btn-portal::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
            transition: left 0.5s ease;
        }

        .btn-portal:hover {
            transform: translateY(-4px) scale(1.06);
            box-shadow: 0 20px 40px rgba(30, 60, 114, 0.4);
        }

        .btn-portal:hover::before {
            left: 100%;
        }

        /* App Container */
        .app-main-content {
            padding: 8px 24px 24px 24px;
            display: flex;
            gap: 24px;
            flex-direction: column;
        }

        @media (min-width: 992px) {
            .app-main-content {
                flex: 1;
                min-height: 0;
                overflow: visible;
            }

            /* Control visual order in desktop: panel left, map right */
            .floating-panel {
                order: 1;
            }

            .map-content-wrapper {
                order: 2;
            }
        }

        @media (max-width: 991px) {
            .app-main-content {
                display: flex;
                flex-direction: column;
                padding: 16px;
            }
        }

        /* Elegant Sidebar */
        .floating-panel {
            width: 440px;
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.95) 0%, rgba(255, 255, 255, 0.8) 100%);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.7);
            border-radius: 20px;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.15);
            overflow: hidden;
            z-index: 1000;
            display: flex;
            flex-direction: column;
            max-height: calc(100vh - 160px);
            animation: slideIn 0.6s cubic-bezier(0.16, 1, 0.3, 1);
            transition: all 0.5s cubic-bezier(0.34, 1.56, 0.64, 1);
        }

        .floating-panel:hover {
            box-shadow: 0 35px 70px -12px rgba(0, 0, 0, 0.2);
            transform: translateY(-2px);
        }

        @keyframes slideIn {
            from {
                transform: translateX(-30px);
                opacity: 0;
            }

            to {
                transform: translateX(0);
                opacity: 1;
            }
        }

        .panel-header {
            padding: 24px 20px;
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.3) 0%, rgba(255, 255, 255, 0.1) 100%);
            border-bottom: 1px solid rgba(30, 60, 114, 0.1);
            position: relative;
            backdrop-filter: blur(10px);
        }

        .panel-header h5 {
            font-family: 'Outfit', sans-serif;
            font-weight: 900;
            font-size: 1.6rem;
            background: linear-gradient(135deg, #1e3c72 0%, #2a5298 50%, #27ae60 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin: 0;
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .header-icon {
            width: 48px;
            height: 48px;
            background: linear-gradient(135deg, rgba(99, 102, 241, 0.15) 0%, rgba(99, 102, 241, 0.05) 100%);
            color: #1e3c72;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.4rem;
            box-shadow: 0 4px 12px rgba(99, 102, 241, 0.15);
            transition: all 0.3s ease;
        }

        .panel-header:hover .header-icon {
            transform: scale(1.1) rotate(10deg);
            box-shadow: 0 8px 20px rgba(99, 102, 241, 0.25);
        }

        .panel-body {
            padding: 20px;
            overflow-y: auto;
            flex-grow: 1;
            scrollbar-gutter: stable;
        }

        /* Custom Scrollbar for Premium Feel */
        .panel-body::-webkit-scrollbar {
            width: 6px;
        }

        .panel-body::-webkit-scrollbar-track {
            background: transparent;
        }

        .panel-body::-webkit-scrollbar-thumb {
            background: rgba(60, 75, 100, 0.15);
            border-radius: 10px;
            transition: var(--transition-smooth);
        }

        .panel-body::-webkit-scrollbar-thumb:hover {
            background: rgba(60, 75, 100, 0.3);
        }

        /* Map Frame: The Centerpiece */
        .map-frame {
            flex-grow: 1;
            background: white;
            border-radius: var(--radius-3xl);
            border: none;
            box-shadow: var(--shadow-premium);
            overflow: hidden;
            position: relative;
            transform: translateZ(0);
        }

        #map {
            width: 100%;
            height: 100%;
            z-index: 1;
            border-radius: var(--radius-3xl);
        }

        /* Floating Controls & Search */
        .search-container {
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.95) 0%, rgba(255, 255, 255, 0.7) 100%);
            border-radius: 16px;
            padding: 12px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.12);
            border: 1px solid rgba(255, 255, 255, 0.7);
            transition: all 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
            backdrop-filter: blur(10px);
        }

        .search-container:focus-within {
            transform: translateY(-4px);
            box-shadow: 0 20px 45px -5px rgba(30, 60, 114, 0.2);
            border-color: #1e3c72;
            background: white;
        }

        .form-floating>.form-control {
            border: none;
            background: transparent;
            font-weight: 700;
            color: #0f172a;
            padding: 12px 16px;
            font-size: 0.95rem;
        }

        .form-floating>.form-control:focus {
            border: none;
            background: rgba(30, 60, 114, 0.02);
            box-shadow: none;
            color: #1e3c72;
        }

        .form-floating>label {
            color: #94a3b8;
            font-weight: 600;
            font-size: 0.85rem;
        }

        @media (max-width: 991px) {
            .app-main-content {
                padding: 12px;
                height: auto;
                flex-direction: column;
            }

            .map-content-wrapper {
                order: 1;
                margin-bottom: 24px;
                margin-top: 12px;
            }

            .map-frame {
                height: 40vh;
                border: 6px solid white;
            }

            .floating-panel {
                order: 2;
                position: relative;
                bottom: auto;
                left: auto;
                right: auto;
                width: 100%;
                height: auto;
                max-height: none;
                transform: none;
                box-shadow: var(--shadow-premium);
                margin-bottom: 24px;
            }
        }

        /* footer styling enhanced for modern look */
        footer {
            padding: 1.2rem 0;
            background: #ffffff;
            border-top: 2px solid #e2e8f0;
            border-bottom: 2px solid #e2e8f0;
            box-shadow: 0 -5px 10px rgba(0, 0, 0, 0.05);
            margin-top: 0;
            font-weight: 600;
            color: #4a5568;
            font-size: 0.9rem;
        }

        footer a {
            color: inherit;
            text-decoration: none;
        }

        footer a:hover {
            text-decoration: underline;
        }

        footer div:last-child {
            font-size: 0.7rem;
            opacity: 0.75;
            letter-spacing: 0.5px;
            margin-top: 8px;
        }

        @media (min-width: 992px) {
    .app-main-content {
        flex-direction: row;
        align-items: flex-start;
        flex: 1;
    }

    .floating-panel {
        order: 1;
        flex-shrink: 0;
        width: 400px;
        height: 75vh;        /* ← tinggi tetap */
        max-height: 75vh;    /* ← tidak bisa memanjang */
        position: sticky;
        top: 100px;
        overflow: hidden;    /* ← konten tidak meluber */
    }

    .panel-body {
        overflow-y: auto;    /* ← scroll di dalam panel */
        height: calc(75vh - 80px); /* dikurangi tinggi panel-header */
    }

    .map-content-wrapper {
        order: 2;
        flex: 1;
        height: 75vh;        /* ← sama dengan panel */
    }

    .map-frame {
        height: 100%;
    }

        }
    </style>
    <?= $this->renderSection('styles') ?>
</head>

<body class="d-flex flex-column min-vh-100">
    <div class="bg-blob blob-1"></div>
    <div class="bg-blob blob-2"></div>

    <div class="mesh-background"></div>
    <div class="mesh-blob blob-1"></div>
    <div class="mesh-blob blob-2"></div>

    <nav class="navbar navbar-expand-lg sticky-top">
        <div class="container-fluid px-4 px-lg-5">
            <a class="navbar-brand" href="<?= base_url() ?>">
                <div class="brand-logo-group">
                    <?php if ($logoNavbar1): ?>
                        <div class="brand-logo-container has-image ms-0">
                            <img src="<?= base_url($logoNavbar1) ?>" alt="Logo 1">
                        </div>
                    <?php endif; ?>
                    <?php if ($logoNavbar2): ?>
                        <div class="brand-logo-container has-image">
                            <img src="<?= base_url($logoNavbar2) ?>" alt="Logo 2">
                        </div>
                    <?php endif; ?>
                    <?php if ($logoNavbar3): ?>
                        <div class="brand-logo-container has-image">
                            <img src="<?= base_url($logoNavbar3) ?>" alt="Logo 3">
                        </div>
                    <?php endif; ?>
                    <?php if (!($logoNavbar1 || $logoNavbar2 || $logoNavbar3)): ?>
                        <div class="brand-logo-container has-icon">
                            <i class="bi bi-geo-fill"></i>
                        </div>
                    <?php endif; ?>
                    <div class="navbar-title-group d-flex flex-column justify-content-center ms-2">
                        <div class="navbar-app-name"><?= esc($appName) ?></div>
                        <div class="navbar-app-subtitle"><?= esc($appSubtitle) ?></div>
                    </div>
                </div>
            </a>

            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <i class="bi bi-list fs-2"></i>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto align-items-center">
                    <li class="nav-item"><a
                            class="nav-link <?= (current_url() == base_url() || current_url() == base_url('/')) ? 'active' : '' ?>"
                            href="<?= base_url() ?>"><i class="bi bi-house-door-fill me-1"></i> Beranda</a></li>
                    <li class="nav-item ms-lg-3"><a
                            class="nav-link <?= (strpos(current_url(), '/map') !== false) ? 'active' : '' ?>"
                            href="<?= base_url('map') ?>"><i class="bi bi-map-fill me-1"></i> Peta Interaktif</a></li>
                    <li class="nav-item ms-lg-3">
                        <a class="nav-link btn-portal" href="<?= base_url('auth/login') ?>">
                            <i class="bi bi-shield-lock-fill me-2"></i> Portal Petugas
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>


    <!-- <div class="flex-grow-1 app-main-content" style="display: flex; flex-direction: column;"> -->
    <div class="flex-grow-1 app-main-content">
        <?= $this->renderSection('content') ?>
    </div>

    <footer>
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6 text-md-start mb-2 mb-md-0">
                    <div>&copy; <?= date('Y') ?> DPMPTSP • KABUPATEN TANAH BUMBU</div>
                    <div class="small text-muted">Sistem Informasi Geografis Tata Ruang Terintegratif</div>
                </div>
                <div class="col-md-6 text-md-end">
                    <div class="small text-muted"><?= esc($footerText) ?></div>
                    <div class="small mt-1"><a href="mailto:info@tanahbumbu.go.id"><i class="bi bi-envelope-fill"></i>
                            info@tanahbumbu.go.id</a></div>
                </div>
            </div>
        </div>
    </footer>
    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script>const baseUrl = "<?= base_url() ?>";</script>
    <?= $this->renderSection('scripts') ?>
</body>

</html>