<?php

namespace App\Controllers;

use App\Models\ProductModel;
use App\Models\KategoriModel;
use CodeIgniter\Exceptions\PageNotFoundException;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Dompdf\Dompdf;
use Dompdf\Options;

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
        if ($kategoriId && $kategoriId != 'Semua') {
            $produk = $this->productModel->where('kategori', $kategoriId);
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
            // 'kategori' => $this->kategoriModel->findAll(), // NOT PREPARED STATEMENT
            'validation' => session()->getFlashdata('validation') ?? \Config\Services::validation(),
        ];

        return view('pages/produk/create', $data);
    }

    public function insert()
    {
        $validation = \Config\Services::validation();
        $validation->setRules([
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
                'rules'  => 'uploaded[image]|is_image[image]|max_size[image,100]|mime_in[image,image/jpg,image/jpeg,image/png]',
                'errors' => [
                    'uploaded' => 'File harus diunggah.',
                    'is_image' => 'Yang diunggah harus berupa gambar.',
                    'max_size' => 'Ukuran gambar maksimal 100kb.',
                    'mime_in'  => 'Format file harus JPG, JPEG, atau PNG.',
                ],
            ],
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }
        // Ambil file yang diunggah
        $file = $this->request->getFile('image');
        if ($file->isValid() && !$file->hasMoved()) {
            $newName = $file->getName();
            $namaFile = str_replace(' ', '_', $newName); // Ganti spasi dengan underscore
            $file->move('uploads/', $namaFile); //nama folder di public
            // $file->move(WRITEPATH . 'uploads', $namaFile); //jika folder diluar public

            $slug = url_title($this->request->getPost('nama_barang'), '-', true);
            // PREPARED STATEMENT MODEL (disarankan)
            // $this->productModel->insert([
            //     'nama_barang' => $this->request->getPost('nama_barang'),
            //     'slug' => $slug,
            //     'kategori' => $this->request->getPost('kategori'),
            //     'harga_beli' => $this->request->getPost('harga_beli'),
            //     'harga_jual' => $this->request->getPost('harga_jual'),
            //     'stock_barang' => $this->request->getPost('stock_barang'),
            //     'image' => $namaFile,
            // ]);

            date_default_timezone_set('Asia/Jakarta');

            // PREPARED STATEMENT CARA LAIN
            $data = [
                'nama_barang'  => $this->request->getPost('nama_barang', FILTER_SANITIZE_STRING),
                'slug'         => $slug,
                'kategori'     => $this->request->getPost('kategori', FILTER_SANITIZE_STRING),
                'harga_beli'   => (int) $this->request->getPost('harga_beli'),
                'harga_jual'   => (int) $this->request->getPost('harga_jual'),
                'stock_barang' => (int) $this->request->getPost('stock_barang'),
                'image'        => $namaFile,
                'created_at'   => date('Y-m-d H:i:s'),
            ];
            //CARA 1 langsung memanggil bawaan ci4 (aman)
            $db = \Config\Database::connect();
            $db->table('produk')->insert($data);

            //CARA 2 memanggil add ProdukModel (parameter binding query -> aman)
            // $this->productModel->add($data);

            //CARA 3 Query manual (cukup aman)
            // $nama_barang = $this->request->getPost('nama_barang', FILTER_SANITIZE_STRING);
            // $slug = $slug;
            // $kategori = $this->request->getPost('kategori', FILTER_SANITIZE_STRING);
            // $harga_beli = (int) $this->request->getPost('harga_beli');
            // $harga_jual = (int) $this->request->getPost('harga_jual');
            // $stock_barang = (int) $this->request->getPost('stock_barang');
            // $image = $namaFile;
            // $created_at = date('Y-m-d H:i:s');

            // $sql = "INSERT INTO produk (nama_barang, slug, kategori, harga_beli, harga_jual, stock_barang, image, created_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
            // $db = \Config\Database::connect();
            // $db->query($sql, [$nama_barang, $slug, $kategori, $harga_beli, $harga_jual, $stock_barang, $image, $created_at]);

            session()->setFlashdata('success', 'Produk berhasil ditambahkan');
            return redirect()->to('produk');
        } else {
            return redirect()->back()->with('error', 'Gagal tambah produk');
        }
    }

    public function edit($slug)
    {
        $produk = $this->productModel->where('slug', $slug)->first();
        if (!$produk) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Produk tidak ditemukan.');
        }
        $kategori = $this->kategoriModel->findAll();
        $selectedKategori = $this->kategoriModel->where('nama_kategori', $produk['kategori'])->first();
        $data = [
            'title' => 'Edit Produk',
            'produk' => $this->productModel->getProduk($slug),
            'kategori' => $kategori,
            'selectedKategori' => $selectedKategori['nama_kategori'] ?? null,
        ];

        return view('pages/produk/edit', $data);
    }

    public function update($id)
    {
        //cek nama barang
        $produkLama = $this->productModel->getProduk($this->request->getPost('slug'));
        if ($this->request->getPost('nama_barang') == $produkLama['nama_barang']) {
            $rule_nama_barang = 'required';
        } else {
            $rule_nama_barang = 'required|is_unique[produk.nama_barang]';
        }

        $validation =  \Config\Services::validation();
        $validation->setRules([
            'kategori' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Kategori harus diisi',
                ],
            ],
            'nama_barang' => [
                'rules' => $rule_nama_barang,
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
        ]);

        if ($this->request->getFile('image')->isValid()) {
            $validation->setRules([
                'image' => [
                    'rules'  => 'uploaded[image]|is_image[image]|max_size[image,100]|mime_in[image,image/jpg,image/jpeg,image/png]',
                    'errors' => [
                        'uploaded' => 'File harus diunggah.',
                        'is_image' => 'Yang diunggah harus berupa gambar.',
                        'max_size' => 'Ukuran gambar maksimal 100kb.',
                        'mime_in'  => 'Format file harus JPG, JPEG, atau PNG.',
                    ],
                ],
            ]);
        }

        if (!$validation->withRequest($this->request)->run()) {
            return redirect()->to('/produk/edit/' . $this->request->getVar('slug'))->withInput()->with('errors', $validation->getErrors());
        }

        $file = $this->request->getFile('image');

        if ($file && $file->isValid() && !$file->hasMoved()) {
            // Hapus gambar lama jika ada
            if (!empty($produkLama['image']) && file_exists(FCPATH . 'uploads/' . $produkLama['image'])) {
                unlink(FCPATH . 'uploads/' . $produkLama['image']);
            }
            // Simpan gambar baru
            $newName = $file->getName();
            $namaFile = str_replace(' ', '_', $newName); // Ganti spasi dengan underscore
            $file->move('uploads/', $namaFile);
        } else {
            $namaFile = $produkLama['image']; // Gunakan gambar lama jika tidak ada file baru
        }

        $slug = url_title($this->request->getPost('nama_barang'), '-', true);
        // PREPARED STATEMENT MODEL (disarankan)
        // $this->productModel->update($id, [
        //     "nama_barang" => $this->request->getPost('nama_barang'),
        //     "slug" => $slug,
        //     "kategori" => $this->request->getPost('kategori'),
        //     "harga_beli" => $this->request->getPost('harga_beli'),
        //     "harga_jual" => $this->request->getPost('harga_jual'),
        //     "stock_barang" => $this->request->getPost('stock_barang'),
        //     "image" => $namaFile,
        // ]);

        date_default_timezone_set('Asia/Jakarta');

        // PREPARED STATEMENT CARA LAIN
        $data = [
            'nama_barang'  => $this->request->getPost('nama_barang', FILTER_SANITIZE_STRING),
            'slug'         => $slug,
            'kategori'     => $this->request->getPost('kategori', FILTER_SANITIZE_STRING),
            'harga_beli'   => (int) $this->request->getPost('harga_beli'),
            'harga_jual'   => (int) $this->request->getPost('harga_jual'),
            'stock_barang' => (int) $this->request->getPost('stock_barang'),
            'image'        => $namaFile,
            'updated_at'   => date('Y-m-d H:i:s'),
        ];

        //CARA 1 langsung memanggil bawaan ci4 (aman)
        // $db = \Config\Database::connect();
        // $db->table('produk')->where('id', $id)->update($data);

        //CARA 2 memanggil edit ProdukModel (parameter binding query -> aman)
        // $this->productModel->edit($id, $data);

        //CARA 3 Query manual (cukup aman)
        $nama_barang = $this->request->getPost('nama_barang', FILTER_SANITIZE_STRING);
        $slug = $slug;
        $kategori = $this->request->getPost('kategori', FILTER_SANITIZE_STRING);
        $harga_beli = (int) $this->request->getPost('harga_beli');
        $harga_jual = (int) $this->request->getPost('harga_jual');
        $stock_barang = (int) $this->request->getPost('stock_barang');
        $image = $namaFile;
        $updated_at = date('Y-m-d H:i:s');

        $query = "UPDATE produk SET nama_barang = ?, slug = ?, kategori = ?, harga_beli = ?, harga_jual = ?, stock_barang = ?, image = ?, updated_at = ? WHERE id = ?";
        $db = \Config\Database::connect();
        $db->query($query, [$nama_barang, $slug, $kategori, $harga_beli, $harga_jual, $stock_barang, $image, $updated_at, $id]);

        session()->setFlashdata('success', 'Produk berhasil diperbarui.');
        return redirect()->to('produk')->with('success', 'Produk berhasil diperbarui.');
    }

    public function delete($id)
    {
        $this->productModel->delete($id);
        // $this->productModel->hapus($id); //parameter binding query
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
        if ($kategori && $kategori != 'Semua') {
            $produk = $this->productModel->where('kategori', $kategori)->findAll();
            // $produk = $this->productModel->getProdukByKategori($kategori);
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

    public function generatePdf()
    {
        $products = $this->productModel->getPdf();
        // Pastikan setiap gambar memiliki path absolut
        // foreach ($products as &$product) {
        //     $product['image'] = base_url('public/uploads/' . $product['image']);
        // }
        $html = view('pages/produk/report_pdf', ['title' => 'Daftar Produk', 'products' => $products]);

        // Konfigurasi Dompdf
        $options = new Options();
        $options->set('defaultFont', 'Helvetica');
        $options->set('isHtml5ParserEnabled', true); // Aktifkan parsing HTML5 agar gambar dapat tampil
        $options->set('isRemoteEnabled', true); // Izinkan pemuatan gambar eksternal
        $dompdf = new Dompdf($options);

        // Load konten HTML ke Dompdf
        $dompdf->loadHtml($html);

        // Set ukuran dan orientasi halaman (Opsional)
        $dompdf->setPaper('A4', 'portrait');

        // Render PDF
        $dompdf->render();
        $date = date('Ymd');
        ob_get_clean();
        // Outputkan PDF ke browser
        $dompdf->stream("ReportProduk_$date.pdf", ["Attachment" => false]);
    }
}
