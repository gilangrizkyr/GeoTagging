<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateMediaAssetsTable extends Migration
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
            'uuid' => [
                'type' => 'VARCHAR',
                'constraint' => '36',
                'unique' => true,
            ],
            'filename' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
            ],
            'original_name' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
            ],
            'file_path' => [
                'type' => 'TEXT',
            ],
            'file_size' => [
                'type' => 'BIGINT',
            ],
            'file_type' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
            ],
            'category' => [
                'type' => 'VARCHAR',
                'constraint' => '50',
                'null' => true,
            ],
            'created_by' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
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
        $this->forge->addKey('uuid');
        $this->forge->addKey('category');
        $this->forge->createTable('media_assets');
    }

    public function down()
    {
        $this->forge->dropTable('media_assets');
    }
}
