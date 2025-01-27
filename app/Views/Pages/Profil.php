<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <img class="img-profile image-wrapper"
            src="<?php echo base_url('icon/Frame 98700.png'); ?>">
    </div>
    <h1 class="h3 mb-4 text-gray-800"><strong>Rahmat Hidayat</strong></h1>

    <div class="row mb-4">
        <?= csrf_field() ?>
        <div class="col-lg-8">
            <div class="form-group">
                <label for="nama">Nama Kandidat</label>
                <input type="text" class="form-control form-control-user"
                    id="nama" aria-describedby="nama" value="<?= esc(session()->get('nama')) ?>" readonly>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="form-group">
                <label for="posisi">Posisi Kandidat</label>
                <input type="text" class="form-control form-control-user"
                    id="posisi" aria-describedby="posisi" value="<?= esc(session()->get('posisi')) ?>" readonly>
            </div>
        </div>
    </div>