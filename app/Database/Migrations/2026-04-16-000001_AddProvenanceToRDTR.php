<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddProvenanceToRDTR extends Migration
{
    public function up()
    {
        $fields = [
            'sumber_data' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
                'comment' => 'Instansi sumber data, e.g. Dinas PU Tanah Bumbu',
            ],
            'tanggal_berlaku' => [
                'type' => 'DATE',
                'null' => true,
                'comment' => 'Tanggal efektif berlakunya zona RDTR ini',
            ],
            'versi_data' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
                'null' => true,
                'comment' => 'Versi/revisi data, e.g. v1.0 2025',
            ],
            'keterangan_sumber' => [
                'type' => 'TEXT',
                'null' => true,
                'comment' => 'Keterangan tambahan tentang asal data dan dasar hukumnya',
            ],
            'created_by' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => true,
                'comment' => 'Username penginput data',
            ],
        ];

        $this->forge->addColumn('rdtr_zones', $fields);
    }

    public function down()
    {
        $this->forge->dropColumn('rdtr_zones', [
            'sumber_data',
            'tanggal_berlaku',
            'versi_data',
            'keterangan_sumber',
            'created_by',
        ]);
    }
}
