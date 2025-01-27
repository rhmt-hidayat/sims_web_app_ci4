<?php

namespace App\Models;

use CodeIgniter\Model;

class ProductModel extends Model
{
    protected $table      = 'produk';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;
    protected $allowedFields = ['id', 'nama_barang', 'kategori', 'harga_beli', 'harga_jual', 'stock_barang', 'image', 'create_date', 'last_date'];
}