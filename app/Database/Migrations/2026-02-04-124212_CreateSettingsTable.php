<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateSettingsTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'key' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
                'unique' => true,
            ],
            'value' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('settings');

        // Insert Defaults
        $this->db->table('settings')->insertBatch([
            ['key' => 'app_name', 'value' => 'Geotagging DPMPTSP', 'created_at' => date('Y-m-d H:i:s')],
            ['key' => 'app_logo', 'value' => '/assets/logo.png', 'created_at' => date('Y-m-d H:i:s')],
            ['key' => 'header_color', 'value' => '#0d6efd', 'created_at' => date('Y-m-d H:i:s')], // Default Primary Blue
            ['key' => 'map_center_lat', 'value' => '-6.175392', 'created_at' => date('Y-m-d H:i:s')],
            ['key' => 'map_center_lng', 'value' => '106.827153', 'created_at' => date('Y-m-d H:i:s')],
        ]);
    }

    public function down()
    {
        $this->forge->dropTable('settings');
    }
}