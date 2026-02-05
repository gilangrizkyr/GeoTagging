<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateActivityTemplatesTable extends Migration
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
            'nama_kegiatan' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'comment' => 'Nama kegiatan/usaha',
            ],
            'kategori' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => true,
                'comment' => 'Kategori kegiatan',
            ],
            'kbli_code' => [
                'type' => 'VARCHAR',
                'constraint' => 10,
                'null' => true,
                'comment' => 'Kode KBLI terkait',
            ],
            'deskripsi' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'created_at' => [
                'type' => 'TIMESTAMP',
                'null' => true,
            ],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addKey('kategori');

        $this->forge->createTable('activity_templates');
    }

    public function down()
    {
        $this->forge->dropTable('activity_templates');
    }
}