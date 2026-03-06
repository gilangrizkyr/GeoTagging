<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class AdminSeeder2 extends Seeder
{
    public function run()
    {
        $data = [
            'username' => 'admin2',
            'password_hash' => password_hash('admin1234', PASSWORD_BCRYPT),
            'role' => 'admin',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ];
        $this->db->table('users')->insert($data);
    }
}