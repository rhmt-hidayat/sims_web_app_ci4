<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use CodeIgniter\I18n\Time;

class UserSeeder extends Seeder
{
    public function run()
    {
        $data = [
            'nama' => 'Rahmat Hidayat',
            'email'    => 'real.rahmathidayat@gmail.com',
            'password' => password_hash('12345678', PASSWORD_DEFAULT),
            'password_decrypt' => '12345678',
            'posisi'    => 'Web Programmer',
            'created_at' => Time::now('Asia/Jakarta'),
        ];

        $this->db->table('user')->insert($data);
    }
}
