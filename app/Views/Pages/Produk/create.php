<?php $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
    .dropzone {
        border: 2px dashed #007bff;
        border-radius: 10px;
        padding: 30px;
        text-align: center;
        color: #007bff;
        background-color: #f8f9fa;
        transition: background-color 0.3s, border-color 0.3s;
    }

    .dropzone.dragover {
        background-color: #e9f7ff;
        border-color: #0056b3;
    }

    .dropzone img {
        max-width: 100%;
        height: auto;
        margin-top: 15px;
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
                                <select id="kategori" name="kategori" class="form-select <?= ($validation->hasError('kategori')) ? 'is-invalid' : ''; ?>">
                                    <option value="">Pilih Kategori</option>
                                    <?php foreach ($kategori as $item): ?>
                                        <option value="<?= $item['nama_kategori']; ?>"><?= $item['nama_kategori']; ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <div class="invalid-feedback"><?= $validation->getError('kategori'); ?></div>
                            </div>
                        </div>
                        <div class="col-lg-8 col-md-8 col-sm-12">
                            <div class="form-group">
                                <label for="nama_barang">Nama Barang</label>
                                <input type="text" class="form-control <?= ($validation->hasError('nama_barang')) ? 'is-invalid' : ''; ?>" id="nama_barang" name="nama_barang" placeholder="Masukan Nama Barang">
                                <div class="invalid-feedback"><?= $validation->getError('nama_barang'); ?></div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-12">
                            <div class="form-group">
                                <label for="harga_beli">Harga Beli</label>
                                <input type="text" class="form-control <?= ($validation->hasError('harga_beli')) ? 'is-invalid' : ''; ?>" id="harga_beli" name="harga_beli" placeholder="Masukan Harga Beli">
                                <div class="invalid-feedback"><?= $validation->getError('harga_beli'); ?></div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-8 col-sm-12">
                            <div class="form-group">
                                <label for="harga_jual">Harga Jual</label>
                                <input type="text" class="form-control <?= ($validation->hasError('harga_jual')) ? 'is-invalid' : ''; ?>" id="harga_jual" name="harga_jual" placeholder="Masukan Harga Jual">
                                <div class="invalid-feedback"><?= $validation->getError('harga_jual'); ?></div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-8 col-sm-12">
                            <div class="form-group">
                                <label for="stock_barang">Stock Barang</label>
                                <input type="text" class="form-control <?= ($validation->hasError('stock_barang')) ? 'is-invalid' : ''; ?>" id="stok_barang" name="stock_barang" placeholder="Masukan Stock Barang">
                                <div class="invalid-feedback"><?= $validation->getError('stock_barang'); ?></div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-8 col-sm-12">
                            <div class="form-group">
                                <label for="image">Upload Image</label>
                                <input type="text" class="form-control <?= ($validation->hasError('image')) ? 'is-invalid' : ''; ?>" id="image" name="image" placeholder="contoh image">
                                <div class="invalid-feedback"><?= $validation->getError('image'); ?></div>
                            </div>
                        </div>
                        <!-- <div class="col-lg-12 col-md-8 col-sm-12">
                        <div class="form-group">
                            <label for="stock">Upload Image</label>
                            <div id="dropzone" class="dropzone">
                                <img src="<?php echo base_url('icon/image.png'); ?>" alt="Preview Gambar">
                                <p>Upload gambar disini</p>
                                <input type="file" id="fileInput" accept="image/*" style="display: none;">
                                <img id="preview" src="" alt="Preview Gambar" class="d-none">
                            </div>
                        </div>
                    </div> -->
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

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    const dropzone = document.getElementById("dropzone");
    const fileInput = document.getElementById("fileInput");
    const preview = document.getElementById("preview");

    // Klik pada dropzone untuk membuka file picker
    dropzone.addEventListener("click", () => fileInput.click());

    // Dragover event (saat file di-drag ke area dropzone)
    dropzone.addEventListener("dragover", (e) => {
        e.preventDefault();
        dropzone.classList.add("dragover");
    });

    // Dragleave event (saat file keluar dari area dropzone)
    dropzone.addEventListener("dragleave", () => {
        dropzone.classList.remove("dragover");
    });

    // Drop event (saat file dijatuhkan ke dropzone)
    dropzone.addEventListener("drop", (e) => {
        e.preventDefault();
        dropzone.classList.remove("dragover");
        const file = e.dataTransfer.files[0];
        handleFile(file);
    });

    // Saat file diunggah melalui file picker
    fileInput.addEventListener("change", (e) => {
        const file = e.target.files[0];
        handleFile(file);
    });

    // Fungsi untuk menampilkan preview gambar
    function handleFile(file) {
        if (file && file.type.startsWith("image/")) {
            const reader = new FileReader();
            reader.onload = (e) => {
                preview.src = e.target.result;
                preview.classList.remove("d-none");
            };
            reader.readAsDataURL(file);
        } else {
            alert("Mohon unggah file gambar!");
        }
    }
</script>

<?= $this->endSection() ?>