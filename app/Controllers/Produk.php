<?php

namespace App\Controllers;

use App\Models\ProductModel;
use App\Models\KategoriModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class Produk extends BaseController
{
    public function index()
    {
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
        $validation->setRules(['nama_barang' => 'required', 'kategori' => 'required', 'harga_beli' => 'required|numeric', 'harga_jual' => 'required|numeric', 'stock_barang' => 'required|integer', 'image' => 'permit_empty|string']);
        $isDataValid = $validation->withRequest($this->request)->run();

        // jika data valid, simpan ke database
        if ($isDataValid) {
            $produk = new ProductModel();
            $produk->insert([
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
