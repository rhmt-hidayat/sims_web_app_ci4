<?php

namespace App\Controllers;

use App\Models\ProductModel;
use App\Models\KategoriModel;
use CodeIgniter\Exceptions\PageNotFoundException;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Produk extends BaseController
{
    protected $productModel;
    protected $kategoriModel;

    public function __construct()
    {
        $this->productModel = new ProductModel();
        $this->kategoriModel = new KategoriModel();
    }
    public function index()
    {
        // Cek apakah user sudah login
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/');
        }
        //membuat nomor halaman pagination
        $currentPage = $this->request->getVar('page_produk') ? $this->request->getVar('page_produk') : 1;
        //cari barang berdasarkan nama barang
        $keyword = $this->request->getVar('keyword');
        if ($keyword) {
            $produk = $this->productModel->search($keyword);
        } else {
            $produk = $this->productModel;
        }
        // Ambil kategori dari dropdown filter
        $kategoriId = $this->request->getGet('kategori');
        if ($kategoriId) {
            $produk = $produk->where('kategori', $kategoriId);
        }

        $data = [
            'title' => 'Daftar Produk',
            // 'produk' => $produkModel->findAll()
            'produk' => $produk->paginate(5, 'produk'),
            'pager' => $produk->pager,
            'currentPage' => $currentPage
        ];

        return view('pages/produk/index', $data);
    }

    public function detail($slug)
    {
        $data = [
            'title' => 'Detail Produk',
            'produk' => $this->productModel->getProduk($slug),
            'slug' => $slug
        ];

        // tampilkan 404 error jika data tidak ditemukan
        if (!$data['produk']) {
            throw PageNotFoundException::forPageNotFound('Nama Barang ' . $slug . ' tidak ditemukan');
        }

        return view('pages/produk/detail', $data);
    }

    public function create()
    {
        $data = [
            'title' => 'Tambah Produk',
            'kategori' => $this->kategoriModel->findAll(),
            'validation' => session()->getFlashdata('validation') ?? \Config\Services::validation(),
        ];

        return view('pages/produk/create', $data);
    }

    public function insert()
    {
        if (!$this->validate([
            'kategori' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Kategori harus diisi',
                ],
            ],
            'nama_barang' => [
                'rules' => 'required|is_unique[produk.nama_barang]',
                'errors' => [
                    'required' => 'Nama barang produk harus diisi',
                    'is_unique' => 'Nama barang produk sudah ada'
                ],
            ],
            'harga_beli' => [
                'rules' => 'required|numeric',
                'errors' => [
                    'required' => 'Harga beli harus diisi',
                    'numeric' => 'Harga beli harus berupa angka',
                ],
            ],
            'harga_jual' => [
                'rules' => 'required|numeric|min_harga_jual[harga_beli]',
                'errors' => [
                    'required' => 'Harga jual harus diisi',
                    'numeric' => 'Harga jual harus berupa angka',
                    'min_harga_jual' => 'Harga jual harus setidaknya 30% lebih tinggi dari harga beli.',
                ],
            ],
            'stock_barang' => [
                'rules' => 'required|integer',
                'errors' => [
                    'required' => 'Stock barang harus diisi',
                    'integer' => 'Stock barang harus berupa angka',
                ],
            ],
            'image' => [
                'rules' => 'uploaded[image]|max_size[image,100]|is_image[image]|mime_in[image,image/jpg,image/jpeg,image/png]',
                'errors' => [
                    'uploaded' => 'image harus diisi.',
                    'max_size' => 'ukuran image maksimal 100kb.',
                    'is_image' => 'yang anda upload bukan gambar.',
                    'mime_in' => 'yang anda upload bukan gambar.',
                ],
            ],
        ])) {
            $validation = \Config\Services::validation();
            session()->setFlashdata('validation', $validation);
            return redirect()->back()->withInput();
        }
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

        return view('pages/produk/edit', $data);
    }

    public function delete($id)
    {
        $this->productModel->delete($id);
        session()->setFlashdata('error', 'Produk berhasil dihapus.');
        return redirect()->to('produk');
    }

    public function cetak_invoice($slug)
    {
        $produkModel = new ProductModel();
        $data = [
            'title' => 'Cetak Invoice',
            'produk' => $produkModel->where('slug', $slug)->first(),
            'tanggal' => date('Y-m-d H:i:s'),
        ];

        // tampilkan 404 error jika data tidak ditemukan
        if (!$data['produk']) {
            throw PageNotFoundException::forPageNotFound('Nama Barang ' . $slug . ' tidak ditemukan');
        }

        return view('pages/produk/invoice', $data);
    }

    public function export()
    {
        // Ambil kategori dari query string (?kategori=Alat+Olahraga)
        $kategori = $this->request->getGet('kategori');
        if ($kategori) {
            $produk = $this->productModel->where('kategori', $kategori)->findAll();
        } else {
            $produk = $this->productModel->findAll();
        }

        $spreadsheet = new Spreadsheet();
        $activeWorksheet = $spreadsheet->getActiveSheet();

        // Menambahkan Judul
        $activeWorksheet->setCellValue('A1', 'DATA PRODUK');
        $activeWorksheet->mergeCells('A1:F1'); // Menggabungkan cell untuk judul
        $activeWorksheet->getStyle('A1')->getFont()->setBold(true)->setSize(14);
        $activeWorksheet->getStyle('A1')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        // Menambahkan Header
        $activeWorksheet->setCellValue('A3', 'No');
        $activeWorksheet->setCellValue('B3', 'Nama Produk');
        $activeWorksheet->setCellValue('C3', 'Kategori Produk');
        $activeWorksheet->setCellValue('D3', 'Harga Barang');
        $activeWorksheet->setCellValue('E3', 'Harga Jual');
        $activeWorksheet->setCellValue('F3', 'Stok');

        // Style Header
        $headerStyle = [
            'font' => ['bold' => true, 'size' => 12, 'color' => ['argb' => 'FFFFFF']],
            'alignment' => ['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER],
            'borders' => ['allBorders' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN]],
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => ['argb' => 'FF4500'] // Warna orange
            ]
        ];
        $activeWorksheet->getStyle('A3:F3')->applyFromArray($headerStyle);

        $column = 4;
        foreach ($produk as $key => $value) {
            $activeWorksheet->setCellValue('A' . $column, $key + 1);
            $activeWorksheet->setCellValue('B' . $column, $value['nama_barang']);
            $activeWorksheet->setCellValue('C' . $column, $value['kategori']);
            $activeWorksheet->setCellValue('D' . $column, $value['harga_beli']);
            $activeWorksheet->setCellValue('E' . $column, $value['harga_jual']);
            $activeWorksheet->setCellValue('F' . $column, $value['stock_barang']);

            // Style border untuk data
            $activeWorksheet->getStyle("A$column:F$column")->applyFromArray([
                'borders' => ['allBorders' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN]]
            ]);

            $column++;
        }
        // Auto size column
        foreach (range('A', 'F') as $col) {
            $activeWorksheet->getColumnDimension($col)->setAutoSize(true);
        }

        // Nama file berdasarkan kategori
        $filename = $kategori ? "Laporan_Produk_$kategori" : "Laporan_Semua_Produk";
        $filename .= "_" . date('Ymd') . ".xlsx";

        $writer = new Xlsx($spreadsheet);
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');
        $writer->save('php://output');
        exit;
    }
}
