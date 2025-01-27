<?php

namespace App\Controllers;

use App\Models\ProductModel;
use App\Models\KategoriModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class Produk extends BaseController
{
    public function index()
    {
        // Cek apakah user sudah login
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/');
        }

        $produkModel = new ProductModel();
        $data = [
            'title' => 'Daftar Produk',
            'produk' => $produkModel->findAll()
        ];

        echo view('layout/header', $data);
        echo view('layout/sidebar');
        echo view('pages/produk/index', $data);
        echo view('layout/footer');
    }

    public function detail($id)
    {
        $produkModel = new ProductModel();
        $data = [
            'title' => 'Detail Produk',
            'produk' => $produkModel->where('id', $id)->first(),
        ];

        // tampilkan 404 error jika data tidak ditemukan
        if (!$data['produk']) {
            throw PageNotFoundException::forPageNotFound();
        }

        echo view('layout/header', $data);
        echo view('layout/sidebar');
        echo view('pages/produk/detail', $data);
        echo view('layout/footer');
    }

    public function create()
    {
        $kategoriModel = new KategoriModel();
        $data = [
            'title' => 'Tambah Produk',
            'kategori' => $kategoriModel->findAll()
        ];
        // lakukan validasi
        $validation =  \Config\Services::validation();
        // Aturan Validasi
        $validation->setRules([
            'nama_barang' => [
                'rules' => 'required|is_unique[produk.nama_barang]',
                'errors' => [
                    'required' => 'Nama barang harus diisi.',
                    'is_unique' => 'Nama barang sudah ada, gunakan nama lain.',
                ],
            ],
            'kategori' => [
                'rules' => 'required|alpha',
                'errors' => [
                    'required' => 'kategori harus diisi.',
                    'alpha' => 'Kategori harus berupa huruf.',
                ],
            ],
            'harga_beli' => [
                'rules' => 'required|numeric',
                'errors' => [
                    'required' => 'harga beli barang harus diisi.',
                    'integer' => 'harga beli barang harus berupa angka.',
                ],
            ],
            'harga_jual' => [
                'rules' => 'required|numeric',
                'errors' => [
                    'required' => 'harga jual barang harus diisi.',
                    'integer' => 'harga jual barang harus berupa angka.',
                ],
            ],
            'stock_barang' => [
                'rules' => 'required|numeric',
                'errors' => [
                    'required' => 'stock barang harus diisi.',
                    'integer' => 'stock barang harus berupa angka.',
                ],
            ],
            'image' => [
                'rules' => 'uploaded[image]|mime_in[image,image/jpg,image/jpeg,image/png]|max_size[image,100]',
                'errors' => [
                    'uploaded' => 'Gambar produk wajib diunggah.',
                    'mime_in' => 'File yang diunggah harus berupa gambar jpg dan png.',
                    'max_size' => 'Ukuran gambar maksimal adalah 100KB.',
                ],
            ],
        ]);
        $isDataValid = $validation->withRequest($this->request)->run();
        // jika data valid, simpan ke database
        if ($isDataValid) {
            $produk = new ProductModel();
            $produk->save([
                "nama_barang" => $this->request->getPost('nama_barang'),
                "kategori" => $this->request->getPost('kategori'),
                "harga_beli" => $this->request->getPost('harga_beli'),
                "harga_jual" => $this->request->getPost('harga_jual'),
                "stock_barang" => $this->request->getPost('stock_barang'),
                "image" => $this->request->getPost('image'),
                "create_date" => date('Y-m-d H:i:s'),
            ]);
            session()->setFlashdata('success', 'Produk berhasil disimpan.');
            return redirect()->to('produk')->with('success', 'Produk berhasil ditambahkan.');
        }

        echo view('layout/header', $data);
        echo view('layout/sidebar');
        echo view('pages/produk/create', $data);
        echo view('layout/footer');
    }

    public function edit($id)
    {
        $produkModel = new ProductModel();
        $kategoriModel = new KategoriModel();
        $produk = $produkModel->where('id', $id)->first();

        if (!$produk) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Produk tidak ditemukan.');
        }
        $kategori = $kategoriModel->findAll();
        $selectedKategori = $kategoriModel->where('nama_kategori', $produk['kategori'])->first();
        $data = [
            'title' => 'Edit Produk',
            'produk' => $produk,
            'kategori' => $kategori,
            'selectedKategori' => $selectedKategori['nama_kategori'] ?? null,
        ];

        // lakukan validasi
        $validation =  \Config\Services::validation();
        $validation->setRules([
            'id' => 'required',
            'nama_barang' => 'required',
            'kategori' => 'required',
            'harga_beli' => 'required|numeric',
            'harga_jual' => 'required|numeric',
            'stock_barang' => 'required|integer',
            'image' => 'permit_empty|string',
        ]);

        $isDataValid = $validation->withRequest($this->request)->run();
        // jika data vlid, maka simpan ke database
        if ($isDataValid) {
            $produkModel->update($id, [
                "nama_barang" => $this->request->getPost('nama_barang'),
                "kategori" => $this->request->getPost('kategori'),
                "harga_beli" => $this->request->getPost('harga_beli'),
                "harga_jual" => $this->request->getPost('harga_jual'),
                "stock_barang" => $this->request->getPost('stock_barang'),
                "image" => $this->request->getPost('image'),
                "last_date" => date('Y-m-d H:i:s'),
            ]);
            session()->setFlashdata('success', 'Produk berhasil diperbarui.');
            return redirect()->to('produk')->with('success', 'Produk berhasil diperbarui.');
        }

        echo view('layout/header', $data);
        echo view('layout/sidebar');
        echo view('pages/produk/edit', $data);
        echo view('layout/footer');
    }

    public function delete($id)
    {
        $produk = new ProductModel();
        $produk->delete($id);
        session()->setFlashdata('error', 'Produk berhasil dihapus.');
        return redirect('produk');
    }
}
