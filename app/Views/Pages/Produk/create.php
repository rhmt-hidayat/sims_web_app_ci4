<?php $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
    .dropzone {
        border: 2px dashed #007bff;
        border-radius: 10px;
        padding: 30px;
        text-align: center;
        cursor: pointer;
        background-color: #f0f8ff;
    }

    .dropzone.dragover {
        background-color: #e0f2ff;
        border-color: #0056b3;
    }

    .preview {
        margin-top: 20px;
        display: none;
    }

    .preview img {
        max-width: 100%;
        border-radius: 5px;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
    }
</style>

<div id="content">
    <nav class="navbar"></nav>
    <div class="container-fluid">
        <div class="d-sm-flex align-items-center mb-4">
            <h1 class="h3 mb-0 text-gray-800">Daftar Produk &nbsp</h1>
            <i class="fas fa-chevron-right"></i>
            <h1 class="h3 mb-0 text-black-800">&nbsp <?= $title; ?></h1>
        </div>

        <div class="row m-sm-1">
            <div class="col-lg-12">
                <form action="<?php echo base_url() . 'produk/insert'; ?>" method="post" enctype="multipart/form-data">
                    <?= csrf_field(); ?>
                    <div class="row align-items-center mb-3">
                        <div class="col-lg-4 col-md-4 col-sm-12">
                            <div class="form-group mb-3">
                                <label for="kategori" class="form-label">Kategori</label>
                                <select id="kategori" name="kategori" class="form-select <?= isset(session()->getFlashdata('errors')['kategori']) ? 'is-invalid' : '' ?>" value="<?= old('kategori'); ?>">
                                    <option value="">Pilih Kategori</option>
                                    <!-- PREPARED STATEMENT -->
                                    <?php
                                        $db = \Config\Database::connect();
                                        $query = $db->table('kategori')
                                            ->get();
                                        $result = $query->getResult();
                                        foreach ($result as $row) {
                                            echo '<option value="' . $row->nama_kategori . '">' . $row->nama_kategori . '</option>';
                                        }
                                    ?>
                                </select>
                                <?php if (isset(session()->getFlashdata('errors')['kategori'])): ?>
                                    <div class="invalid-feedback"><?= session()->getFlashdata('errors')['kategori']; ?></div>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="col-lg-8 col-md-8 col-sm-12">
                            <div class="form-group">
                                <label for="nama_barang">Nama Barang</label>
                                <input type="text" class="form-control <?= isset(session()->getFlashdata('errors')['nama_barang']) ? 'is-invalid' : '' ?>" id="nama_barang" name="nama_barang" placeholder="Masukan Nama Barang" autofocus value="<?= old('nama_barang'); ?>">
                                <?php if (isset(session()->getFlashdata('errors')['nama_barang'])): ?>
                                    <div class="invalid-feedback"><?= session()->getFlashdata('errors')['nama_barang']; ?></div>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-12">
                            <div class="form-group">
                                <label for="harga_beli">Harga Beli</label>
                                <input type="text" class="form-control <?= isset(session()->getFlashdata('errors')['harga_beli']) ? 'is-invalid' : '' ?>" id="harga_beli" name="harga_beli" placeholder="Masukan Harga Beli" value="<?= old('harga_beli'); ?>">
                                <?php if (isset(session()->getFlashdata('errors')['harga_beli'])): ?>
                                    <div class="invalid-feedback"><?= session()->getFlashdata('errors')['harga_beli']; ?></div>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-8 col-sm-12">
                            <div class="form-group">
                                <label for="harga_jual">Harga Jual</label>
                                <input type="text" class="form-control <?= isset(session()->getFlashdata('errors')['harga_jual']) ? 'is-invalid' : '' ?>" id="harga_jual" name="harga_jual" placeholder="Masukan Harga Jual" value="<?= old('harga_jual'); ?>">
                                <?php if (isset(session()->getFlashdata('errors')['harga_jual'])): ?>
                                    <div class="invalid-feedback"><?= session()->getFlashdata('errors')['harga_jual']; ?></div>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-8 col-sm-12">
                            <div class="form-group">
                                <label for="stock_barang">Stock Barang</label>
                                <input type="text" class="form-control <?= isset(session()->getFlashdata('errors')['stock_barang']) ? 'is-invalid' : '' ?>" id="stok_barang" name="stock_barang" placeholder="Masukan Stock Barang" value="<?= old('stock_barang'); ?>">
                                <?php if (isset(session()->getFlashdata('errors')['stock_barang'])): ?>
                                    <div class="invalid-feedback"><?= session()->getFlashdata('errors')['stock_barang']; ?></div>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="col-lg-12 col-md-8 col-sm-12">
                            <label for="stock">Upload Gambar</label>
                            <input type="file" id="fileInput" name="image" hidden>
                            <div class="dropzone <?= isset(session()->getFlashdata('errors')['image']) ? 'is-invalid' : '' ?>" id="dropzone" value="<?= old('image'); ?>">
                                <img src="<?php echo base_url('icon/image.png'); ?>" alt="Preview Gambar" width="50px">
                                <p>Seret & Lepaskan Gambar di sini atau <strong>Klik untuk memilih</strong></p>
                                <div class="preview" id="preview">
                                    <img id="preview-img" src="#" alt="Preview Image" width="80px">
                                </div>
                            </div>
                            <?php if (isset(session()->getFlashdata('errors')['image'])): ?>
                                <div class="invalid-feedback">
                                    <?= session()->getFlashdata('errors')['image']; ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="d-flex justify-content-end">
                        <a href="<?php echo base_url() . '/produk'; ?>" class="btn btn-outline-primary px-5 m-sm-2">Batalkan</a>
                        <button type="submit" class="btn btn-primary px-5 m-2">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    const dropzone = document.getElementById("dropzone");
    const fileInput = document.getElementById("fileInput");
    const previewContainer = document.getElementById("preview");
    const previewImage = document.getElementById("preview-img");

    // Klik untuk memilih file
    dropzone.addEventListener("click", () => fileInput.click());

    // Seret & lepas file
    dropzone.addEventListener("dragover", (e) => {
        e.preventDefault();
        dropzone.classList.add("dragover");
    });

    dropzone.addEventListener("dragleave", () => dropzone.classList.remove("dragover"));

    dropzone.addEventListener("drop", (e) => {
        e.preventDefault();
        dropzone.classList.remove("dragover");

        const file = e.dataTransfer.files[0];
        if (file) {
            fileInput.files = e.dataTransfer.files; // Simpan file ke input
            previewFile(file);
        }
    });

    // Preview gambar
    fileInput.addEventListener("change", () => {
        const file = fileInput.files[0];
        if (file) {
            previewFile(file);
        }
    });

    function previewFile(file) {
        const reader = new FileReader();
        reader.onload = function() {
            previewImage.src = reader.result;
            previewContainer.style.display = "block";
        };
        reader.readAsDataURL(file);
    }
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<?= $this->endSection() ?>