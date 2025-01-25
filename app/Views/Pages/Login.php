<div class="card-body p-0">
    <!-- Nested Row within Card Body -->
    <div class="row">
        <div class="col-lg-6">
            <div class="p-5">
                <div class="text-center">
                    <img src="<?php echo base_url('icon/Handbag.png'); ?>" class="img-fluid" alt="logo">
                    <h1 class="h4 text-gray-900 mb-4"><strong>SIMS Web App</strong></h1>
                    <h1 class="h4 text-gray-900 mb-4"><strong>Masuk atau buat akun<br>untuk memulai</strong> </h1>
                </div>
                <form class="user">
                    <div class="form-group">
                        <input type="email" class="form-control form-control-user"
                            id="exampleInputEmail" aria-describedby="emailHelp"
                            placeholder="@ masukan email anda" required>
                    </div>
                    <div class="form-group">
                        <input type="password" class="form-control form-control-user"
                            id="exampleInputPassword" placeholder="masukan password anda" required>
                    </div>
                    <a href="<?php echo base_url() . 'produk'; ?>" class="btn btn-danger btn-user btn-block">
                        Login
                    </a>
            </div>
        </div>
        <div class="col-lg-6 d-none d-lg-block bg-login-image">
            <img src="<?php echo base_url('icon/Frame 98699.png'); ?>" class="img-fluid" alt="logo">
        </div>
    </div>
</div>