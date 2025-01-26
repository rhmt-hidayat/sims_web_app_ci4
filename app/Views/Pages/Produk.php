<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800"><?= $title; ?></h1>
    </div>

    <div class="row">
        <div class="col-lg-6 mb-4 text-left">
            <form
                class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
                <div class="input-group">
                    <input type="text" class="form-control bg-light border-0 small" placeholder="Cari Barang"
                        aria-label="Search" aria-describedby="basic-addon2">
                    <div class="input-group-append">
                        <button class="btn btn-primary" type="button">
                            <i class="fas fa-search fa-sm"></i>
                        </button>
                    </div>
                </div>
            </form>

            <select id="kategori" class="form-select">
                <option value="">
                    <img src="<?= base_url('icon/Package.png'); ?>" class="img-fluid" alt="logo">
                    Semua
                </option>
                <option value="olahraga">Alat Olahraga</option>
                <option value="musik">Alat Musik</option>
            </select>
        </div>
        <div class="col-lg-6 mb-4 text-right">
            <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-success shadow-sm"><img src="<?php echo base_url('icon/MicrosoftExcelLogo.png'); ?>" class="img-fluid" alt="logo"> Export Excel</a>
            <a href="<?php echo base_url() . 'add'; ?>" class="d-none d-sm-inline-block btn btn-sm btn-danger shadow-sm"><img src="<?php echo base_url('icon/PlusCircle.png'); ?>" class="img-fluid" alt="logo"> Tambah Produk</a>
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
                <tr>
                    <td>1</td>
                    <td width="1%"><img src="<?php echo base_url('icon/image 2.png'); ?>" class="img-fluid" alt="logo"></td>
                    <td>Raket Badminton</td>
                    <td>ALat Olahraga</td>
                    <td>100.000</td>
                    <td>130.000</td>
                    <td>35</td>
                    <td>
                        <a href="#"><img src="<?php echo base_url('icon/edit.png'); ?>" class="img-fluid" alt="logo"></a>
                        <a href="#"><img src="<?php echo base_url('icon/delete.png'); ?>" class="img-fluid" alt="logo"></a>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

</div>

</div>

<footer class="sticky-footer bg-white">
    <div class="container my-auto">
        <div class="copyright text-center my-auto">
            <span>Copyright &copy; 2025</span>
        </div>
    </div>
</footer>
</div>

</div>