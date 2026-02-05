<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddITBXToRDTR extends Migration
{
    public function up()
    {
        $fields = [
            // Intensitas Bangunan (ITBX)
            'kdb' => [
                'type' => 'DECIMAL',
                'constraint' => '5,2',
                'null' => true,
                'comment' => 'Koefisien Dasar Bangunan (%)',
            ],
            'klb' => [
                'type' => 'DECIMAL',
                'constraint' => '5,2',
                'null' => true,
                'comment' => 'Koefisien Lantai Bangunan',
            ],
            'kdh' => [
                'type' => 'DECIMAL',
                'constraint' => '5,2',
                'null' => true,
                'comment' => 'Koefisien Dasar Hijau (%)',
            ],
            'ktb' => [
                'type' => 'DECIMAL',
                'constraint' => '5,2',
                'null' => true,
                'comment' => 'Koefisien Tapak Basement (%)',
            ],
            'ketinggian_max' => [
                'type' => 'INT',
                'constraint' => 5,
                'null' => true,
                'comment' => 'Ketinggian maksimal bangunan (meter)',
            ],
            'jumlah_lantai_max' => [
                'type' => 'INT',
                'constraint' => 3,
                'null' => true,
                'comment' => 'Jumlah lantai maksimal',
            ],
            'gsb' => [
                'type' => 'INT',
                'constraint' => 5,
                'null' => true,
                'comment' => 'Garis Sempadan Bangunan (meter)',
            ],
            'gsl' => [
                'type' => 'INT',
                'constraint' => 5,
                'null' => true,
                'comment' => 'Garis Sempadan Lahan (meter)',
            ],
            // Detail RDTR
            'sub_zona' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => true,
                'comment' => 'Sub zona (jika ada)',
            ],
            'arahan_pemanfaatan' => [
                'type' => 'TEXT',
                'null' => true,
                'comment' => 'Arahan pemanfaatan ruang',
            ],
        ];

        $this->forge->addColumn('rdtr_zones', $fields);
    }

    public function down()
    {
        $this->forge->dropColumn('rdtr_zones', [
            'kdb', 'klb', 'kdh', 'ktb',
            'ketinggian_max', 'jumlah_lantai_max',
            'gsb', 'gsl',
            'sub_zona', 'arahan_pemanfaatan'
        ]);
    }
}