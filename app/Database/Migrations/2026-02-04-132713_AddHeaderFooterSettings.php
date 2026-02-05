<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddHeaderFooterSettings extends Migration
{
    public function up()
    {
        $this->db->query("INSERT INTO settings (key, value) VALUES ('header_text', 'Sistem Informasi Geotagging Tata Ruang') ON CONFLICT (key) DO NOTHING");
        $this->db->query("INSERT INTO settings (key, value) VALUES ('footer_text', 'Dinas Penanaman Modal dan PTSP') ON CONFLICT (key) DO NOTHING");
    }

    public function down()
    {
        $this->db->query("DELETE FROM settings WHERE key IN ('header_text', 'footer_text')");
    }
}