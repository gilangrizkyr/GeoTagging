<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddSpatialIndices extends Migration
{
    public function up()
    {
        // Add GIST Index for RDTR (Optimizes spatial queries)
        $this->db->query("CREATE INDEX IF NOT EXISTS idx_rdtr_zones_geom ON rdtr_zones USING GIST (geom)");

        // Add GIST Index for RTRW
        $this->db->query("CREATE INDEX IF NOT EXISTS idx_rtrw_areas_geom ON rtrw_areas USING GIST (geom)");
    }

    public function down()
    {
        $this->db->query("DROP INDEX IF EXISTS idx_rdtr_zones_geom");
        $this->db->query("DROP INDEX IF EXISTS idx_rtrw_areas_geom");
    }
}