<?php

namespace App\Controllers;

class Home extends BaseController
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

    public function Profil()
    {
        $data = [
            'title' => 'Profil'
        ];
        echo view('layout/header', $data);
        echo view('layout/sidebar');
        echo view('pages/profil', $data);
        echo view('layout/footer');
    }

    public function Login()
    {
        $data = [
            'title' => 'Login'
        ];
        echo view('layout/header', $data);
        echo view('pages/login', $data);
        echo view('layout/footer');
    }
}
