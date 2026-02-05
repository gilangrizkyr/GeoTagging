<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class ActivityTemplateSeeder extends Seeder
{
    public function run()
    {
        $data = [
            // Perdagangan
            ['nama_kegiatan' => 'Toko Kelontong', 'kategori' => 'Perdagangan', 'kbli_code' => '47111', 'deskripsi' => 'Toko retail skala kecil'],
            ['nama_kegiatan' => 'Minimarket', 'kategori' => 'Perdagangan', 'kbli_code' => '47112', 'deskripsi' => 'Toko retail modern'],
            ['nama_kegiatan' => 'Supermarket', 'kategori' => 'Perdagangan', 'kbli_code' => '47113', 'deskripsi' => 'Toko retail besar'],
            ['nama_kegiatan' => 'Toko Pakaian', 'kategori' => 'Perdagangan', 'kbli_code' => '47711', 'deskripsi' => 'Perdagangan eceran pakaian'],
            ['nama_kegiatan' => 'Toko Elektronik', 'kategori' => 'Perdagangan', 'kbli_code' => '47411', 'deskripsi' => 'Perdagangan eceran elektronik'],
            ['nama_kegiatan' => 'Apotek', 'kategori' => 'Perdagangan', 'kbli_code' => '47721', 'deskripsi' => 'Perdagangan eceran farmasi'],

            // Jasa
            ['nama_kegiatan' => 'Restoran', 'kategori' => 'Jasa', 'kbli_code' => '56101', 'deskripsi' => 'Jasa penyediaan makanan'],
            ['nama_kegiatan' => 'Kafe', 'kategori' => 'Jasa', 'kbli_code' => '56301', 'deskripsi' => 'Jasa penyediaan minuman'],
            ['nama_kegiatan' => 'Warung Makan', 'kategori' => 'Jasa', 'kbli_code' => '56102', 'deskripsi' => 'Jasa makanan skala kecil'],
            ['nama_kegiatan' => 'Salon Kecantikan', 'kategori' => 'Jasa', 'kbli_code' => '96021', 'deskripsi' => 'Jasa perawatan kecantikan'],
            ['nama_kegiatan' => 'Bengkel Motor', 'kategori' => 'Jasa', 'kbli_code' => '45401', 'deskripsi' => 'Jasa reparasi kendaraan bermotor'],
            ['nama_kegiatan' => 'Laundry', 'kategori' => 'Jasa', 'kbli_code' => '96011', 'deskripsi' => 'Jasa pencucian pakaian'],
            ['nama_kegiatan' => 'Fotokopi', 'kategori' => 'Jasa', 'kbli_code' => '82191', 'deskripsi' => 'Jasa fotokopi dan percetakan'],

            // Perkantoran
            ['nama_kegiatan' => 'Kantor Pemerintah', 'kategori' => 'Perkantoran', 'kbli_code' => '84111', 'deskripsi' => 'Administrasi pemerintahan umum'],
            ['nama_kegiatan' => 'Kantor Swasta', 'kategori' => 'Perkantoran', 'kbli_code' => '68100', 'deskripsi' => 'Kantor perusahaan swasta'],
            ['nama_kegiatan' => 'Bank', 'kategori' => 'Perkantoran', 'kbli_code' => '64191', 'deskripsi' => 'Jasa perbankan'],
            ['nama_kegiatan' => 'Asuransi', 'kategori' => 'Perkantoran', 'kbli_code' => '65111', 'deskripsi' => 'Jasa asuransi'],

            // Industri
            ['nama_kegiatan' => 'Industri Makanan', 'kategori' => 'Industri', 'kbli_code' => '10611', 'deskripsi' => 'Pengolahan hasil pertanian'],
            ['nama_kegiatan' => 'Industri Minuman', 'kategori' => 'Industri', 'kbli_code' => '11011', 'deskripsi' => 'Pengolahan minuman'],
            ['nama_kegiatan' => 'Industri Furniture', 'kategori' => 'Industri', 'kbli_code' => '31001', 'deskripsi' => 'Pembuatan furniture'],
            ['nama_kegiatan' => 'Industri Garmen', 'kategori' => 'Industri', 'kbli_code' => '14101', 'deskripsi' => 'Pembuatan pakaian jadi'],

            // Pendidikan
            ['nama_kegiatan' => 'TK/PAUD', 'kategori' => 'Pendidikan', 'kbli_code' => '85101', 'deskripsi' => 'Pendidikan anak usia dini'],
            ['nama_kegiatan' => 'SD/MI', 'kategori' => 'Pendidikan', 'kbli_code' => '85102', 'deskripsi' => 'Pendidikan dasar'],
            ['nama_kegiatan' => 'SMP/MTs', 'kategori' => 'Pendidikan', 'kbli_code' => '85311', 'deskripsi' => 'Pendidikan menengah pertama'],
            ['nama_kegiatan' => 'SMA/SMK', 'kategori' => 'Pendidikan', 'kbli_code' => '85321', 'deskripsi' => 'Pendidikan menengah atas'],
            ['nama_kegiatan' => 'Bimbel', 'kategori' => 'Pendidikan', 'kbli_code' => '85491', 'deskripsi' => 'Bimbingan belajar'],

            // Kesehatan
            ['nama_kegiatan' => 'Rumah Sakit', 'kategori' => 'Kesehatan', 'kbli_code' => '86101', 'deskripsi' => 'Pelayanan kesehatan rumah sakit'],
            ['nama_kegiatan' => 'Puskesmas', 'kategori' => 'Kesehatan', 'kbli_code' => '86102', 'deskripsi' => 'Pelayanan kesehatan masyarakat'],
            ['nama_kegiatan' => 'Klinik', 'kategori' => 'Kesehatan', 'kbli_code' => '86201', 'deskripsi' => 'Praktik dokter umum'],
            ['nama_kegiatan' => 'Praktek Dokter', 'kategori' => 'Kesehatan', 'kbli_code' => '86202', 'deskripsi' => 'Praktik dokter spesialis'],

            // Perumahan
            ['nama_kegiatan' => 'Rumah Tinggal Tunggal', 'kategori' => 'Perumahan', 'kbli_code' => '41001', 'deskripsi' => 'Rumah tinggal 1 keluarga'],
            ['nama_kegiatan' => 'Rumah Susun', 'kategori' => 'Perumahan', 'kbli_code' => '41002', 'deskripsi' => 'Hunian vertikal'],
            ['nama_kegiatan' => 'Kos-kosan', 'kategori' => 'Perumahan', 'kbli_code' => '68100', 'deskripsi' => 'Hunian sewa kamar'],

            // Perhotelan
            ['nama_kegiatan' => 'Hotel', 'kategori' => 'Perhotelan', 'kbli_code' => '55101', 'deskripsi' => 'Jasa akomodasi hotel'],
            ['nama_kegiatan' => 'Penginapan', 'kategori' => 'Perhotelan', 'kbli_code' => '55103', 'deskripsi' => 'Jasa akomodasi sederhana'],

            // Peribadatan
            ['nama_kegiatan' => 'Masjid', 'kategori' => 'Peribadatan', 'kbli_code' => '94911', 'deskripsi' => 'Tempat ibadah Islam'],
            ['nama_kegiatan' => 'Gereja', 'kategori' => 'Peribadatan', 'kbli_code' => '94912', 'deskripsi' => 'Tempat ibadah Kristen'],
            ['nama_kegiatan' => 'Pura', 'kategori' => 'Peribadatan', 'kbli_code' => '94913', 'deskripsi' => 'Tempat ibadah Hindu'],
            ['nama_kegiatan' => 'Vihara', 'kategori' => 'Peribadatan', 'kbli_code' => '94914', 'deskripsi' => 'Tempat ibadah Buddha'],
        ];

        $this->db->table('activity_templates')->insertBatch($data);

        echo "✅ Activity templates berhasil di-seed! Total: " . count($data) . " kegiatan\n";
    }
}