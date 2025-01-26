<?php

namespace App\Controllers;

use App\Models\ProductModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class Produk extends BaseController
{
    public function index()
    {
        $produk = new ProductModel();
        $data = [
            'title' => 'Daftar Produk'
        ];
        $data['produk'] = $produk->findAll();
        echo view('layout/header', $data);
        echo view('layout/sidebar');
        echo view('pages/produk', $data);
        echo view('layout/footer');
    }

    // public function detail($slug)
	// {
        // echo $slug;
		// $produk = new ProductModel();
		// $data['produk'] = $produk->where([
		// 	'slug' => $slug,
		// ])->first();

        // // tampilkan 404 error jika data tidak ditemukan
		// if (!$data['news']) {
		// 	throw PageNotFoundException::forPageNotFound();
		// }

		// echo view('news_detail', $data); //load data ke view
	// }

    public function create()
    {
        $data = [
            'title' => 'Tambah Produk'
        ];
        // lakukan validasi
        $validation =  \Config\Services::validation();
        $validation->setRules(['nama_barang' => 'required']);
        $isDataValid = $validation->withRequest($this->request)->run();

        // jika data valid, simpan ke database
        if($isDataValid){
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
            return redirect('produk');
        }   

        echo view('layout/header', $data);
        echo view('layout/sidebar');
        echo view('pages/addProduk', $data);
        echo view('layout/footer');
    }
}