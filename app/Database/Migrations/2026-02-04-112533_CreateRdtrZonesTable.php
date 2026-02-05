<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateRdtrZonesTable extends Migration
{
    public function up()
    {
        // Ensure PostGIS extension exists
        $this->db->query("CREATE EXTENSION IF NOT EXISTS postgis");

        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'nama_zona' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
            ],
            'peruntukan' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'keterangan' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'regulation_text' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'color' => [
                'type' => 'VARCHAR',
                'constraint' => '50',
                'default' => '#3388ff',
            ],
            'created_at' => [
                'type' => 'TIMESTAMP',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'TIMESTAMP',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('rdtr_zones');

        // Add Geometry Column (Polygon, SRID 4326)
        // We use raw SQL because Forge doesn't support PostGIS types seamlessly
        $this->db->query("ALTER TABLE rdtr_zones ADD COLUMN geom geometry(POLYGON, 4326)");

        // Add Spatial Index
        $this->db->query("CREATE INDEX idx_rdtr_zones_geom ON rdtr_zones USING GIST (geom)");
    }

    public function down()
    {
        $this->forge->dropTable('rdtr_zones');
    }
}