<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

class KBLI extends BaseConfig
{
    /**
     * KBLI Reference Data (2025 — Tanah Bumbu)
     * Mapping KBLI codes (5-digit) to their respective business activity names.
     */
    public $reference = [
        // Pertanian, Kehutanan & Perikanan
        '01111' => 'Pertanian Padi',
        '01112' => 'Pertanian Jagung',
        '01113' => 'Pertanian Kedelai',
        '01116' => 'Pertanian Ubi Kayu',
        '01120' => 'Perkebunan Tebu',
        '01261' => 'Perkebunan Kelapa Sawit',
        '01262' => 'Perkebunan Karet',
        '01499' => 'Peternakan Lainnya',
        '02101' => 'Kehutanan — Tebang Pilih',
        '03111' => 'Penangkapan Ikan di Laut',
        '03212' => 'Pembenihan & Budidaya Ikan Air Tawar',

        // Pertambangan
        '05101' => 'Pertambangan Batubara',
        '06101' => 'Pertambangan Minyak Bumi',
        '06200' => 'Pertambangan Gas Alam',
        '07101' => 'Pertambangan Bijih Besi',
        '08101' => 'Penggalian Batu',

        // Industri Pengolahan
        '10611' => 'Industri Penggilingan Padi & Beras',
        '10612' => 'Industri Tepung Beras & Tepung Lainnya',
        '10710' => 'Industri Produk Roti & Kue',
        '10721' => 'Industri Gula',
        '10793' => 'Industri Kecap',
        '11011' => 'Industri Minuman Non-Alkohol',
        '13111' => 'Industri Pemintalan Benang',
        '14101' => 'Industri Pakaian Jadi (Konveksi)',
        '16211' => 'Industri Kayu Lapis',
        '16219' => 'Industri Pengolahan Kayu Lainnya',
        '20111' => 'Industri Kimia Dasar',
        '22192' => 'Industri Produk Karet',
        '23951' => 'Industri Semen & Bahan Bangunan',
        '25111' => 'Industri Produk Logam',
        '26200' => 'Industri Komputer & Elektronik',
        '29101' => 'Industri Kendaraan Bermotor',
        '31001' => 'Industri Furnitur Kayu',
        '31002' => 'Industri Furnitur Non-Kayu',

        // Pengadaan Listrik & Air
        '35101' => 'Pembangkitan & Distribusi Listrik',
        '36001' => 'Pengumpulan & Distribusi Air Bersih',
        '38211' => 'Pengelolaan Limbah Domestik',

        // Konstruksi
        '41001' => 'Konstruksi Gedung Hunian',
        '41002' => 'Konstruksi Gedung Perkantoran',
        '41003' => 'Konstruksi Mal & Pusat Perbelanjaan',
        '42101' => 'Konstruksi Jalan Raya',
        '42102' => 'Konstruksi Jembatan & Bendungan',

        // Perdagangan Besar & Eceran
        '45101' => 'Perdagangan Besar & Eceran Kendaraan Bermotor',
        '45401' => 'Bengkel & Reparasi Kendaraan Bermotor',
        '46101' => 'Perdagangan Besar Produk Pertanian',
        '46311' => 'Perdagangan Besar Beras',
        '46321' => 'Perdagangan Besar Gula',
        '46330' => 'Perdagangan Besar Minuman',
        '46441' => 'Perdagangan Besar Obat & Farmasi',
        '46691' => 'Perdagangan Besar Bahan Bakar Minyak',
        '46900' => 'Perdagangan Besar Lainnya',
        '47111' => 'Perdagangan Eceran Kelontong / Toko Campuran',
        '47112' => 'Minimarket',
        '47113' => 'Supermarket / Hypermarket',
        '47114' => 'Toko Serba Ada (Toserba)',
        '47411' => 'Perdagangan Eceran Alat Komunikasi & Elektronik',
        '47611' => 'Toko Buku & Alat Tulis',
        '47711' => 'Perdagangan Eceran Pakaian',
        '47712' => 'Perdagangan Eceran Sepatu & Aksesori',
        '47721' => 'Apotek / Toko Obat',
        '47731' => 'Toko Kacamata',
        '47741' => 'Toko Alat Kesehatan',
        '47771' => 'Toko Handphone & Aksesoris',
        '47781' => 'Toko Perhiasan & Emas',

        // Transportasi & Pergudangan
        '49310' => 'Angkutan Darat Penumpang (AKDP/AKAP)',
        '49410' => 'Angkutan Barang Jalan Raya',
        '51101' => 'Angkutan Udara Reguler',
        '52101' => 'Pergudangan & Penyimpanan',
        '52219' => 'Layanan Pendukung Transportasi Lainnya',
        '53101' => 'Pos & Layanan Kurir',

        // Akomodasi & Makan/Minum
        '55101' => 'Hotel Bintang',
        '55103' => 'Penginapan & Wisma',
        '55201' => 'Kontrakan / Kost-Kostan',
        '56101' => 'Restoran / Rumah Makan',
        '56102' => 'Warung & Kedai Makan',
        '56301' => 'Kafe & Kedai Kopi',
        '56302' => 'Kios Minuman Kekinian',

        // Informasi & Komunikasi
        '58110' => 'Penerbitan Buku',
        '58130' => 'Penerbitan Surat Kabar & Majalah',
        '60101' => 'Penyiaran Radio',
        '60201' => 'Penyiaran Televisi Swasta',
        '61100' => 'Layanan Telekomunikasi Kabel',
        '61200' => 'Layanan Telekomunikasi Nirkabel (Seluler)',
        '62010' => 'Pengembangan Perangkat Lunak / Software',
        '63120' => 'Portal Web & Platform Digital',

        // Keuangan & Asuransi
        '64191' => 'Bank Umum / Perbankan',
        '64921' => 'BPR / Koperasi Simpan Pinjam',
        '65111' => 'Asuransi Jiwa',
        '65121' => 'Asuransi Kerugian',
        '66199' => 'Pegadaian & Aktivitas Keuangan Lainnya',

        // Real Estat
        '68100' => 'Real Estat / Pengembang Properti',
        '68200' => 'Jasa Makelar & Agen Properti',

        // Jasa Profesional & Bisnis
        '69100' => 'Jasa Hukum & Pengacara',
        '69200' => 'Jasa Akuntansi & Audit',
        '70100' => 'Konsultasi Manajemen Bisnis',
        '71101' => 'Jasa Arsitek',
        '71102' => 'Jasa Insinyur & Teknik Sipil',
        '72101' => 'Penelitian & Pengembangan IPTEK',
        '73101' => 'Iklan & Periklanan',
        '74120' => 'Fotografi Komersial',
        '75000' => 'Klinik Hewan / Jasa Veteriner',

        // Administrasi & Pemerintahan
        '82191' => 'Fotokopi, Jasa Percetakan & Penyiapan Dokumen',
        '84111' => 'Administrasi Pemerintahan Umum',
        '84112' => 'Layanan Pajak & Perizinan',
        '84130' => 'Jaminan Sosial Wajib (BPJS)',

        // Pendidikan
        '85101' => 'Pendidikan Anak Usia Dini (PAUD)',
        '85102' => 'TK / Raudhatul Athfal',
        '85103' => 'SD dan Sederajat',
        '85311' => 'SMP / Madrasah Tsanawiyah',
        '85321' => 'SMA / SMK / Madrasah Aliyah',
        '85421' => 'Perguruan Tinggi — Politeknik',
        '85422' => 'Perguruan Tinggi — Universitas',
        '85491' => 'Bimbingan Belajar & Kursus',
        '85499' => 'Lembaga Pelatihan & Diklat Swasta',

        // Kesehatan & Sosial
        '86101' => 'Rumah Sakit Umum',
        '86102' => 'Puskesmas & Klinik Pratama',
        '86103' => 'Klinik Utama & Spesialis',
        '86201' => 'Praktik Dokter Umum',
        '86202' => 'Praktik Dokter Spesialis',
        '86301' => 'Praktik Dokter Gigi',
        '86401' => 'Praktik Bidan Mandiri',
        '86901' => 'Laboratorium Medis & Klinik Diagnostik',
        '88101' => 'Jasa Sosial Panti Asuhan',

        // Seni, Hiburan & Rekreasi
        '90001' => 'Pertunjukan Seni Budaya',
        '91011' => 'Museum & Perpustakaan',
        '91030' => 'Taman Kota & Wisata Alam',
        '93112' => 'Ruang Olahraga & Lapangan Indoor',
        '93113' => 'Gelanggang Olahraga',
        '93121' => 'Kolam Renang Umum',
        '93191' => 'Club Kebugaran & Gym',
        '93210' => 'Taman Rekreasi & Taman Bermain',
        '93291' => 'Pusat Hiburan Keluarga',

        // Jasa Lainnya
        '95110' => 'Reparasi Komputer & Perangkat Elektronik',
        '95210' => 'Reparasi Perabot Rumah Tangga',
        '96011' => 'Laundry & Jasa Cuci',
        '96021' => 'Salon Kecantikan & Spa',
        '96022' => 'Barber Shop / Pangkas Rambut',
        '96031' => 'Jasa Pemakaman',
        '96099' => 'Jasa Perorangan Lainnya',

        // Organisasi & Keagamaan
        '94911' => 'Organisasi Keagamaan Islam (Masjid/Musholla)',
        '94912' => 'Organisasi Keagamaan Kristen (Gereja)',
        '94913' => 'Organisasi Keagamaan Hindu (Pura)',
        '94914' => 'Organisasi Keagamaan Buddha (Vihara)',
        '94991' => 'Organisasi Sosial Kemasyarakatan',
    ];
}
