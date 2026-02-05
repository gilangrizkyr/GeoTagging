<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class UpdateMapCenterTanahBumbu extends Migration
{
    public function up()
    {
        $this->db->query("UPDATE settings SET value = '-3.456392' WHERE key = 'map_center_lat'");
        $this->db->query("UPDATE settings SET value = '115.982153' WHERE key = 'map_center_lng'");
    }

    public function down()
    {
        // Reset to Monas
        $this->db->query("UPDATE settings SET value = '-6.175392' WHERE key = 'map_center_lat'");
        $this->db->query("UPDATE settings SET value = '106.827153' WHERE key = 'map_center_lng'");
    }
}