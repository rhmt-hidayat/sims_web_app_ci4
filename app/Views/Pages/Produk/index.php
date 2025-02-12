<?php $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<div id="content">
    <nav class="navbar"></nav>
    <!-- CONTENT -->
    <div class="container-fluid">
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800"><?= $title; ?></h1>
        </div>

        <!-- Flashdata Pesan -->
        <?php if (session()->getFlashdata('success')): ?>
            <div style="color: green; border: 1px solid green; padding: 10px;" class="alert alert-success">
                <?= session()->getFlashdata('success'); ?>
            </div>
        <?php endif; ?>

        <?php if (session()->getFlashdata('error')): ?>
            <div style="color: red; border: 1px solid red; padding: 10px;" class="alert alert-danger">
                <?= session()->getFlashdata('error'); ?>
            </div>
        <?php endif; ?>

        <div class="row">
            <div class="col-lg-6 mb-4 text-left">
                <form action="" method="get"
                    class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
                    <div class="input-group">
                        <input type="text" class="form-control bg-light border-0 small" placeholder="Cari Barang" name="keyword"
                            aria-label="Search" aria-describedby="basic-addon2">
                        <div class="input-group-append">
                            <button class="btn btn-secondary" type="submit">
                                <i class="fas fa-search fa-sm"></i>
                            </button>
                        </div>
                    </div>
                </form>

                <form id="filterForm" method="get" action="<?= base_url('/produk'); ?>" class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
                    <select id="kategori" name="kategori" onchange="submitForm()" class="form-select">
                        <option value="">
                            <img src="<?= base_url('icon/Package.png'); ?>" class="img-fluid" alt="logo">
                            Semua
                        </option>
                        <option value="Alat Olahraga">Alat Olahraga</option>
                        <option value="Alat Music">Alat Music</option>
                    </select>
                </form>
            </div>
            <div class="col-lg-6 mb-4 text-right">
                <a href="<?php echo base_url() . 'produk/export'; ?>" class="d-none d-sm-inline-block btn btn-sm btn-success shadow-sm"><img src="<?php echo base_url('icon/MicrosoftExcelLogo.png'); ?>" class="img-fluid" alt="logo"> Export Excel</a>
                <a href="<?php echo base_url() . 'produk/add'; ?>" class="d-none d-sm-inline-block btn btn-sm btn-danger shadow-sm"><img src="<?php echo base_url('icon/PlusCircle.png'); ?>" class="img-fluid" alt="logo"> Tambah Produk</a>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Image</th>
                        <th>Nama Produk</th>
                        <th>Kategori Produk</th>
                        <th>Harga Beli (Rp)</th>
                        <th>Harga Jual (Rp)</th>
                        <th>Stok Produk</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1 + (5 * ($currentPage - 1)); //nomor urut di pagination produk
                    foreach ($produk as $rows) : ?>
                        <tr>
                            <td><?= $no++; ?></td>
                            <td width="1%"><img src="<?php echo base_url('uploads/') . $rows['image']; ?>" class="img-fluid" alt="logo"></td>
                            <td><?= $rows['nama_barang'] ?></td>
                            <td><?= $rows['kategori'] ?></td>
                            <td><?= number_format($rows['harga_beli'], 0, ',', ','); ?></td>
                            <td><?= number_format($rows['harga_jual'], 0, ',', ','); ?></td>
                            <td><?= $rows['stock_barang'] ?></td>
                            <td>
                                <a href="/produk/detail/<?= $rows['slug'] ?>"><i class="fas fa-eye"></i></a>
                                <a href="<?= base_url('produk/' . $rows['id'] . '/edit') ?>"><img src="<?php echo base_url('icon/edit.png'); ?>" class="img-fluid" alt="logo"></a>
                                <a href="#"><img src="<?php echo base_url('icon/delete.png'); ?>" data-href="<?= base_url('produk/' . $rows['id'] . '/delete') ?>" onclick="confirmToDelete(this)" class="img-fluid" alt="logo"></a>
                            </td>
                        </tr>
                    <?php endforeach ?>
                </tbody>
            </table>
            <?= $pager->links('produk', 'produk_pager') ?>
        </div>
    </div>
</div>

<div id="confirm-dialog" class="modal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <h2 class="h2">Apa Anda Yakin ?</h2>
                <p>Data akan dihapus secara permanen</p>
            </div>
            <div class="modal-footer">
                <a href="#" role="button" id="delete-button" class="btn btn-danger">Delete</a>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>

<script>
    function confirmToDelete(el) {
        $("#delete-button").attr("href", el.dataset.href);
        $("#confirm-dialog").modal('show');
    }

    function submitForm() {
        document.getElementById("filterForm").submit();
    }

    //menangkap value dropdown kategori diteruskan ke controller export
    // document.getElementById("exportExcel").addEventListener("click", function() {
    //     event.preventDefault();
    //     // Ambil nilai dropdown
    //     let kategori = document.getElementById("kategori").value;
    //     if (kategori === "") {
    //         alert("Silakan pilih kategori terlebih dahulu!");
    //         return;
    //     }
    //     // Encode kategori agar aman dalam URL
    //     let encodedKategori = encodeURIComponent(kategori);
    //     window.location.href = "<?= base_url('produk/export') ?>?kategori=" + encodedKategori;
    // });
</script>

<?= $this->endSection() ?>