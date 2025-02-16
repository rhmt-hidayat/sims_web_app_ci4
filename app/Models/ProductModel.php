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

    public function search($keyword)
    {
        // $builder = $this->table('produk');    
        // $builder->like('nama_barang', $keyword);
        // return $builder;

        return $this->table('produk')->like('nama_barang', $keyword);
    }

    public function getPdf()
    {
        return $this->limit(100)->findAll(); // Mengambil semua data produk
    }

    //PREPARED STATEMENT QUERY BUILDER
    public function getAllProduk()
    {
        $db = \Config\Database::connect();
        $query = $db->query('SELECT * FROM produk');
        $result = $query->getResult();
        return $result;
    }

    public function SearchProduk($keyword)
    {
        $db = \Config\Database::connect();
        $query = $db->query('SELECT * FROM produk WHERE nama_barang LIKE "%' . $keyword . '%"');
        $result = $query->getResult();
        return $result;
    }

    public function getProdukBySlug($slug)
    {
        $db = \Config\Database::connect();
        $query = $db->table('produk')
            ->where('slug', $slug)
            ->get();

        $result = $query->getResult();
        return $result;
    }

    public function getProdukByKategori($kategori)
    {
        $db = \Config\Database::connect();
        $query = $db->table('produk')
            ->where('kategori', $kategori)
            ->get();

        $result = $query->getResult();
        return $result;
    }

    public function add($data)
    {
        $db = \Config\Database::connect();
        $query = $db->table('produk')
            ->insert($data);

        return $query;
    }

    public function edit($id, $data)
    {
        $db = \Config\Database::connect();
        $query = $db->table('produk')
            ->where('id', $id)
            ->update($data);

        return $query;
    }

    public function hapus($id)
    {
        $db = \Config\Database::connect();
        $query = $db->table('produk')
            ->where('id', $id)
            ->delete();
            
        return $query;
    }
}
