<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class SpatialDataIrregularSeeder extends Seeder
{
    public function run()
    {
        $db = \Config\Database::connect();

        // 0. Clear Previous Data
        $db->query("TRUNCATE TABLE rdtr_zones RESTART IDENTITY CASCADE");
        $db->query("TRUNCATE TABLE rtrw_areas RESTART IDENTITY CASCADE");

        /* 
           Organic Shared Points (A-K) to ensure no gaps
           --------------------------------------------
           A(-3.41, 115.95)   B(-3.41, 115.99)   C(-3.41, 116.03)
           D(-3.435, 115.94)  E(-3.44, 115.97)   F(-3.43, 116.01)
           G(-3.46, 115.96)   H(-3.455, 115.99)  I(-3.46, 116.03)
           J(-3.49, 115.95)   K(-3.485, 115.985) L(-3.49, 116.01)
        */

        $P = [
            'A' => [115.950, -3.410],
            'B' => [115.990, -3.410],
            'C' => [116.030, -3.410],
            'D' => [115.940, -3.435],
            'E' => [115.970, -3.440],
            'F' => [116.010, -3.430],
            'G' => [115.960, -3.460],
            'H' => [115.990, -3.455],
            'I' => [116.030, -3.460],
            'J' => [115.950, -3.490],
            'K' => [115.985, -3.485],
            'L' => [116.010, -3.490],
            'M' => [115.980, -3.425],
            'N' => [116.000, -3.445],
            'O' => [115.975, -3.475]
        ];

        $rdtrData = [
            [
                'nama' => 'IN-1',
                'sub' => 'Kawasan Industri Sarigadung',
                'color' => '#64748b',
                'p' => ['A', 'B', 'M', 'E', 'D'] // NW Zone
            ],
            [
                'nama' => 'TR-1',
                'sub' => 'Kawasan Bandara Bersujud',
                'color' => '#3b82f6',
                'p' => ['B', 'C', 'F', 'N', 'M'] // NE Zone
            ],
            [
                'nama' => 'R-1',
                'sub' => 'Permukiman Simpang Empat',
                'color' => '#f59e0b',
                'p' => ['D', 'E', 'G', 'J'] // West Zone
            ],
            [
                'nama' => 'KP-1',
                'sub' => 'Pusat Pemerintahan (Gunung Tinggi)',
                'color' => '#8b5cf6',
                'p' => ['E', 'M', 'N', 'H', 'G'] // Central Zone
            ],
            [
                'nama' => 'PJ-1',
                'sub' => 'Pusat Bisnis & Pelabuhan',
                'color' => '#ef4444',
                'p' => ['N', 'F', 'I', 'H'] // East Zone
            ],
            [
                'nama' => 'H-1',
                'sub' => 'Hutan Lindung & RTH',
                'color' => '#10b981',
                'p' => ['G', 'H', 'K', 'O'] // South Central
            ],
            [
                'nama' => 'W-1',
                'sub' => 'Wisata Bahari Pagatan',
                'color' => '#14b8a6',
                'p' => ['J', 'G', 'O', 'K'] // South West
            ],
            [
                'nama' => 'R-2',
                'sub' => 'Permukiman Kusan Hilir',
                'color' => '#f97316',
                'p' => ['K', 'H', 'I', 'L'] // South East
            ],
        ];

        foreach ($rdtrData as $rdtr) {
            $vertStr = "";
            foreach ($rdtr['p'] as $key) {
                $vertStr .= "{$P[$key][0]} {$P[$key][1]}, ";
            }
            // Close the polygon
            $vertStr .= "{$P[$rdtr['p'][0]][0]} {$P[$rdtr['p'][0]][1]}";

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

        // RTRW (Macro Background) - Keep it simple but different
        $rtrwData = [
            [
                'nama' => 'Kawasan Strategis Ekonomi',
                'fungsi' => 'Pengembangan Wilayah Pesisir',
                'color' => '#fde68a',
                'vertices' => [[115.90, -3.40], [116.10, -3.40], [116.10, -3.60], [115.90, -3.60]]
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
