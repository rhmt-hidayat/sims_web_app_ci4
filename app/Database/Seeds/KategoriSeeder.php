<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use CodeIgniter\I18n\Time;

class KategoriSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'nama_kategori' => 'Alat Olahraga',
                'created_at' => Time::now('Asia/Jakarta'),
            ],
            [
                'nama_kategori' => 'Alat Music',
                'created_at' => Time::now('Asia/Jakarta'),
            ],           
        ];

        $this->db->table('kategori')->insertBatch($data);
    }
}
