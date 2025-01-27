<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800"><?= $title; ?></h1>
    </div>

    <div class="row">
        <div class="col-lg-6 mb-4 text-left">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Detail Produk</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-4">
                            <img src="<?= base_url('icon/' . $produk['image']); ?>" class="img-fluid" alt="logo">
                        </div>
                        <div class="col-lg-8">
                            <div class="form-group">
                                <label for="nama_barang">Nama Barang</label>
                                <input type="text" class="form-control" id="nama_barang" name="nama_barang" placeholder="Masukan Nama Barang" value="<?= $produk['nama_barang'] ?>" readonly>
                            </div>
                            <div class="form-group">
                                <label for="harga_beli">Harga Beli</label>
                                <input type="text" class="form-control" id="harga_beli" name="harga_beli" placeholder="Masukan Harga Beli" value="<?= $produk['harga_beli'] ?>" readonly>
                            </div>  
                            <div class="form-group">
                                <label for="harga_jual">Harga Jual</label>
                                <input type="text" class="form-control" id="harga_jual" name="harga_jual" placeholder="Masukan Harga Jual" value="<?= $produk['harga_jual'] ?>" readonly>
                            </div>
                            <div class="form-group">
                                <label for="stock_barang">Stock Barang</label>
                                <input type="text" class="form-control" id="stok_barang" name="stock_barang" placeholder="Masukan Stock Barang" value="<?= $produk['stock_barang'] ?>" readonly>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>