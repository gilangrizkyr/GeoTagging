<div class="navbar-container">
    <nav class="navbar navbar-expand-lg">
        <div class="container-fluid">
            <a class="navbar-brand" href="<?= base_url() ?>">
                <div class="brand-logos d-flex gap-1 gap-md-2 align-items-center">
                    <?php if (isset($logoNavbar1) && $logoNavbar1): ?>
                        <img src="<?= get_media_url($logoNavbar1) ?>" alt="Logo 1">
                    <?php endif; ?>
                    <?php if (isset($logoNavbar2) && $logoNavbar2): ?>
                        <img src="<?= get_media_url($logoNavbar2) ?>" alt="Logo 2" class="d-none d-lg-block">
                    <?php endif; ?>
                </div>
                <div class="d-flex flex-column">
                    <span class="app-name">
                        <?= esc($appName) ?>
                    </span>
                    <span class="app-subtitle">
                        <?= esc($appSlogan) ?>
                    </span>
                </div>
            </a>

            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
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