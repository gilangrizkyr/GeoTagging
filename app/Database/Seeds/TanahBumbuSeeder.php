<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class TanahBumbuSeeder extends Seeder
{
    public function run()
    {
        // Clean existing data
        $this->db->query('TRUNCATE rdtr_zones RESTART IDENTITY CASCADE');
        $this->db->query('TRUNCATE rtrw_areas RESTART IDENTITY CASCADE');

        // Tanah Bumbu (Batulicin) Coordinates: ~ -3.456, 115.982

        // ========================================
        // RDTR ZONES (Detail Planning - Smaller Areas)
        // ========================================

        $zones = [
            [
                'nama_zona' => 'KP-1',
                'peruntukan' => 'Zona Perkantoran Pemerintahan',
                'keterangan' => 'Kawasan perkantoran pemerintah kabupaten dan OPD. KDB 60%, KLB 3.0, ketinggian maksimal 4 lantai.',
                'color' => '#ef4444',
                'regulation_text' => 'Perda Kabupaten Tanah Bumbu No 2 Tahun 2024 tentang RDTR Batulicin',
                'kbli_allowed' => '84111,84120,84130',
                'kdb' => 60, 'klb' => 3.0, 'kdh' => 20, 'ktb' => 10, 'ketinggian_max' => 16, 'jumlah_lantai_max' => 4, 'gsb' => 10, 'gsl' => 15,
                'geom_wkt' => 'POLYGON((115.978 -3.452, 115.984 -3.452, 115.984 -3.458, 115.978 -3.458, 115.978 -3.452))'
            ],
            [
                'nama_zona' => 'K-1',
                'peruntukan' => 'Zona Perdagangan dan Jasa',
                'keterangan' => 'Kawasan perdagangan retail, pasar tradisional, dan jasa. KDB 70%, KLB 2.5.',
                'color' => '#f59e0b',
                'regulation_text' => 'Perda Kabupaten Tanah Bumbu No 2 Tahun 2024 tentang RDTR Batulicin',
                'kbli_allowed' => '47111,47211,56101,56210',
                'kdb' => 70, 'klb' => 2.5, 'kdh' => 10, 'ktb' => 5, 'ketinggian_max' => 20, 'jumlah_lantai_max' => 4, 'gsb' => 5, 'gsl' => 10,
                'geom_wkt' => 'POLYGON((115.982 -3.454, 115.988 -3.454, 115.988 -3.460, 115.982 -3.460, 115.982 -3.454))'
            ],
            [
                'nama_zona' => 'R-2',
                'peruntukan' => 'Zona Perumahan Kepadatan Sedang',
                'keterangan' => 'Perumahan dengan kepadatan sedang. KDB 50%, KLB 1.5, ketinggian maksimal 2 lantai.',
                'color' => '#22c55e',
                'regulation_text' => 'Perda Kabupaten Tanah Bumbu No 2 Tahun 2024 tentang RDTR Batulicin',
                'kbli_allowed' => '68100,41001',
                'kdb' => 50, 'klb' => 1.5, 'kdh' => 30, 'ktb' => 15, 'ketinggian_max' => 10, 'jumlah_lantai_max' => 2, 'gsb' => 5, 'gsl' => 8,
                'geom_wkt' => 'POLYGON((115.975 -3.460, 115.982 -3.460, 115.982 -3.468, 115.975 -3.468, 115.975 -3.460))'
            ],
            [
                'nama_zona' => 'RTH-1',
                'peruntukan' => 'Ruang Terbuka Hijau Kota',
                'keterangan' => 'Taman kota dan ruang publik. Dilarang mendirikan bangunan permanen kecuali fasilitas pendukung taman.',
                'color' => '#10b981',
                'regulation_text' => 'Perda Kabupaten Tanah Bumbu No 2 Tahun 2024 tentang RDTR Batulicin',
                'kbli_allowed' => '',
                'kdb' => 10, 'klb' => 0.1, 'kdh' => 80, 'ktb' => 5, 'ketinggian_max' => 5, 'jumlah_lantai_max' => 1, 'gsb' => 15, 'gsl' => 20,
                'geom_wkt' => 'POLYGON((115.985 -3.448, 115.990 -3.448, 115.990 -3.453, 115.985 -3.453, 115.985 -3.448))'
            ],
            [
                'nama_zona' => 'IN-2',
                'peruntukan' => 'Zona Industri Kecil Menengah',
                'keterangan' => 'Kawasan industri pengolahan hasil pertanian dan perkebunan. KDB 60%, KLB 2.0.',
                'color' => '#8b5cf6',
                'regulation_text' => 'Perda Kabupaten Tanah Bumbu No 2 Tahun 2024 tentang RDTR Batulicin',
                'kbli_allowed' => '10611,10711,15111',
                'kdb' => 60, 'klb' => 2.0, 'kdh' => 20, 'ktb' => 10, 'ketinggian_max' => 20, 'jumlah_lantai_max' => 2, 'gsb' => 10, 'gsl' => 15,
                'geom_wkt' => 'POLYGON((115.990 -3.455, 115.998 -3.455, 115.998 -3.463, 115.990 -3.463, 115.990 -3.455))'
            ]
        ];

        foreach ($zones as $z) {
            $wkt = $z['geom_wkt'];
            unset($z['geom_wkt']);
            $z['created_at'] = date('Y-m-d H:i:s');

            $fields = implode(', ', array_keys($z)) . ', geom';
            $placeholders = implode(', ', array_fill(0, count($z), '?')) . ', ST_GeomFromText(?, 4326)';

            $sql = "INSERT INTO rdtr_zones ($fields) VALUES ($placeholders)";
            $this->db->query($sql, array_merge(array_values($z), [$wkt]));
        }

        // ========================================
        // RTRW AREAS (Regional Planning - Larger Areas)
        // ========================================

        $areas = [
            [
                'nama_kawasan' => 'PKL Batulicin',
                'fungsi_kawasan' => 'Pusat Kegiatan Lokal sebagai pusat pelayanan pemerintahan, perdagangan, dan jasa skala kabupaten.',
                'color' => '#3b82f6',
                'geom_wkt' => 'POLYGON((115.970 -3.445, 116.000 -3.445, 116.000 -3.470, 115.970 -3.470, 115.970 -3.445))'
            ],
            [
                'nama_kawasan' => 'Kawasan Industri Terpadu Batulicin',
                'fungsi_kawasan' => 'Kawasan pengembangan industri hilir pertambangan batubara dan pengolahan hasil perkebunan kelapa sawit.',
                'color' => '#6366f1',
                'geom_wkt' => 'POLYGON((115.950 -3.430, 116.020 -3.430, 116.020 -3.500, 115.950 -3.500, 115.950 -3.430))'
            ],
            [
                'nama_kawasan' => 'Kawasan Pelabuhan Batulicin',
                'fungsi_kawasan' => 'Kawasan pelabuhan untuk kegiatan bongkar muat barang, logistik, dan transportasi laut antar pulau.',
                'color' => '#f59e0b',
                'geom_wkt' => 'POLYGON((115.995 -3.450, 116.015 -3.450, 116.015 -3.480, 115.995 -3.480, 115.995 -3.450))'
            ],
            [
                'nama_kawasan' => 'Kawasan Perkebunan Kelapa Sawit',
                'fungsi_kawasan' => 'Kawasan budidaya perkebunan kelapa sawit dan tanaman perkebunan lainnya.',
                'color' => '#84cc16',
                'geom_wkt' => 'POLYGON((115.920 -3.400, 116.050 -3.400, 116.050 -3.520, 115.920 -3.520, 115.920 -3.400))'
            ]
        ];

        foreach ($areas as $a) {
            $wkt = $a['geom_wkt'];
            unset($a['geom_wkt']);
            $a['created_at'] = date('Y-m-d H:i:s');

            $fields = implode(', ', array_keys($a)) . ', geom';
            $placeholders = implode(', ', array_fill(0, count($a), '?')) . ', ST_GeomFromText(?, 4326)';

            $sql = "INSERT INTO rtrw_areas ($fields) VALUES ($placeholders)";
            $this->db->query($sql, array_merge(array_values($a), [$wkt]));
        }

        echo "✅ Demo data Tanah Bumbu berhasil dibuat!\n";
    }
}