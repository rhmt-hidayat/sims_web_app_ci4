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
        $session = session();
        $UserModel = new UserModel();
        date_default_timezone_set('Asia/Jakarta');

        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');

        // Cari user berdasarkan email
        $user = $UserModel->where('email', $email)->first();

        if ($user) {
            // Verifikasi password menggunakan bcrypt
            if (password_verify($password, $user['password'])) {
                // Set session jika login berhasil
                $session->set([
                    'id' => $user['id'],
                    'email' => $user['email'],
                    'nama' => $user['nama'],
                    'posisi' => $user['posisi'],
                    'isLoggedIn' => true,
                ]);

                // $UserModel->update($email, ["last_login" => date('Y-m-d H:i:s')]);
                return redirect()->to('produk');
            } else {
                $session->setFlashdata('error', 'Password salah.');
                return redirect()->back();
            }
        } else {
            $session->setFlashdata('error', 'Email tidak ditemukan.');
            return redirect()->back();
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
            'email'    => $this->request->getPost('email'),
            'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT), // Enkripsi password dengan bcrypt
            'password_decrypt' => $this->request->getPost('password'),
            'posisi'    => $this->request->getPost('posisi'),
            'create_date' => date('Y-m-d H:i:s'),
        ];

        $userModel->save($data);
        return redirect()->to('/')->with('success', 'Akun berhasil dibuat.');
    }

    public function profil()
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/');
        }
        
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
        $session = session();
        $session->destroy();
        return redirect()->to(base_url('/'));
    }
}
