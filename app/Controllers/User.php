<?php

namespace App\Controllers;

use App\Models\UserModel;

class User extends BaseController
{
    public function index()
    {
        $data = [
            'title' => 'Login'
        ];
        echo view('layout/header', $data);
        echo view('pages/auth/login', $data);
        echo view('layout/footer');
    }

    public function auth()
    {
        $UserModel = new UserModel();

        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');

        $cek = $UserModel->get_data($email, $password);

        if ($cek == null) {
            session()->setFlashdata('error', 'username atau password salah.');
            return redirect()->to(base_url('/'));
        } else {
            if (($cek['email'] == $email) && ($cek['password'] == $password)) {
                session()->set('email', $cek['email']);
                session()->set('nama', $cek['nama']);
                session()->set('posisi', $cek['posisi']);
                session()->set('id', $cek['id']);
                return redirect()->to(base_url('produk'));
            }
        }
    }

    public function register()
    {
        $data = [
            'title' => 'Register'
        ];
        echo view('layout/header', $data);
        echo view('pages/auth/register', $data);
        echo view('layout/footer');
    }

    public function proses_register()
    {
        $userModel = new UserModel();
        date_default_timezone_set('Asia/Jakarta');

        $data = [
            'nama' => $this->request->getPost('nama'),
            'password' => $this->request->getPost('password'),
            'email'    => $this->request->getPost('email'),
            'posisi'    => $this->request->getPost('posisi'),
            'create_date' => date('Y-m-d H:i:s'),
        ];

        $userModel->save($data);

        return redirect()->to('/')->with('success', 'Akun berhasil dibuat.');
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

    public function logout()
    {
        session()->destroy();
        return redirect()->to(base_url('/'));
    }
}
