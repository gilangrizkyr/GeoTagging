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
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=Outfit:wght@400;500;600;700&display=swap"
        rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />

    <style>
        :root {
            --primary: <?=esc($headerColor)?>;
            --primary-dark: #4338ca;
            --primary-light: #818cf8;
            --secondary: #64748b;
            --accent: #f59e0b;
            --bg-main: #f0f2f5;

            /* Modern Gradients */
            --grad-primary: linear-gradient(135deg, var(--primary), var(--primary-dark));
            --grad-surface: linear-gradient(180deg, rgba(255, 255, 255, 0.9) 0%, rgba(255, 255, 255, 0.7) 100%);

            /* Premium Tokens */
            --radius-3xl: 32px;
            --radius-2xl: 24px;
            --radius-xl: 18px;

            --shadow-premium: 0 10px 30px -5px rgba(0, 0, 0, 0.08), 0 4px 12px -2px rgba(0, 0, 0, 0.04);
            --shadow-glow: 0 20px 40px -10px rgba(99, 102, 241, 0.3);
            --transition-bounce: all 0.5s cubic-bezier(0.34, 1.56, 0.64, 1);
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: var(--bg-main);
            color: #1e293b;
            overflow-x: hidden;
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
            background: rgba(255, 255, 255, 0.8) !important;
            backdrop-filter: blur(25px) saturate(180%);
            -webkit-backdrop-filter: blur(25px) saturate(180%);
            border-bottom: 1px solid rgba(255, 255, 255, 0.3);
            padding: 1rem 0;
            z-index: 1050;
            box-shadow: 0 4px 30px rgba(0, 0, 0, 0.03);
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
            width: 48px;
            height: 48px;
            background: var(--grad-primary);
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            box-shadow: 0 8px 16px -4px rgba(99, 102, 241, 0.4);
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
            background: var(--grad-primary);
            border: none;
            color: white !important;
            padding: 12px 32px !important;
            border-radius: 14px;
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
            height: calc(100vh - 88px);
            padding: 24px;
            display: flex;
            gap: 24px;
        }

        /* Elegant Sidebar */
        .floating-panel {
            width: 440px;
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(20px);
            border-radius: var(--radius-2xl);
            border: 1px solid rgba(255, 255, 255, 0.7);
            box-shadow: var(--shadow-premium);
            display: flex;
            flex-direction: column;
            overflow: hidden;
            transition: var(--transition-bounce);
            z-index: 1000;
        }

        .panel-header {
            padding: 32px;
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
            padding: 32px;
            overflow-y: auto;
            flex-grow: 1;
            scrollbar-width: none;
        }

        .panel-body::-webkit-scrollbar {
            display: none;
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

            .floating-panel {
                position: fixed;
                bottom: 20px;
                left: 20px;
                right: 20px;
                width: auto;
                height: 60vh;
                transform: translateY(0);
                box-shadow: 0 -10px 40px rgba(0, 0, 0, 0.15);
            }

            .map-frame {
                height: 75vh;
                border: 6px solid white;
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

    <nav class="navbar navbar-expand-lg fixed-top">
        <div class="container-fluid px-4 px-lg-5">
            <a class="navbar-brand" href="<?= base_url()?>">
                <div class="brand-logo-container">
                    <?php if ($appLogo): ?>
                    <img src="<?= base_url($appLogo)?>" alt="Logo" style="height: 28px;">
                    <?php
else: ?>
                    <i class="bi bi-geo-fill"></i>
                    <?php
endif; ?>
                </div>
                <div class="ms-3">
                    <div style="line-height: 1;">
                        <?= esc($appName)?>
                    </div>
                    <div
                        style="font-size: 0.65rem; color: var(--secondary); font-weight: 700; text-transform: uppercase; letter-spacing: 2px; margin-top: 4px;">
                        <?= esc($appSubtitle)?>
                    </div>
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

    <div style="height: 88px;"></div>

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
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>const baseUrl = "<?= base_url()?>";</script>
    <?= $this->renderSection('scripts')?>
</body>

</html>