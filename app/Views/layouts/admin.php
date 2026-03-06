<!DOCTYPE html>
<?php
/** @var \CodeIgniter\View\View $this */
$settingsModel = new \App\Models\SettingsModel();
$role = session()->get('role');
$appName = $settingsModel->getValueWithRole('app_name', $role, 'Geotagging App');
$logoSidebar = $settingsModel->getValueWithRole('logo_sidebar', $role, '');
$headerColorGlobal = $settingsModel->getValue('header_color', '#0f172a');
$headerColor = $settingsModel->getValueWithRole('header_color', $role, $headerColorGlobal);
$appSubtitle = $settingsModel->getValueWithRole('app_subtitle', $role, 'SISTEM SPASIAL');
?>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        <?= ucfirst($role)?> Panel -
        <?= esc($appName)?>
    </title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=Outfit:wght@400;500;600;700;800&display=swap"
        rel="stylesheet">

    <!-- CSS Assets -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>
        :root {
            --sidebar-width: 300px;
            --sidebar-collapsed-width: 80px;
            --topbar-height: 80px;
            --radius-xl: 1.25rem;
            --radius-2xl: 1.5rem;

            /* Dynamic Primary Color */
            --primary: <?=esc($headerColor)?>;
            --primary-dark: #020617;
            --accent: #f59e0b;
            --bg-body: #f8fafc;
            --sidebar-bg: <?=esc($headerColor)?>;
            --sidebar-text: #94a3b8;
            --sidebar-active: #ffffff;
            --card-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1), 0 2px 4px -2px rgb(0 0 0 / 0.1);
        }

        /* Darken adjustments for background-aware roles */
        body.role-admin {
            --primary-dark: #020617;
        }

        body.role-operator {
            --primary-dark: #0f172a;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: var(--bg-body);
            color: #1e293b;
            min-height: 100vh;
            overflow-x: hidden;
        }

        h1,
        h2,
        h3,
        h4,
        h5,
        h6,
        .navbar-brand,
        .sidebar-header {
            font-family: 'Outfit', sans-serif;
        }

        /* Sidebar Styling */
        .sidebar {
            width: var(--sidebar-width);
            height: 100vh;
            background: var(--sidebar-bg);
            color: white;
            position: fixed;
            left: 0;
            top: 0;
            z-index: 1050;
            display: flex;
            flex-direction: column;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: 4px 0 15px rgba(0, 0, 0, 0.1);
        }

        .sidebar-header {
            padding: 2rem 1.5rem;
            height: auto;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
            overflow: visible;
            white-space: normal;
            position: relative;
        }

        .sidebar-menu {
            flex-grow: 1;
            padding: 1.5rem 1rem;
            overflow-y: auto;
            overflow-x: hidden;
        }

        .menu-label {
            font-size: 0.65rem;
            text-transform: uppercase;
            letter-spacing: 0.1em;
            color: rgba(255, 255, 255, 0.4);
            font-weight: 800;
            margin: 1.5rem 0 0.75rem 0.75rem;
            white-space: nowrap;
            transition: opacity 0.3s;
        }

        .sidebar-link {
            display: flex;
            align-items: center;
            padding: 0.875rem 1rem;
            color: var(--sidebar-text);
            text-decoration: none;
            border-radius: 0.75rem;
            margin-bottom: 0.25rem;
            font-size: 0.925rem;
            font-weight: 600;
            transition: all 0.2s ease;
            white-space: nowrap;
        }

        .sidebar-link i {
            width: 1.5rem;
            min-width: 1.5rem;
            margin-right: 1rem;
            font-size: 1.25rem;
            display: flex;
            justify-content: center;
        }

        .sidebar-link:hover {
            background: rgba(255, 255, 255, 0.05);
            color: #fff;
        }

        .sidebar-link.active {
            background: var(--primary);
            color: var(--sidebar-active);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
        }

        body.role-operator .sidebar-link.active {
            background: rgba(255, 255, 255, 0.15);
        }

        /* Compact Sidebar (Desktop) */
        body.sidebar-compact .sidebar {
            width: var(--sidebar-collapsed-width);
        }

        body.sidebar-compact .sidebar-header {
            padding: 1.5rem 0.5rem;
            height: auto;
        }

        body.sidebar-compact .sidebar-header .brand-text {
            opacity: 0;
            visibility: hidden;
            display: none;
        }

        body.sidebar-compact .sidebar-header img {
            height: 35px !important;
        }

        body.sidebar-compact .sidebar .menu-label,
        body.sidebar-compact .sidebar .sidebar-link span {
            opacity: 0;
            visibility: hidden;
            width: 0;
        }

        body.sidebar-compact .main-wrapper {
            margin-left: var(--sidebar-collapsed-width);
        }

        /* Main Wrapper */
        .main-wrapper {
            margin-left: var(--sidebar-width);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        /* Topbar */
        .topbar {
            height: var(--topbar-height);
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(12px);
            border-bottom: 1px solid #e2e8f0;
            display: flex;
            align-items: center;
            padding: 0 2rem;
            position: sticky;
            top: 0;
            z-index: 1000;
        }

        /* Toggle Buttons */
        .sidebar-toggle {
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 10px;
            color: var(--primary);
            background: transparent;
            border: none;
            transition: all 0.2s;
            margin-right: 1rem;
        }

        .sidebar-toggle:hover {
            background: rgba(0, 0, 0, 0.05);
        }

        .content-area {
            padding: 2rem;
            flex-grow: 1;
        }

        /* Backdrop for mobile */
        .sidebar-backdrop {
            position: fixed;
            top: 0;
            left: 0;
            width: 100vw;
            height: 100vh;
            background: rgba(0, 0, 0, 0.5);
            backdrop-filter: blur(4px);
            z-index: 1040;
            display: none;
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .sidebar-backdrop.show {
            display: block;
            opacity: 1;
        }

        /* Role Badge */
        .role-badge {
            font-size: 0.7rem;
            padding: 0.35rem 0.75rem;
            border-radius: 2rem;
            font-weight: 800;
            letter-spacing: 0.5px;
            text-transform: uppercase;
        }

        .badge-admin {
            background: #fee2e2;
            color: #991b1b;
            border: 1px solid #fecaca;
        }

        .badge-operator {
            background: #ccfbf1;
            color: #115e59;
            border: 1px solid #99f6e4;
        }

        /* Responsive */
        @media (max-width: 991.98px) {
            .sidebar {
                transform: translateX(-100%);
            }

            .sidebar.mobile-show {
                transform: translateX(0);
            }

            .main-wrapper {
                margin-left: 0 !important;
            }

            .topbar {
                padding: 0 1rem;
            }
        }

        /* UI Helpers */
        .card-premium {
            background: #ffffff;
            border-radius: var(--radius-xl);
            border: 1px solid #f1f5f9;
            box-shadow: 0 1px 3px 0 rgb(0 0 0 / 0.1), 0 1px 2px -1px rgb(0 0 0 / 0.1);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .card-premium:hover {
            transform: translateY(-4px);
            box-shadow: 0 20px 25px -5px rgb(0 0 0 / 0.1);
        }
    </style>
    <?= $this->renderSection('styles')?>
</head>

<body class="role-<?= $role?>">

    <!-- Backdrop for Mobile -->
    <div class="sidebar-backdrop" id="sidebarBackdrop"></div>

    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
        <div class="sidebar-header">
            <div class="d-flex flex-column align-items-center gap-2 text-center">
                <?php if ($logoSidebar): ?>
                <img src="<?= base_url($logoSidebar)?>" alt="Logo" style="height: 50px; width: auto;">
                <?php
else: ?>
                <div class="flex-shrink-0">
                    <i class="bi bi-geo-fill text-white fs-1"></i>
                </div>
                <?php
endif; ?>
                <div class="brand-text">
                    <div class="fw-800 fs-6 lh-1 text-white">
                        <?= esc($appName)?>
                    </div>
                    <div class="small fw-600 opacity-75 mt-2" style="font-size: 0.65rem; letter-spacing: 0.5px;">
                        <?= esc($appSubtitle)?>
                    </div>
                </div>
            </div>
            <!-- Close button for mobile -->
            <button class="btn border-0 text-white ms-auto d-lg-none p-0 position-absolute end-0 top-0 m-2" id="closeSidebar">
                <i class="bi bi-x-lg fs-4"></i>
            </button>
        </div>

        <div class="sidebar-menu">
            <div class="menu-label">Main Navigation</div>
            <a href="<?= base_url('dashboard')?>"
                class="sidebar-link <?=(uri_string() == 'dashboard') ? 'active' : ''?>">
                <i class="bi bi-speedometer2"></i> <span>Dashboard Overview</span>
            </a>

            <div class="menu-label">Spatial Data Management</div>
            <a href="<?= base_url('admin/rdtr')?>"
                class="sidebar-link <?=(strpos(uri_string(), 'admin/rdtr') !== false) ? 'active' : ''?>">
                <i class="bi bi-map"></i> <span>Rencana Detail (RDTR)</span>
            </a>
            <a href="<?= base_url('admin/rtrw')?>"
                class="sidebar-link <?=(strpos(uri_string(), 'admin/rtrw') !== false) ? 'active' : ''?>">
                <i class="bi bi-layers"></i> <span>Kawasan Wilayah (RTRW)</span>
            </a>

            <a href="<?= base_url('admin/settings')?>"
                class="sidebar-link <?=(uri_string() == 'admin/settings') ? 'active' : ''?>">
                <i class="bi bi-sliders2"></i> <span>System Configuration</span>
            </a>

            <?php if ($role == 'admin'): ?>
            <div class="menu-label">Super Administrator</div>
            <a href="<?= base_url('admin/audit-logs')?>"
                class="sidebar-link <?=(strpos(uri_string(), 'admin/audit-logs') !== false) ? 'active' : ''?>">
                <i class="bi bi-journal-text"></i> <span>Audit Activity Logs</span>
            </a>
            <a href="<?= base_url('admin/users')?>"
                class="sidebar-link <?=(strpos(uri_string(), 'admin/users') !== false) ? 'active' : ''?>">
                <i class="bi bi-people"></i> <span>Staff Management</span>
            </a>
            <?php
endif; ?>

            <div class="mt-auto pt-4 shadow-none">
                <a href="<?= base_url('auth/logout')?>"
                    class="sidebar-link text-danger border-top border-white border-opacity-10 pt-4 rounded-0">
                    <i class="bi bi-box-arrow-right"></i> <span>Sign Out Portal</span>
                </a>
            </div>
        </div>
    </div>

    <!-- Main Wrapper -->
    <div class="main-wrapper">
        <!-- Topbar -->
        <div class="topbar">
            <!-- Mobile Toggle -->
            <button class="sidebar-toggle d-lg-none" id="mobileToggle">
                <i class="bi bi-list fs-3"></i>
            </button>

            <!-- Desktop Toggle -->
            <button class="sidebar-toggle d-none d-lg-flex" id="desktopToggle">
                <i class="bi bi-text-indent-left fs-4" id="desktopToggleIcon"></i>
            </button>

            <div class="d-flex align-items-center w-100">
                <div class="d-none d-sm-flex flex-column">
                    <h5 class="mb-0 fw-800 text-dark">
                        <?= $this->renderSection('title')?>
                    </h5>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0" style="--bs-breadcrumb-divider: '•';">
                            <li class="breadcrumb-item small fw-600 text-muted">Management</li>
                            <li class="breadcrumb-item small fw-600 active text-primary">
                                <?= $this->renderSection('title')?>
                            </li>
                        </ol>
                    </nav>
                </div>

                <div class="ms-auto d-flex align-items-center gap-3 gap-md-4">
                    <!-- Notifications (Optional Detail) -->
                    <button class="btn p-2 text-muted position-relative d-none d-md-block">
                        <i class="bi bi-bell fs-5"></i>
                        <span
                            class="position-absolute top-0 start-100 translate-middle p-1 bg-danger border border-light rounded-circle"></span>
                    </button>

                    <div class="d-none d-md-flex flex-column text-end">
                        <span class="small fw-800 text-dark">
                            <?= session()->get('username')?>
                        </span>
                        <span class="role-badge badge-<?= $role?>">
                            <?= ucfirst($role)?> Access
                        </span>
                    </div>
                    <div class="dropdown">
                        <a href="#" class="d-block" data-bs-toggle="dropdown">
                            <img src="https://ui-avatars.com/api/?name=<?= session()->get('username')?>&background=random&size=40"
                                alt="Avatar" class="rounded-pill border border-2 border-white shadow-sm">
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end border-0 shadow-lg p-2 mt-3"
                            style="border-radius: 1rem; min-width: 200px;">
                            <li class="d-md-none p-3 border-bottom mb-2">
                                <div class="fw-800 mb-0">
                                    <?= session()->get('username')?>
                                </div>
                                <div class="small text-muted">
                                    <?= ucfirst($role)?> Profile
                                </div>
                            </li>
                            <li><a class="dropdown-item rounded-3 py-2 fw-600" href="<?= base_url('admin/settings')?>">
                                    <i class="bi bi-person me-2"></i> Profil & Pengaturan</a></li>
                            <li>
                                <hr class="dropdown-divider opacity-50">
                            </li>
                            <li><a class="dropdown-item rounded-3 py-2 fw-600 text-danger"
                                    href="<?= base_url('auth/logout')?>">
                                    <i class="bi bi-box-arrow-right me-2"></i> Log Out</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <!-- Content Area -->
        <div class="content-area">
            <?= $this->renderSection('content')?>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        $(document).ready(function () {
            const sidebar = $('#sidebar');
            const backdrop = $('#sidebarBackdrop');
            const desktopToggleIcon = $('#desktopToggleIcon');

            // Mobile Toggle
            $('#mobileToggle').on('click', function () {
                sidebar.addClass('mobile-show');
                backdrop.addClass('show');
                $('body').css('overflow', 'hidden');
            });

            // Close Mobile Sidebar
            $('#closeSidebar, #sidebarBackdrop').on('click', function () {
                sidebar.removeClass('mobile-show');
                backdrop.removeClass('show');
                $('body').css('overflow', 'auto');
            });

            // Desktop Toggle (Compact Mode)
            $('#desktopToggle').on('click', function () {
                const isCompact = $('body').hasClass('sidebar-compact');
                if (isCompact) {
                    $('body').removeClass('sidebar-compact');
                    desktopToggleIcon.removeClass('bi-text-indent-right').addClass('bi-text-indent-left');
                    localStorage.setItem('sidebar-mode', 'full');
                } else {
                    $('body').addClass('sidebar-compact');
                    desktopToggleIcon.removeClass('bi-text-indent-left').addClass('bi-text-indent-right');
                    localStorage.setItem('sidebar-mode', 'compact');
                }
            });

            // Persist Sidebar State
            const savedMode = localStorage.getItem('sidebar-mode');
            if (savedMode === 'compact') {
                $('body').addClass('sidebar-compact');
                desktopToggleIcon.removeClass('bi-text-indent-left').addClass('bi-text-indent-right');
            }
        });
    </script>
    <?= $this->renderSection('scripts')?>
</body>

</html>