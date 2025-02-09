<?php

namespace App\Models;

use CodeIgniter\Model;

class ProductModel extends Model
{
    protected $table      = 'produk';
    protected $useTimestamps = true;
    protected $allowedFields = ['id', 'nama_barang', 'slug', 'kategori', 'harga_beli', 'harga_jual', 'stock_barang', 'image'];

    public function getProduk($slug = false)
    {
        if ($slug === false) {
            return $this->findAll();
        }
        return $this->where(['slug' => $slug])->first();
    }

    public function search($keyword) {
        // $builder = $this->table('produk');    
        // $builder->like('nama_barang', $keyword);
        // return $builder;

        return $this->table('produk')->like('nama_barang', $keyword);
    }
}