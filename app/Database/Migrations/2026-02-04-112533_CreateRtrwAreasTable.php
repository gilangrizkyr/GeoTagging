<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateRtrwAreasTable extends Migration
{
    public function up()
    {
        // Ensure PostGIS extension exists (redundant if RDTR run first, but safe)
        $this->db->query("CREATE EXTENSION IF NOT EXISTS postgis");

        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'nama_kawasan' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
            ],
            'fungsi_kawasan' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'color' => [
                'type' => 'VARCHAR',
                'constraint' => '50',
                'default' => '#ff8833',
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
        $this->forge->createTable('rtrw_areas');

        // Add Geometry Column (Polygon, SRID 4326)
        $this->db->query("ALTER TABLE rtrw_areas ADD COLUMN geom geometry(POLYGON, 4326)");

        // Add Spatial Index
        $this->db->query("CREATE INDEX idx_rtrw_areas_geom ON rtrw_areas USING GIST (geom)");
    }

    public function down()
    {
        $this->forge->dropTable('rtrw_areas');
    }
}