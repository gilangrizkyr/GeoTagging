<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class SpatialDataSeeder extends Seeder
{
    public function run()
    {
        $db = \Config\Database::connect();

        // 1. DATA RDTR (10 Real-ish Zones in Tanah Bumbu)
        $rdtrData = [
            [
                'nama_zona' => 'KP-1',
                'sub_zona' => 'Perkantoran Pemerintah',
                'peruntukan' => 'Pusat Perkantoran Pemerintah Kabupaten Tanah Bumbu - Gunung Tinggi.',
                'color' => '#8b5cf6',
                'kdb' => 60,
                'klb' => 2.5,
                'kdh' => 20,
                'ktb' => 0,
                'gsb' => 15,
                'gsl' => 10,
                'ketinggian_max' => 20,
                'jumlah_lantai_max' => 5,
                'regulation_text' => 'Perda RDTR Kawasan Perkotaan Batulicin 2024',
                'arahan_pemanfaatan' => 'Prioritas untuk bangunan administrasi publik dan pelayanan masyarakat.',
                'center_lat' => -3.4565,
                'center_lng' => 115.9825
            ],
            [
                'nama_zona' => 'PL-2',
                'sub_zona' => 'Pelabuhan & Logistik',
                'peruntukan' => 'Kawasan Pelabuhan Batulicin dan Area Pergudangan Logistik.',
                'color' => '#1e40af',
                'kdb' => 70,
                'klb' => 1.5,
                'kdh' => 10,
                'gsb' => 10,
                'ketinggian_max' => 15,
                'regulation_text' => 'Rencana Induk Pelabuhan Nasional',
                'center_lat' => -3.4542,
                'center_lng' => 116.0028
            ],
            [
                'nama_zona' => 'PJ-1',
                'sub_zona' => 'Perdagangan & Jasa',
                'peruntukan' => 'Pusat Niaga dan Jasa Komersial Simpang Empat.',
                'color' => '#ef4444',
                'kdb' => 80,
                'klb' => 3.0,
                'kdh' => 10,
                'gsb' => 5,
                'ketinggian_max' => 24,
                'regulation_text' => 'Perda Zonasi Ekonomi Batulicin',
                'center_lat' => -3.4258,
                'center_lng' => 116.0021
            ],
            [
                'nama_zona' => 'TR-1',
                'sub_zona' => 'Transportasi Udara',
                'peruntukan' => 'Kawasan Bandar Udara Bersujud - Batulicin.',
                'color' => '#3b82f6',
                'kdb' => 30,
                'klb' => 0.5,
                'kdh' => 50,
                'gsb' => 50,
                'ketinggian_max' => 10,
                'regulation_text' => 'KKOP Bandara Bersujud Tanah Bumbu',
                'center_lat' => -3.4215,
                'center_lng' => 115.9962
            ],
            [
                'nama_zona' => 'R-2',
                'sub_zona' => 'Perumahan Kepadatan Sedang',
                'peruntukan' => 'Area Permukiman Penduduk Tungkaran Pangeran.',
                'color' => '#f59e0b',
                'kdb' => 60,
                'klb' => 1.2,
                'kdh' => 30,
                'gsb' => 3,
                'ketinggian_max' => 12,
                'center_lat' => -3.4350,
                'center_lng' => 115.9950
            ],
            [
                'nama_zona' => 'IN-3',
                'sub_zona' => 'Industri Berat',
                'peruntukan' => 'Kawasan Industri Batulicin (KIB) - Sarigadung.',
                'color' => '#4b5563',
                'kdb' => 60,
                'klb' => 1.0,
                'kdh' => 20,
                'gsb' => 20,
                'ketinggian_max' => 30,
                'regulation_text' => 'Kawasan Strategis Industri Tanah Bumbu',
                'center_lat' => -3.3985,
                'center_lng' => 115.9450
            ],
            [
                'nama_zona' => 'W-1',
                'sub_zona' => 'Wisata Bahari',
                'peruntukan' => 'Kawasan Strategis Pariwisata Pantai Pagatan.',
                'color' => '#10b981',
                'kdb' => 40,
                'klb' => 0.8,
                'kdh' => 40,
                'gsb' => 25,
                'ketinggian_max' => 10,
                'center_lat' => -3.6120,
                'center_lng' => 115.9015
            ],
            [
                'nama_zona' => 'H-1',
                'sub_zona' => 'Hutan Lindung / Mangrove',
                'peruntukan' => 'Kawasan Konservasi Mangrove Pesisir Kusan Hilir.',
                'color' => '#065f46',
                'kdb' => 5,
                'klb' => 0.1,
                'kdh' => 90,
                'gsb' => 100,
                'center_lat' => -3.6350,
                'center_lng' => 115.9150
            ],
            [
                'nama_zona' => 'SP-2',
                'sub_zona' => 'Sarana Pendidikan',
                'peruntukan' => 'Kawasan Institusi Pendidikan Terpadu Batulicin.',
                'color' => '#06b6d4',
                'kdb' => 50,
                'klb' => 1.5,
                'kdh' => 30,
                'gsb' => 10,
                'ketinggian_max' => 15,
                'center_lat' => -3.4450,
                'center_lng' => 115.9880
            ],
            [
                'nama_zona' => 'TB-1',
                'sub_zona' => 'Pertambangan Terintegrasi',
                'peruntukan' => 'Area Pendukung Operasional Tambang Angsana.',
                'color' => '#78350f',
                'kdb' => 20,
                'klb' => 0.2,
                'kdh' => 60,
                'gsb' => 50,
                'center_lat' => -3.6500,
                'center_lng' => 115.6500
            ],
        ];

        foreach ($rdtrData as $rdtr) {
            // Create a small 200m square polygon around center
            $size = 0.0018; // approx 200m
            $wkt = sprintf(
                "POLYGON((%f %f, %f %f, %f %f, %f %f, %f %f))",
                $rdtr['center_lng'] - $size,
                $rdtr['center_lat'] - $size,
                $rdtr['center_lng'] + $size,
                $rdtr['center_lat'] - $size,
                $rdtr['center_lng'] + $size,
                $rdtr['center_lat'] + $size,
                $rdtr['center_lng'] - $size,
                $rdtr['center_lat'] + $size,
                $rdtr['center_lng'] - $size,
                $rdtr['center_lat'] - $size
            );

            $this->db->query("INSERT INTO rdtr_zones (
                nama_zona, sub_zona, peruntukan, color, 
                kdb, klb, kdh, ktb, gsb, gsl, ketinggian_max, jumlah_lantai_max,
                regulation_text, arahan_pemanfaatan, geom
            ) VALUES (
                ?, ?, ?, ?,
                ?, ?, ?, ?, ?, ?, ?, ?,
                ?, ?, ST_GeomFromText(?, 4326)
            )", [
                $rdtr['nama_zona'],
                $rdtr['sub_zona'],
                $rdtr['peruntukan'],
                $rdtr['color'],
                $rdtr['kdb'],
                $rdtr['klb'],
                $rdtr['kdh'],
                $rdtr['ktb'] ?? 0,
                $rdtr['gsb'] ?? 0,
                $rdtr['gsl'] ?? 0,
                $rdtr['ketinggian_max'] ?? null,
                $rdtr['jumlah_lantai_max'] ?? null,
                $rdtr['regulation_text'] ?? null,
                $rdtr['arahan_pemanfaatan'] ?? null,
                $wkt
            ]);
        }

        // 2. DATA RTRW (Macro Zones)
        $rtrwData = [
            ['nama_kawasan' => 'Kawasan Perkotaan Batulicin', 'fungsi_kawasan' => 'Pusat Pemerintahan dan Jasa', 'color' => '#fde047', 'lat' => -3.450, 'lng' => 115.990],
            ['nama_kawasan' => 'Kawasan Industri Batulicin', 'fungsi_kawasan' => 'Pengembangan Ekonomi Industri Berat', 'color' => '#d1d5db', 'lat' => -3.400, 'lng' => 115.950],
            ['nama_kawasan' => 'Kawasan Wisata Pantai Pagatan', 'fungsi_kawasan' => 'Pariwisata dan Budaya Maritim', 'color' => '#86efac', 'lat' => -3.610, 'lng' => 115.900],
            ['nama_kawasan' => 'Kawasan Pelabuhan Samudera', 'fungsi_kawasan' => 'Gerbang Logistik Maritim Kalsel', 'color' => '#bfdbfe', 'lat' => -3.455, 'lng' => 116.030],
        ];

        foreach ($rtrwData as $rtrw) {
            $size = 0.015; // larger macro zones (approx 1.5km)
            $wkt = sprintf(
                "POLYGON((%f %f, %f %f, %f %f, %f %f, %f %f))",
                $rtrw['lng'] - $size,
                $rtrw['lat'] - $size,
                $rtrw['lng'] + $size,
                $rtrw['lat'] - $size,
                $rtrw['lng'] + $size,
                $rtrw['lat'] + $size,
                $rtrw['lng'] - $size,
                $rtrw['lat'] + $size,
                $rtrw['lng'] - $size,
                $rtrw['lat'] - $size
            );

            $this->db->query("INSERT INTO rtrw_areas (nama_kawasan, fungsi_kawasan, color, geom) 
                              VALUES (?, ?, ?, ST_GeomFromText(?, 4326))",
                [$rtrw['nama_kawasan'], $rtrw['fungsi_kawasan'], $rtrw['color'], $wkt]
            );
        }
    }
}
