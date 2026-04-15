<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

class KBLI extends BaseConfig
{
    /**
     * KBLI Reference Data
     * Mapping KBLI codes to their respective business activity names.
     */
    public $reference = [
        '46311' => 'Perdagangan Besar Beras',
        '47711' => 'Perdagangan Eceran Pakaian',
        '56101' => 'Restoran',
        '68100' => 'Real Estat',
        '85101' => 'Pendidikan Anak Usia Dini',
        // Common KBLI for testing
        '01111' => 'Pertanian Jagung',
        '10710' => 'Industri Produk Roti dan Kue',
        '47111' => 'Perdagangan Eceran Berbagai Macam Barang Utama Makanan',
        '55110' => 'Hotel Bintang',
        '93210' => 'Taman Rekreasi dan Taman Bermain',
    ];
}
