<!DOCTYPE html>
<html>

<head>
    <title>Laporan Zonasi RDTR</title>
    <style>
        body {
            font-family: sans-serif;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
        }
    </style>
</head>

<body>
    <div class="header">
        <h2>Laporan Data Zonasi RDTR</h2>
        <p>Dinas Penanaman Modal dan Pelayanan Terpadu Satu Pintu</p>
        <small>Tanggal Cetak:
            <?= date('d-m-Y H:i')?>
        </small>
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Zona</th>
                <th>Peruntukan</th>
                <th>Keterangan</th>
            </tr>
        </thead>
        <tbody>
            <?php $no = 1;
foreach ($zones as $zone): ?>
            <tr>
                <td>
                    <?= $no++?>
                </td>
                <td>
                    <?= $zone['nama_zona']?>
                </td>
                <td>
                    <?= $zone['peruntukan']?>
                </td>
                <td>
                    <?= $zone['keterangan']?>
                </td>
            </tr>
            <?php
endforeach; ?>
        </tbody>
    </table>
</body>

</html>