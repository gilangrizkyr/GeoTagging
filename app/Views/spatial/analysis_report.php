<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <title>Laporan Analisis Spasial - DPMPTSP Tanah Bumbu</title>
    <style>
        /* A4 Page Setup */
        @page {
            size: A4;
            margin: 0;
        }

        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            color: #1a1a1a;
            line-height: 1.6;
            margin: 0;
            padding: 0;
            background: #fff;
            -webkit-print-color-adjust: exact;
        }

        #report-master {
            width: 100%;
        }

        .page-header-space {
            height: 2.0cm;
        }

        .page-footer-space {
            height: 2.0cm;
        }

        .page-body {
            padding-left: 2.5cm;
            padding-right: 2.5cm;
            font-size: 11pt;
        }

        /* Letterhead / Kop Surat */
        .kop-surat {
            display: table;
            width: 100%;
            border-bottom: 3px double #000;
            padding-bottom: 12px;
            margin-bottom: 25px;
            margin-top: 20px;
        }

        .logo-container {
            display: table-cell;
            vertical-align: middle;
            width: 75px;
        }

        .logo-container img {
            width: 70px;
            height: auto;
        }

        .text-container {
            display: table-cell;
            vertical-align: middle;
            text-align: center;
            padding-left: 15px;
        }

        .instansi-utama {
            font-size: 14pt;
            font-weight: bold;
            margin: 0;
            text-transform: uppercase;
        }

        .nama-dinas {
            font-size: 12pt;
            font-weight: bold;
            margin: 2px 0;
            text-transform: uppercase;
        }

        .alamat-dinas {
            font-size: 8pt;
            margin: 2px 0;
            color: #333;
        }

        /* Titles and Content */
        .doc-title {
            text-align: center;
            margin: 15px 0 25px 0;
        }

        .doc-title h3 {
            text-decoration: underline;
            margin-bottom: 3px;
            font-size: 12pt;
            text-transform: uppercase;
        }

        .doc-num {
            font-size: 9pt;
            color: #000;
            font-weight: bold;
        }

        .section {
            margin-bottom: 20px;
            page-break-inside: avoid;
        }

        .section-header {
            font-weight: bold;
            font-size: 10.5pt;
            margin-bottom: 8px;
            border-bottom: 1px solid #000;
            padding-bottom: 3px;
            text-transform: uppercase;
        }

        /* Tables */
        table.data-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 12px;
        }

        table.data-table th,
        table.data-table td {
            border: 1px solid #ccc;
            padding: 8px 10px;
            font-size: 9.5pt;
            vertical-align: top;
        }

        table.data-table th {
            background-color: #f8f9fa;
            text-align: left;
            width: 35%;
            font-weight: bold;
            color: #444;
        }

        .badge {
            display: inline-block;
            padding: 2px 8px;
            border-radius: 3px;
            font-weight: bold;
            font-size: 8pt;
            text-transform: uppercase;
        }

        .badge-success {
            background: #d1fae5;
            color: #065f46;
        }

        .badge-warning {
            background: #fef3c7;
            color: #92400e;
        }

        .badge-danger {
            background: #fee2e2;
            color: #991b1b;
        }

        .disclaimer {
            font-size: 8pt;
            line-height: 1.4;
            background: #f9fafb;
            border: 1px dashed #d1d5db;
            padding: 12px;
            margin-top: 20px;
            text-align: justify;
        }

        .signature-area {
            margin-top: 30px;
        }

        .signature-table {
            width: 100%;
            border: none;
        }

        .signature-table td {
            border: none;
            padding: 0;
            vertical-align: top;
        }

        .qr-box {
            width: 80px;
            height: 80px;
            border: 1px solid #000;
            display: block;
            margin: 0 auto 5px auto;
            position: relative;
        }

        .qr-box::after {
            content: "QR CODE";
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            font-size: 7pt;
            color: #999;
        }

        .signature-box {
            text-align: center;
            width: 250px;
        }

        .meta-info {
            font-size: 8pt;
            color: #666;
            margin-top: 40px;
        }

        @media print {
            .no-print {
                display: none;
            }
        }
    </style>
</head>

<body onload="window.print()">
    <table id="report-master">
        <thead>
            <tr>
                <td>
                    <div class="page-header-space"></div>
                </td>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>
                    <div class="page-body">
                        <!-- Kop Surat -->
                        <div class="kop-surat">
                            <div class="logo-container">
                                <img src="<?= base_url($app_logo ?: 'uploads/logo-default.png') ?>" alt="Logo">
                            </div>
                            <div class="text-container">
                                <p class="instansi-utama"><?= esc($agency_main_name) ?></p>
                                <p class="nama-dinas"><?= esc($agency_sub_name) ?></p>
                                <p class="alamat-dinas"><?= esc($agency_address) ?></p>
                                <p class="alamat-dinas"><?= esc($agency_contact) ?></p>
                            </div>
                        </div>

                        <!-- Judul Dokumen -->
                        <div class="doc-title">
                            <h3>LAPORAN INFORMASI TATA RUANG (INDIKATIF)</h3>
                            <p class="doc-num">Nomor: <?= $report_no ?></p>
                        </div>

                        <div class="content-body">
                            <p>Berdasarkan hasil analisis sistem informasi geospasial <strong>GeoTagging
                                    DPMPTSP</strong> pada lokasi koordinat yang diajukan, berikut adalah rincian
                                informasi pemanfaatan ruang selengkapnya:</p>

                            <!-- 1. Identifikasi Lokasi -->
                            <div class="section">
                                <div class="section-header">1. Identifikasi Geografis Lokasi</div>
                                <table class="data-table">
                                    <tr>
                                        <th>Garis Lintang (Latitude)</th>
                                        <td><?= esc($lat) ?></td>
                                    </tr>
                                    <tr>
                                        <th>Garis Bujur (Longitude)</th>
                                        <td><?= esc($lng) ?></td>
                                    </tr>
                                    <tr>
                                        <th>Status Akurasi Data</th>
                                        <td>
                                            <?php if ($match_type === 'exact'): ?>
                                                <span class="badge badge-success">Data Akurat (Interseksi Geometri)</span>
                                            <?php else: ?>
                                                <span class="badge badge-warning">Data Indikatif (Radius Kedekatan)</span>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                </table>
                            </div>

                            <!-- 2. RDTR Section -->
                            <?php if ($rdtr): ?>
                                <div class="section">
                                    <div class="section-header">2. Informasi Rencana Detail Tata Ruang (RDTR)</div>
                                    <table class="data-table">
                                        <tr>
                                            <th>Nama Zona / Sub-Zona</th>
                                            <td style="font-weight: bold;"><?= esc($rdtr['nama_zona']) ?> /
                                                <?= esc($rdtr['sub_zona'] ?: '-') ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Peruntukan Ruang Utama</th>
                                            <td><?= esc($rdtr['peruntukan']) ?></td>
                                        </tr>
                                        <tr>
                                            <th>Dasar Hukum / Regulasi</th>
                                            <td style="font-size: 8.5pt; font-style: italic;">
                                                <?= esc($rdtr['regulation_text'] ?: 'Peraturan Daerah tentang RDTR Kabupaten Tanah Bumbu') ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Legalitas / Sumber Data</th>
                                            <td style="font-size: 8.5pt;">
                                                Instansi:
                                                <strong><?= esc($rdtr['sumber_data'] ?: 'Dinas PUPR / DPMPTSP') ?></strong><br>
                                                Versi Data: <?= esc($rdtr['versi_data'] ?: 'v1.0') ?> (Berlaku s/d:
                                                <?= $rdtr['tanggal_berlaku'] ? date('d/m/Y', strtotime($rdtr['tanggal_berlaku'])) : 'Permanen' ?>)
                                            </td>
                                        </tr>
                                    </table>

                                    <!-- 3. ITBX Details -->
                                    <div class="section-header">3. Ketentuan Intensitas Bangunan (ITBX)</div>
                                    <table class="data-table">
                                        <tr>
                                            <th>KDB (Dasar Bangunan)</th>
                                            <td>Maks. <?= esc($rdtr['itbx']['kdb'] ?: '-') ?>%</td>
                                            <th>KLB (Lantai Bangunan)</th>
                                            <td>Maks. <?= esc($rdtr['itbx']['klb'] ?: '-') ?></td>
                                        </tr>
                                        <tr>
                                            <th>GSB (Sempadan Bangunan)</th>
                                            <td>Min. <?= esc($rdtr['itbx']['gsb'] ?: '-') ?> Meter</td>
                                            <th>KDH (Dasar Hijau)</th>
                                            <td>Min. <?= esc($rdtr['itbx']['kdh'] ?: '-') ?>%</td>
                                        </tr>
                                    </table>
                                </div>
                            <?php endif; ?>

                            <!-- 4. KBLI Analysis -->
                            <?php if (isset($kbli_validation)): ?>
                                <div class="section">
                                    <div class="section-header">4. Analisis Kesesuaian Kegiatan Bisnis (KBLI 2025)</div>
                                    <table class="data-table">
                                        <tr>
                                            <th>Kode & Nama Kegiatan</th>
                                            <td><strong><?= esc($kbli_validation['code']) ?></strong> -
                                                <?= esc($kbli_validation['name']) ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Hasil Validasi Sistem</th>
                                            <td style="font-weight: bold;">
                                                <?php if ($kbli_validation['allowed']): ?>
                                                    <span style="color: #059669;">✔ SESUAI / DIIZINKAN PADA ZONA INI</span>
                                                <?php else: ?>
                                                    <span style="color: #dc2626;">✖ TIDAK SESUAI / TIDAK DIIZINKAN PADA ZONA
                                                        INI</span>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            <?php endif; ?>

                            <!-- Disclaimer -->
                            <div class="disclaimer">
                                <strong>DISCLAIMER / PERNYATAAN:</strong><br>
                                <?= nl2br(esc($pdf_disclaimer)) ?>
                            </div>

                            <!-- Signature Area -->
                            <div class="signature-area">
                                <table class="signature-table">
                                    <tr>
                                        <td style="width: 50%;">
                                            <div class="meta-info">
                                                Dicetak pada: <?= date('d/m/Y H:i:s') ?><br>
                                                Report ID: <?= strtoupper(uniqid('TANBU-')) ?><br>
                                                Sistem Terverifikasi DPMPTSP Tanah Bumbu
                                            </div>
                                        </td>
                                        <td>
                                            <div class="signature-box" style="float: right;">
                                                <p style="margin-bottom: 50px;">
                                                    <?= esc($pejabat['lokasi']) ?>, <?= date('d F Y') ?><br>
                                                    <strong><?= esc($pejabat['jabatan']) ?></strong>
                                                </p>
                                                <?php if ($show_qr): ?>
                                                    <div class="qr-box">
                                                        <img src="https://chart.googleapis.com/chart?chs=150x150&cht=qr&chl=<?= urlencode(base_url('api/spatial/export-analysis?lat=' . $lat . '&lng=' . $lng . '&kbli=' . ($kbli_validation['code'] ?? ''))) ?>&choe=UTF-8"
                                                            alt="QR Verify">
                                                    </div>
                                                <?php endif; ?>
                                                <p>
                                                    <strong><u><?= esc($pejabat['nama']) ?></u></strong><br>
                                                    NIP. <?= esc($pejabat['nip']) ?>
                                                </p>
                                            </div>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </td>
            </tr>
        </tbody>
        <tfoot>
            <tr>
                <td>
                    <div class="page-footer-space"></div>
                </td>
            </tr>
        </tfoot>
    </table>
</body>

</html>