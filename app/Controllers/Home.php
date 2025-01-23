<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index()
    {
        $data = [
            'title' => 'Produk'
        ];
        echo view('layout/sidebar');
        echo view('pages/produk', $data);
    }

    public function Profil()
    {
        $data = [
            'title' => 'Profil'
        ];
        echo view('layout/sidebar');
        echo view('pages/profil', $data);
    }
}
