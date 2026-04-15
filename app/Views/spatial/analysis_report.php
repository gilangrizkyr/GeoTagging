<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <title>Laporan Analisis Spasial - DPMPTSP Tanah Bumbu</title>
    <style>
        /* A4 Page Setup - Hiding Browser Headers/Footers */
        @page {
            size: A4;
            margin: 0;
            /* Clear browser-added headers */
        }

        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            color: #1a1a1a;
            line-height: 1.5;
            margin: 0;
            padding: 0;
            background: #fff;
            -webkit-print-color-adjust: exact;
        }

        /* Master Table for Consistent Multi-Page Margins */
        #report-master {
            width: 100%;
        }

        /* Top and Bottom Margins (Repeated on all pages) */
        .page-header-space {
            height: 2.5cm;
        }

        .page-footer-space {
            height: 2.5cm;
        }

        /* Content Container with Side Margins */
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
            margin-bottom: 30px;
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
            font-size: 16pt;
            font-weight: bold;
            margin: 0;
            text-transform: uppercase;
        }

        .nama-dinas {
            font-size: 13pt;
            font-weight: bold;
            margin: 2px 0;
            text-transform: uppercase;
        }

        .alamat-dinas {
            font-size: 8.5pt;
            margin: 2px 0;
            color: #333;
        }

        /* Titles and Content */
        .doc-title {
            text-align: center;
            margin: 20px 0 30px 0;
        }

        .doc-title h3 {
            text-decoration: underline;
            margin-bottom: 5px;
            font-size: 13pt;
            text-transform: uppercase;
        }

        .doc-num {
            font-size: 9pt;
            color: #555;
        }

        .content-body {
            text-align: justify;
        }

        .section {
            margin-bottom: 25px;
            page-break-inside: avoid;
        }

        .section-header {
            font-weight: bold;
            font-size: 10.5pt;
            margin-bottom: 10px;
            border-bottom: 1px solid #333;
            padding-bottom: 4px;
            text-transform: uppercase;
        }

        /* Tables */
        table.data-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
        }

        table.data-table th,
        table.data-table td {
            border: 1px solid #333;
            padding: 10px 12px;
            font-size: 10pt;
            vertical-align: top;
        }

        table.data-table th {
            background-color: #f5f5f5;
            text-align: left;
            width: 35%;
            font-weight: bold;
        }

        .zebra tr:nth-child(even) {
            background-color: #fcfcfc;
        }

        /* Badges & Misc */
        .badge {
            display: inline-block;
            padding: 4px 10px;
            border-radius: 3px;
            font-weight: bold;
            font-size: 9pt;
            border: 1px solid #ccc;
        }

        .badge-exact {
            background: #e6fffa;
            color: #234e52;
        }

        .badge-proximity {
            background: #fffaf0;
            color: #744210;
        }

        .disclaimer {
            font-size: 8.5pt;
            line-height: 1.4;
            background: #fdfdfd;
            border: 1px dashed #bbb;
            padding: 15px;
            margin-top: 30px;
            text-align: justify;
        }

        .signature-area {
            margin-top: 40px;
        }

        .signature-table {
            width: 100%;
            border: none;
        }

        .signature-table td {
            border: none;
            padding: 0;
            vertical-align: bottom;
        }

        .qr-placeholder {
            width: 90px;
            height: 90px;
            border: 1px solid #ccc;
            background: #fff;
            margin-bottom: 5px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 8pt;
            color: #999;
        }

        .meta-info {
            font-size: 8pt;
            color: #666;
        }

        .text-bold {
            font-weight: bold;
        }

        .text-center {
            text-align: center;
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
                                <?php if ($app_logo): ?>
                                    <img src="<?= base_url($app_logo) ?>" alt="Logo Kab">
                                <?php else: ?>
                                    <img src="<?= base_url('uploads/1772710068_31b8212d39fbe1b325c6.png') ?>"
                                        alt="Logo Kab">
                                <?php endif; ?>
                            </div>
                            <div class="text-container">
                                <p class="instansi-utama">PEMERINTAH KABUPATEN TANAH BUMBU</p>
                                <p class="nama-dinas">DINAS PENANAMAN MODAL DAN PELAYANAN TERPADU SATU PINTU</p>
                                <p class="alamat-dinas">Jl. Dharma Praja No. 1, Kel. Gunung Tinggi, Kec. Batulicin, Kab.
                                    Tanah Bumbu</p>
                                <p class="alamat-dinas">Email: dpmptsp@tanahbumbukab.go.id | Website:
                                    dpmptsp.tanahbumbukab.go.id</p>
                            </div>
                        </div>

                        <!-- Judul Dokumen -->
                        <div class="doc-title">
                            <h3>LAPORAN INFORMASI TATA RUANG (INDIKATIF)</h3>
                            <p class="doc-num">Nomor: <?= date('Y/m/d') ?>/GEO/<?= strtoupper(substr(uniqid(), -4)) ?>
                            </p>
                        </div>

                        <div class="content-body">
                            <p>Berdasarkan hasil analisis sistem informasi geospasial *GeoTagging* pada lokasi yang
                                diajukan, berikut adalah rincian informasi pemanfaatan ruang:</p>

                            <!-- Seksi 1 -->
                            <div class="section">
                                <div class="section-header">1. Identifikasi Lokasi</div>
                                <table class="data-table zebra">
                                    <tr>
                                        <th>Garis Lintang (Latitude)</th>
                                        <td><?= esc($lat) ?></td>
                                    </tr>
                                    <tr>
                                        <th>Garis Bujur (Longitude)</th>
                                        <td><?= esc($lng) ?></td>
                                    </tr>
                                    <tr>
                                        <th>Metode Pencocokan</th>
                                        <td>
                                            <?php if ($match_type === 'exact'): ?>
                                                <span class="badge badge-exact">DATA AKURAT (Interseksi Geometri)</span>
                                            <?php else: ?>
                                                <span class="badge badge-proximity">DATA INDIKATIF (Radius Kedekatan
                                                    100m)</span>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                </table>
                            </div>

                            <!-- Seksi 2: RDTR (Jika Ada) -->
                            <?php if ($rdtr): ?>
                                <div class="section">
                                    <div class="section-header">2. Rencana Detail Tata Ruang (RDTR)</div>
                                    <table class="data-table zebra">
                                        <tr>
                                            <th>Nama Zona / Sub-Zona</th>
                                            <td class="text-bold"><?= esc($rdtr['nama_zona']) ?> /
                                                <?= esc($rdtr['sub_zona'] ?? '-') ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Peruntukan Ruang</th>
                                            <td><?= esc($rdtr['peruntukan']) ?></td>
                                        </tr>
                                        <tr>
                                            <th>Dasar Hukum</th>
                                            <td><?= esc($rdtr['regulation_text'] ?? 'Peraturan Daerah tentang Rencana Detail Tata Ruang Wilayah Kabupaten Tanah Bumbu.') ?>
                                            </td>
                                        </tr>
                                    </table>
                                </div>

                                <!-- Seksi 3: ITBX (Jika RDTR Ada) -->
                                <div class="section">
                                    <div class="section-header">3. Ketentuan Intensitas Pemanfaatan Ruang (ITBX)</div>
                                    <table class="data-table">
                                        <tr>
                                            <th>Koefisien Dasar Bangunan (KDB)</th>
                                            <td>Maksimal <?= esc($rdtr['itbx']['kdb'] ?? '-') ?>%</td>
                                        </tr>
                                        <tr>
                                            <th>Koefisien Lantai Bangunan (KLB)</th>
                                            <td>Maksimal <?= esc($rdtr['itbx']['klb'] ?? '-') ?></td>
                                        </tr>
                                        <tr>
                                            <th>Garis Sempadan Bangunan (GSB)</th>
                                            <td>Minimal <?= esc($rdtr['itbx']['gsb'] ?? '-') ?> Meter</td>
                                        </tr>
                                        <tr>
                                            <th>Garis Sempadan Lahan (GSL)</th>
                                            <td>Minimal <?= esc($rdtr['itbx']['gsl'] ?? '-') ?> Meter</td>
                                        </tr>
                                        <tr>
                                            <th>Koefisien Dasar Hijau (KDH)</th>
                                            <td>Minimal <?= esc($rdtr['itbx']['kdh'] ?? '-') ?>%</td>
                                        </tr>
                                        <tr>
                                            <th>Ketinggian Bangunan</th>
                                            <td>Maksimal <?= esc($rdtr['itbx']['ketinggian_max'] ?? '-') ?> Meter</td>
                                        </tr>
                                    </table>
                                </div>
                            <?php endif; ?>

                            <!-- Seksi Tambahan: RTRW -->
                            <?php if ($rtrw): ?>
                                <div class="section">
                                    <div class="section-header"><?= ($rdtr ? '4' : '2') ?>. Rencana Tata Ruang Wilayah
                                        (RTRW)</div>
                                    <table class="data-table zebra">
                                        <tr>
                                            <th>Nama Kawasan</th>
                                            <td class="text-bold"><?= esc($rtrw['nama_kawasan']) ?></td>
                                        </tr>
                                        <tr>
                                            <th>Fungsi Utama Kawasan</th>
                                            <td><?= esc($rtrw['fungsi_kawasan']) ?></td>
                                        </tr>
                                        <tr>
                                            <th>Dasar Hukum</th>
                                            <td>Peraturan Daerah Kabupaten Tanah Bumbu tentang Rencana Tata Ruang Wilayah.
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            <?php endif; ?>

                            <?php if (isset($kbli_validation)): ?>
                                <!-- Seksi KBLI -->
                                <div class="section">
                                    <div class="section-header"><?= ($rdtr ? ($rtrw ? '5' : '4') : ($rtrw ? '3' : '2')) ?>.
                                        Analisis Kesesuaian Kegiatan Bisnis (KBLI)</div>
                                    <table class="data-table zebra">
                                        <tr>
                                            <th>Kode KBLI</th>
                                            <td><?= esc($kbli_validation['code']) ?></td>
                                        </tr>
                                        <tr>
                                            <th>Jenis Kegiatan</th>
                                            <td><?= esc($kbli_validation['name']) ?></td>
                                        </tr>
                                        <tr>
                                            <th>Hasil Analisis Sistem</th>
                                            <td class="text-bold">
                                                <?= $kbli_validation['allowed'] ? '<span style="color: green;">SESUAI / DIIZINKAN</span>' : '<span style="color: red;">TIDAK SESUAI / DILARANG</span>' ?>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            <?php endif; ?>

                            <!-- Disclaimer -->
                            <div class="disclaimer">
                                <span class="text-bold">CATATAN PENTING:</span><br>
                                Laporan ini dihasilkan secara otomatis oleh sistem GeoTagging DPMPTSP Tanah Bumbu.
                                Laporan ini bersifat <span class="text-bold">INDIKATIF</span> dan hanya bertujuan
                                sebagai informasi awal bagi pemohon. Dokumen ini <span class="text-bold">BUKAN</span>
                                merupakan izin final, bukan dokumen KKPR, dan tidak memiliki kekuatan hukum dasar
                                konstruksi. Validasi resmi wajib melalui sistem OSS-RBA.
                            </div>

                            <!-- Signature Area -->
                            <div class="signature-area">
                                <table class="signature-table">
                                    <tr>
                                        <td>
                                            <div class="meta-info">
                                                Dicetak pada: <?= date('d/m/Y H:i:s') ?><br>
                                                ID: <?= strtoupper(uniqid('GEO-TANBU-')) ?><br>
                                                Dokumen sah dihasilkan secara sistemik.
                                            </div>
                                        </td>
                                        <td style="width: 120px; text-align: center;">
                                            <div class="qr-placeholder">QR VERIFIKASI</div>
                                            <div class="meta-info text-bold">SISTEM TERVALIDASI</div>
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