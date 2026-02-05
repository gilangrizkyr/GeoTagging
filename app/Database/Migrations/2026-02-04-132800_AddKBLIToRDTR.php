<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddKBLIToRDTR extends Migration
{
    public function up()
    {
        // Add KBLI field to RDTR zones
        $this->forge->addColumn('rdtr_zones', [
            'kbli_allowed' => [
                'type' => 'TEXT',
                'null' => true,
                'comment' => 'Comma-separated KBLI codes allowed in this zone (e.g., 46311,47711)',
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('rdtr_zones', 'kbli_allowed');
    }
}