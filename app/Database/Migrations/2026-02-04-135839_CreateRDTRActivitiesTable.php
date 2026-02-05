<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateRDTRActivitiesTable extends Migration
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
            'rdtr_zone_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'comment' => 'Foreign key to rdtr_zones',
            ],
            'nama_kegiatan' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'comment' => 'Nama kegiatan/usaha',
            ],
            'kategori_kegiatan' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => true,
                'comment' => 'Kategori: Perdagangan, Jasa, Industri, dll',
            ],
            'status' => [
                'type' => 'CHAR',
                'constraint' => 1,
                'comment' => 'I=Diizinkan, T=Terbatas, B=Bersyarat, X=Dilarang',
            ],
            'syarat' => [
                'type' => 'TEXT',
                'null' => true,
                'comment' => 'Syarat khusus untuk status B atau T',
            ],
            'keterangan' => [
                'type' => 'TEXT',
                'null' => true,
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
        $this->forge->addKey('rdtr_zone_id');
        $this->forge->addKey('status');

        // Foreign key constraint
        $this->forge->addForeignKey('rdtr_zone_id', 'rdtr_zones', 'id', 'CASCADE', 'CASCADE');

        $this->forge->createTable('rdtr_activities');
    }

    public function down()
    {
        $this->forge->dropTable('rdtr_activities');
    }
}