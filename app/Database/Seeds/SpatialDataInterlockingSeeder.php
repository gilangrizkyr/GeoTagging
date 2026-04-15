<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class SpatialDataInterlockingSeeder extends Seeder
{
    public function run()
    {
        $db = \Config\Database::connect();

        // 0. Clear Previous Data (Use CASCADE for Postgres FKs)
        $db->query("TRUNCATE TABLE rdtr_zones RESTART IDENTITY CASCADE");
        $db->query("TRUNCATE TABLE rtrw_areas RESTART IDENTITY CASCADE");

        // Vertices Grid for Interlocking (Sharing vertices ensures zero gaps)
        // Lat: North to South
        $L0 = -3.410;
        $L1 = -3.435;
        $L2 = -3.455;
        $L3 = -3.475;
        $L4 = -3.500;
        // Lng: West to East
        $G0 = 115.940;
        $G1 = 115.965;
        $G2 = 115.985;
        $G3 = 116.005;
        $G4 = 116.030;

        $rdtrData = [
            // ROW 1
            [
                'nama' => 'IN-1',
                'sub' => 'Kawasan Industri Sarigadung',
                'color' => '#64748b',
                'vertices' => [[$G0, $L0], [$G2, $L0], [$G2, $L1], [$G1, $L1], [$G0, $L1]]
            ],
            [
                'nama' => 'TR-1',
                'sub' => 'Kawasan Bandara Bersujud',
                'color' => '#3b82f6',
                'vertices' => [[$G2, $L0], [$G4, $L0], [$G4, $L1], [$G2, $L1]]
            ],
            // ROW 2
            [
                'nama' => 'R-1',
                'sub' => 'Permukiman Simpang Empat',
                'color' => '#f59e0b',
                'vertices' => [[$G0, $L1], [$G1, $L1], [$G1, $L2], [$G0, $L2]]
            ],
            [
                'nama' => 'KP-1',
                'sub' => 'Pusat Pemerintahan (Gunung Tinggi)',
                'color' => '#8b5cf6',
                'vertices' => [[$G1, $L1], [$G3, $L1], [$G3, $L2], [$G1, $L2]]
            ],
            [
                'nama' => 'PJ-1',
                'sub' => 'Pusat Bisnis Batulicin',
                'color' => '#ef4444',
                'vertices' => [[$G3, $L1], [$G4, $L1], [$G4, $L2], [$G3, $L2]]
            ],
            // ROW 3
            [
                'nama' => 'H-1',
                'sub' => 'Hutan Kota & Sabuk Hijau',
                'color' => '#10b981',
                'vertices' => [[$G0, $L2], [$G2, $L2], [$G2, $L3], [$G0, $L3]]
            ],
            [
                'nama' => 'SP-1',
                'sub' => 'Kawasan Pendidikan Terpadu',
                'color' => '#06b6d4',
                'vertices' => [[$G2, $L2], [$G3, $L2], [$G3, $L3], [$G2, $L3]]
            ],
            [
                'nama' => 'PL-1',
                'sub' => 'Pelabuhan Samudera Batulicin',
                'color' => '#1e40af',
                'vertices' => [[$G3, $L2], [$G4, $L2], [$G4, $L4], [$G3, $L4], [$G3, $L3]]
            ],
            // ROW 4 (Coastal/Southern)
            [
                'nama' => 'W-1',
                'sub' => 'Kawasan Wisata Bahari Pagatan',
                'color' => '#14b8a6',
                'vertices' => [[$G0, $L3], [$G2, $L3], [$G2, $L4], [$G0, $L4]]
            ],
            [
                'nama' => 'R-2',
                'sub' => 'Permukiman Kusan Hilir',
                'color' => '#f97316',
                'vertices' => [[$G2, $L3], [$G3, $L3], [$G3, $L4], [$G2, $L4]]
            ],
        ];

        foreach ($rdtrData as $rdtr) {
            $vertStr = "";
            foreach ($rdtr['vertices'] as $v) {
                $vertStr .= "{$v[0]} {$v[1]}, ";
            }
            // Close the polygon
            $vertStr .= "{$rdtr['vertices'][0][0]} {$rdtr['vertices'][0][1]}";

            $wkt = "POLYGON(($vertStr))";

            $this->db->query("INSERT INTO rdtr_zones (
                nama_zona, sub_zona, peruntukan, color, 
                kdb, klb, kdh, ktb, gsb, gsl, ketinggian_max, jumlah_lantai_max,
                regulation_text, arahan_pemanfaatan, geom
            ) VALUES (
                ?, ?, ?, ?,
                60, 2.5, 20, 0, 10, 5, 20, 5,
                'Perda RDTR Tanah Bumbu V.2026', 'Pemanfaatan ruang sesuai zonasi terpadu.', 
                ST_GeomFromText(?, 4326)
            )", [
                $rdtr['nama'],
                $rdtr['sub'],
                $rdtr['sub'],
                $rdtr['color'],
                $wkt
            ]);
        }

        // Add 2 Big RTRW Layers as backdrop
        $rtrwData = [
            [
                'nama' => 'Kawasan Lindung Gambut',
                'fungsi' => 'Perlindungan Ekosistem Basah',
                'color' => '#064e3b',
                'vertices' => [[115.85, -3.35], [116.15, -3.35], [116.15, -3.55], [115.85, -3.55]]
            ],
            [
                'nama' => 'Kawasan Budidaya Pertanian',
                'fungsi' => 'Ketahanan Pangan Daerah',
                'color' => '#fde68a',
                'vertices' => [[115.65, -3.55], [116.15, -3.55], [116.15, -3.85], [115.65, -3.85]]
            ]
        ];

        foreach ($rtrwData as $rtrw) {
            $vertStr = "";
            foreach ($rtrw['vertices'] as $v) {
                $vertStr .= "{$v[0]} {$v[1]}, ";
            }
            $vertStr .= "{$rtrw['vertices'][0][0]} {$rtrw['vertices'][0][1]}";
            $wkt = "POLYGON(($vertStr))";

            $this->db->query("INSERT INTO rtrw_areas (nama_kawasan, fungsi_kawasan, color, geom) 
                              VALUES (?, ?, ?, ST_GeomFromText(?, 4326))",
                [$rtrw['nama'], $rtrw['fungsi'], $rtrw['color'], $wkt]
            );
        }
    }
}
