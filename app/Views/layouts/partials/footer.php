<footer>
    <div class="container">
        <div class="row g-4 justify-content-between">
            <div class="col-lg-4 col-md-6">
                <div class="footer-brand mb-4">
                    <h4 class="fw-900 text-primary mb-1">
                        <?= esc($appName) ?>
                    </h4>
                    <p class="text-muted small">
                        <?= esc($appSlogan) ?>
                    </p>
                </div>
                <p class="text-muted mb-4 pe-lg-4">
                    <?= esc($agencyFooterDesc) ?>
                </p>

                <!-- Dynamic Social Media -->
                <?php if ($fbUrl || $igUrl || $ytUrl || $twUrl): ?>
                    <div class="d-flex gap-3">
                        <?php if ($fbUrl): ?><a href="<?= esc($fbUrl) ?>" target="_blank" class="social-btn"><i
                                    class="bi bi-facebook"></i></a>
                        <?php endif; ?>
                        <?php if ($igUrl): ?><a href="<?= esc($igUrl) ?>" target="_blank" class="social-btn"><i
                                    class="bi bi-instagram"></i></a>
                        <?php endif; ?>
                        <?php if ($ytUrl): ?><a href="<?= esc($ytUrl) ?>" target="_blank" class="social-btn"><i
                                    class="bi bi-youtube"></i></a>
                        <?php endif; ?>
                        <?php if ($twUrl): ?><a href="<?= esc($twUrl) ?>" target="_blank" class="social-btn"><i
                                    class="bi bi-twitter-x"></i></a>
                        <?php endif; ?>
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
                    <li><a href="#"><i class="bi bi-geo-alt-fill me-2 text-primary"></i>
                            <?= esc($footerText) ?>
                        </a>
                    </li>
                    <li><a href="mailto:<?= esc($contactEmail) ?>"><i class="bi bi-envelope-fill me-2 text-primary"></i>
                            <?= esc($contactEmail) ?>
                        </a></li>
                    <li><a href="tel:<?= esc($contactPhone) ?>"><i class="bi bi-telephone-fill me-2 text-primary"></i>
                            <?= esc($contactPhone) ?>
                        </a>
                    </li>
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
            <p class="mb-3 mb-md-0">&copy;
                <?= date('Y') ?>
                <?= esc($copyrightText) ?>. Seluruh Hak Cipta
                Dilindungi.
            </p>
        </div>
    </div>
</footer>