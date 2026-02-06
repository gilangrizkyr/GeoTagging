<!DOCTYPE html>
<?php
/** @var \CodeIgniter\View\View $this */
$settingsModel = new \App\Models\SettingsModel();
$role = session()->get('role'); // Use role if logged in, otherwise null
$appName = $settingsModel->getValueWithRole('app_name', $role, 'Geotagging App');
$appLogo = $settingsModel->getValueWithRole('app_logo', $role, '');
$headerColorGlobal = $settingsModel->getValue('header_color', '#b6b7deff');
$headerColor = $settingsModel->getValueWithRole('header_color', $role, $headerColorGlobal);
$appSubtitle = $settingsModel->getValueWithRole('app_subtitle', $role, 'Pusat Data Spasial');
?>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        <?= esc($appName)?>
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
                height: 100vh;
                height: -webkit-fill-available;
                overflow: hidden;
            }

            body {
                display: flex;
                flex-direction: column;
                overflow: hidden;
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
            background: var(--glass-bg) !important;
            backdrop-filter: var(--glass-blur);
            -webkit-backdrop-filter: var(--glass-blur);
            border: var(--glass-border);
            border-radius: 20px;
            padding: 0.6rem 0;
            z-index: 1050;
            box-shadow: var(--shadow-premium);
            margin: 16px 16px 8px 16px;
            top: 16px;
            transition: var(--transition-smooth);
        }

        .navbar-brand {
            font-weight: 800;
            font-family: 'Outfit', sans-serif;
            display: flex;
            align-items: center;
            gap: 16px;
            font-size: 1.4rem;
            color: #0f172a !important;
            transform: translateZ(0);
        }

        .brand-logo-container {
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--primary);
            font-size: 2rem;
            transition: var(--transition-bounce);
        }

        .navbar-brand:hover .brand-logo-container {
            transform: scale(1.1) rotate(5deg);
        }

        .nav-link {
            font-weight: 700;
            color: #64748b !important;
            padding: 10px 24px !important;
            border-radius: 50px;
            transition: var(--transition-bounce);
            font-size: 0.95rem;
        }

        .nav-link.active,
        .nav-link:hover {
            color: var(--primary) !important;
            background: rgba(99, 102, 241, 0.08);
        }

        .btn-portal {
            background: linear-gradient(135deg, var(--primary), #2c3e50);
            border: none;
            color: white !important;
            padding: 12px 32px !important;
            border-radius: 12px;
            font-weight: 700;
            box-shadow: var(--shadow-glow);
            transition: var(--transition-bounce);
        }

        .btn-portal:hover {
            transform: translateY(-3px) scale(1.02);
            box-shadow: 0 25px 45px -12px rgba(99, 102, 241, 0.45);
        }

        /* App Container */
        .app-main-content {
            padding: 8px 24px 24px 24px;
            display: flex;
            gap: 24px;
        }

        @media (min-width: 992px) {
            .app-main-content {
                flex: 1;
                min-height: 0;
                /* Critical for inner scrolling */
                overflow: hidden;
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
                display: block;
                padding: 16px;
            }
        }

        /* Elegant Sidebar */
        .floating-panel {
            width: 440px;
            background: var(--glass-bg);
            backdrop-filter: var(--glass-blur);
            -webkit-backdrop-filter: var(--glass-blur);
            border: var(--glass-border);
            border-radius: var(--radius-2xl);
            box-shadow: var(--shadow-premium);
            overflow: hidden;
            z-index: 1000;
            display: flex;
            flex-direction: column;
            max-height: calc(100vh - 160px);
            animation: slideIn 0.5s cubic-bezier(0.16, 1, 0.3, 1);
            transition: var(--transition-bounce);
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
            padding: 20px;
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.2) 0%, rgba(255, 255, 255, 0) 100%);
            border-bottom: 1px solid rgba(0, 0, 0, 0.03);
            position: relative;
        }

        .panel-header h5 {
            font-family: 'Outfit', sans-serif;
            font-weight: 800;
            font-size: 1.5rem;
            background: linear-gradient(to right, #0f172a, #334155);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            margin: 0;
            display: flex;
            align-items: center;
            gap: 14px;
        }

        .header-icon {
            width: 42px;
            height: 42px;
            background: rgba(99, 102, 241, 0.1);
            color: var(--primary);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.25rem;
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
            border: 12px solid white;
            box-shadow: var(--shadow-premium);
            overflow: hidden;
            position: relative;
            transform: translateZ(0);
        }

        #map {
            width: 100%;
            height: 100%;
            z-index: 1;
            border-radius: calc(var(--radius-3xl) - 12px);
        }

        /* Floating Controls & Search */
        .search-container {
            background: white;
            border-radius: 20px;
            padding: 8px;
            box-shadow: var(--shadow-premium);
            border: 1px solid #f1f5f9;
            transition: var(--transition-bounce);
        }

        .search-container:focus-within {
            transform: translateY(-2px);
            box-shadow: 0 15px 30px -10px rgba(0, 0, 0, 0.1);
            border-color: var(--primary-light);
        }

        .form-floating>.form-control {
            border: none;
            background: transparent;
            font-weight: 700;
            color: #0f172a;
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

        footer {
            padding: 0.75rem 0;
            background: white;
            border-top: 1px solid #e2e8f0;
            margin-top: 0;
            font-weight: 700;
            color: #94a3b8;
            letter-spacing: 0.05em;
            text-transform: uppercase;
            font-size: 0.75rem;
        }
    </style>
    <?= $this->renderSection('styles')?>
</head>

<body class="d-flex flex-column min-vh-100">
    <div class="bg-blob blob-1"></div>
    <div class="bg-blob blob-2"></div>

    <div class="mesh-background"></div>
    <div class="mesh-blob blob-1"></div>
    <div class="mesh-blob blob-2"></div>

    <nav class="navbar navbar-expand-lg sticky-top">
        <div class="container-fluid px-4 px-lg-5">
            <a class="navbar-brand" href="<?= base_url()?>">
                <div class="brand-logo-container">
                    <?php if ($appLogo): ?>
                    <img src="<?= base_url($appLogo)?>" alt="Logo" style="height: 55px;">
                    <?php
else: ?>
                    <i class="bi bi-geo-fill"></i>
                    <?php
endif; ?>
                </div>
            </a>

            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <i class="bi bi-list fs-2"></i>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto align-items-center">
                    <li class="nav-item"><a class="nav-link active" href="<?= base_url()?>">Peta Interaktif</a></li>
                    <li class="nav-item ms-lg-3">
                        <a class="nav-link btn-portal" href="<?= base_url('auth/login')?>">
                            <i class="bi bi-shield-lock-fill me-2"></i> Portal Petugas
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>


    <div class="flex-grow-1 app-main-content">
        <?= $this->renderSection('content')?>
    </div>

    <footer class="text-center">
        <div class="container">
            <div>&copy;
                <?= date('Y')?> DPMPTSP • KABUPATEN TANAH BUMBU
            </div>
            <div class="mt-2" style="font-size: 0.6rem; opacity: 0.7;">Sistem Informasi Geografis Tata Ruang
                Terintegratif</div>
        </div>
    </footer>
    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script>const baseUrl = "<?= base_url()?>";</script>
    <?= $this->renderSection('scripts')?>
</body>

</html>