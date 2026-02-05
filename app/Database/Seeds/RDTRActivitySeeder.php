<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class RDTRActivitySeeder extends Seeder
{
    public function run()
    {
        $this->db->table('rdtr_activities')->truncate();

        $activities = [
            // KP-1 (Pemerintahan)
            ['rdtr_zone_id' => 1, 'nama_kegiatan' => 'Kantor Pemerintah', 'kategori_kegiatan' => 'Perkantoran', 'status' => 'I'],
            ['rdtr_zone_id' => 1, 'nama_kegiatan' => 'Masjid/Musholla', 'kategori_kegiatan' => 'Peribadatan', 'status' => 'I'],
            ['rdtr_zone_id' => 1, 'nama_kegiatan' => 'Kantin Pegawai', 'kategori_kegiatan' => 'Jasa', 'status' => 'T', 'syarat' => 'Hanya untuk internal kantor'],

            // IN-2 (Industri)
            ['rdtr_zone_id' => 5, 'nama_kegiatan' => 'Industri Makanan', 'kategori_kegiatan' => 'Industri', 'status' => 'I'],
            ['rdtr_zone_id' => 5, 'nama_kegiatan' => 'Gudang Logistik', 'kategori_kegiatan' => 'Industri', 'status' => 'I'],
            ['rdtr_zone_id' => 5, 'nama_kegiatan' => 'Rumah Tinggal', 'kategori_kegiatan' => 'Perumahan', 'status' => 'X', 'syarat' => 'Dilarang di kawasan industri berat'],
        ];

        $this->db->table('rdtr_activities')->insertBatch($activities);
        echo "✅ RDTR Activities seeded!\n";
    }
}