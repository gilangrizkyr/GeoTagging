<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class SpatialSeeder extends Seeder
{
    public function run()
    {
        // Clean existing data first to avoid clutter
        $this->db->table('rdtr_zones')->truncate();
        $this->db->table('rtrw_areas')->truncate();

        // Tanah Bumbu (Batulicin) Coordinates: ~ -3.456, 115.982

        // 1. Seed RDTR Zones (Batulicin Central)

        // Zona Perkantoran Batulicin
        $this->db->query("INSERT INTO rdtr_zones (nama_zona, peruntukan, keterangan, color, regulation_text, geom, created_at) VALUES (
            'KT-1', 
            'Zona Perkantoran Pemerintah Kabupaten', 
            'Pusat perkantoran Setda Tanah Bumbu dan OPD.', 
            '#ef4444', 
            'Perda No 2 Tahun 2024 tentang RDTR Batulicin',
            ST_GeomFromText('POLYGON((115.975 -3.450, 115.985 -3.450, 115.985 -3.460, 115.975 -3.460, 115.975 -3.450))', 4326),
            NOW()
        )");

        // Zona Hijau (Taman Batulicin)
        $this->db->query("INSERT INTO rdtr_zones (nama_zona, peruntukan, keterangan, color, regulation_text, geom, created_at) VALUES (
            'H-1', 
            'Ruang Terbuka Hijau (Hutan Kota)', 
            'Kawasan lindung perkotaan dan paru-paru kota.', 
            '#22c55e', 
            'Perda No 2 Tahun 2024 tentang RDTR Batulicin',
            ST_GeomFromText('POLYGON((115.980 -3.445, 115.990 -3.445, 115.990 -3.455, 115.980 -3.455, 115.980 -3.445))', 4326),
            NOW()
        )");

        // 2. Seed RTRW Areas (Tanah Bumbu District)

        // Kawasan Industri Batulicin
        $this->db->query("INSERT INTO rtrw_areas (nama_kawasan, fungsi_kawasan, color, geom, created_at) VALUES (
            'Kawasan Industri Terpadu Batulicin', 
            'Pusat pengelolaan industri hilir pertambangan dan perkebunan.', 
            '#6366f1', 
            ST_GeomFromText('POLYGON((115.950 -3.430, 116.020 -3.430, 116.020 -3.500, 115.950 -3.500, 115.950 -3.430))', 4326),
            NOW()
        )");

        // Kawasan Pelabuhan
        $this->db->query("INSERT INTO rtrw_areas (nama_kawasan, fungsi_kawasan, color, geom, created_at) VALUES (
            'Kawasan Pelabuhan Batulicin', 
            'Kegiatan logistik dan transportasi laut antar pulau.', 
            '#f59e0b', 
            ST_GeomFromText('POLYGON((115.990 -3.450, 116.010 -3.450, 116.010 -3.480, 115.990 -3.480, 115.990 -3.450))', 4326),
            NOW()
        )");
    }
}