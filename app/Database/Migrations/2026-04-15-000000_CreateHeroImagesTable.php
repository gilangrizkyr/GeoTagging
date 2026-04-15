<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateHeroImagesTable extends Migration
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
            'image_path' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
            ],
            'sort_order' => [
                'type' => 'INT',
                'constraint' => 5,
                'default' => 0,
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
        $this->forge->createTable('hero_images');
    }

    public function down()
    {
        $this->forge->dropTable('hero_images');
    }
}
