<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class SpatialDataTanahBumbuSeeder extends Seeder
{
    public function run()
    {
        $db = \Config\Database::connect();

        // 0. Clear Previous Data
        $db->query("TRUNCATE TABLE rdtr_zones RESTART IDENTITY CASCADE");
        $db->query("TRUNCATE TABLE rtrw_areas RESTART IDENTITY CASCADE");

        // 1. KABUPATEN TANAH BUMBU BOUNDARY (RTRW / Macro Layer)
        // Approximate real polygon based on OSM Relation 12989883
        $regencyBoundary = [
            [115.365, -3.782], // Satui (West)
            [115.420, -3.105], // NW Corner
            [115.655, -2.952], // Mantewe (North)
            [116.082, -3.148], // NE Corner
            [116.025, -3.351], // Eastern Coast
            [116.035, -3.456], // Batulicin River Mouth
            [115.915, -3.601], // Pagatan (South)
            [115.455, -3.905], // SW Corner (Satui)
        ];

        $rbWkt = "POLYGON((" . implode(", ", array_map(fn($p) => "{$p[0]} {$p[1]}", array_merge($regencyBoundary, [$regencyBoundary[0]]))) . "))";

        $this->db->query("INSERT INTO rtrw_areas (nama_kawasan, fungsi_kawasan, color, geom) 
                          VALUES ('Kabupaten Tanah Bumbu', 'Wilayah Administrasi Utama', '#fde68a', ST_GeomFromText(?, 4326))",
            [$rbWkt]
        );

        // 2. DISTRICTS (RDTR / Interlocking Segments within the regency)
        // We divide the regency into 4 major functional zones for this demonstration

        $zones = [
            [
                'nama' => 'Batulicin & Simpang Empat',
                'sub' => 'Pusat Perkotaan & Jasa',
                'color' => '#ef4444',
                'vertices' => [
                    [115.980, -3.400],
                    [116.035, -3.400],
                    [116.035, -3.460],
                    [115.980, -3.460]
                ]
            ],
            [
                'nama' => 'Kusan Hilir (Pagatan)',
                'sub' => 'Kawasan Pariwisata & Budaya',
                'color' => '#14b8a6',
                'vertices' => [
                    [115.850, -3.500],
                    [116.010, -3.500],
                    [116.010, -3.650],
                    [115.850, -3.650]
                ]
            ],
            [
                'nama' => 'Satui & Angsana',
                'sub' => 'Kawasan Industri & Tambang',
                'color' => '#64748b',
                'vertices' => [
                    [115.350, -3.650],
                    [115.650, -3.650],
                    [115.650, -3.850],
                    [115.350, -3.850]
                ]
            ],
            [
                'nama' => 'Mantewe & Karang Bintang',
                'sub' => 'Kawasan Perkebunan & Kehutanan',
                'color' => '#10b981',
                'vertices' => [
                    [115.500, -3.050],
                    [115.850, -3.050],
                    [115.850, -3.400],
                    [115.500, -3.400]
                ]
            ],
        ];

        foreach ($zones as $z) {
            $vertStr = implode(", ", array_map(fn($p) => "{$p[0]} {$p[1]}", array_merge($z['vertices'], [$z['vertices'][0]])));
            $wkt = "POLYGON(($vertStr))";

            $this->db->query("INSERT INTO rdtr_zones (
                nama_zona, sub_zona, peruntukan, color, 
                kdb, klb, kdh, ktb, gsb, gsl, ketinggian_max, jumlah_lantai_max,
                regulation_text, arahan_pemanfaatan, geom
            ) VALUES (
                ?, ?, ?, ?,
                60, 2.5, 20, 0, 10, 5, 20, 5,
                'Perda RDTR Tanah Bumbu V.2026', 'Pemanfaatan ruang sesuai zonasi terpadu daerah.', 
                ST_GeomFromText(?, 4326)
            )", [
                $z['nama'],
                $z['sub'],
                $z['sub'],
                $z['color'],
                $wkt
            ]);
        }
    }
}
