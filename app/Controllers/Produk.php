<?php

namespace App\Controllers;

class Produk extends BaseController
{
    public function index()
    {
        $data = [
            'title' => 'Daftar Produk'
        ];
        echo view('layout/header', $data);
        echo view('layout/sidebar');
        echo view('pages/produk', $data);
        echo view('layout/footer');
    }

    public function insert()
    {
        $data = [
            'title' => 'Tambah Produk'
        ];
        echo view('layout/header', $data);
        echo view('layout/sidebar');
        echo view('pages/addProduk', $data);
        echo view('layout/footer');
    }
}