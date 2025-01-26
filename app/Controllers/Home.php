<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index()
    {
        $data = [
            'title' => 'Login'
        ];
        echo view('layout/header', $data);
        echo view('pages/login', $data);
        echo view('layout/footer');
    }

    public function auth()
    {
        $email = $this->input->post('email');
        $password = md5($this->input->post('password'));
        dd($email, $password);
    }

    public function profil()
    {
        $data = [
            'title' => 'Profil'
        ];
        echo view('layout/header', $data);
        echo view('layout/sidebar');
        echo view('pages/profil', $data);
        echo view('layout/footer');
    }
}
