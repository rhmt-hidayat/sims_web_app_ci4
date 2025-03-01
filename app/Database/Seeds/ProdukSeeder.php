<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use CodeIgniter\I18n\Time;
use Faker\Factory;

class ProdukSeeder extends Seeder
{
    public function run()
    {
        $faker = \Faker\Factory::create('id_ID');
        for ($i = 0; $i < 50; $i++) {
            $nama_barang = $faker->word . ' ' . $faker->word;
            $slug = strtolower(str_replace(' ', '-', $nama_barang));
            $kategori = $faker->randomElement(['Alat Olahraga', 'Alat Music']);
            $harga_beli = $faker->numberBetween(100000, 3000000);
            $harga_jual = $harga_beli + $faker->numberBetween(100000, 500000);
            $stok_barang = $faker->numberBetween(1, 100);
            $image = 'produk' . $faker->numberBetween(1, 5) . '.jpg';
            $created_at = Time::createFromTimestamp($faker->unixTime(), 'Asia/Jakarta');
            $updated_at = Time::now('Asia/Jakarta');

            $data = [
                'nama_barang' => $nama_barang,
                'slug' => $slug,
                'kategori' => $kategori,
                'harga_beli' => $harga_beli,
                'harga_jual' => $harga_jual,
                'stok_barang' => $stok_barang,
                'image' => $image,
                'created_at' => $created_at,
                'updated_at' => $updated_at,
            ];

            $this->db->table('produk')->insert($data);
        }
    }
}
