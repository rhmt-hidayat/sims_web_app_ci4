<style>
    .password-wrapper {
        position: relative;
        /* display: inline-block; */
        display: flex;
        flex-direction: column;
        max-width: 450px;
        /* Lebar maksimal untuk input password */
        margin-bottom: 20px;
    }

    .password-wrapper input {
        /* padding-right: 40px; */
        /* Tambahkan ruang untuk ikon mata */
        width: 100%;
        padding: 10px;
        padding-right: 50px;
        /* Tambahkan ruang untuk ikon mata */
        font-size: 16px;
        border: 1px solid #ccc;
        border-radius: 5px;
        box-sizing: border-box;
    }

    .password-wrapper .toggle-password {
        position: absolute;
        top: 50%;
        right: 15px;
        transform: translateY(-50%);
        cursor: pointer;
        font-size: 18px;
        color: #555;
    }
</style>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-6">
            <div class="card o-hidden border-0 shadow-lg my-5">
                <div class="card-body p-0">
                    <div class="row">
                        <div class="col-lg-12 d-none d-lg-block bg-password-image"></div>
                        <div class="col-lg-12">
                            <div class="p-5">
                                <div class="text-center">
                                    <h1 class="h4 text-gray-900 mb-2">Forgot Your Password?</h1>
                                    <p class="mb-4">Silahkan masukkan alamat email anda dan kami akan mengirimkan tautan untuk mengatur ulang kata sandi Anda</p>
                                </div>
                                <form class="user" action="<?= base_url('forgot-password') ?>" method="post">
                                    <div class="form-group">
                                        <input type="email" class="form-control form-control-user"
                                            id="email" name="email" aria-describedby="email"
                                            placeholder="Masukan email anda..." required>
                                    </div>
                                    <button type="submit" href="" class="btn btn-warning btn-user btn-block">
                                        Reset Password
                                    </button>
                                </form>
                                <div class="text-center mt-3">
                                    <a class="small" href="<?php echo base_url() . '/'; ?>">Kembali Login</a>
                                </div>

                                <?php if (session()->getFlashdata('error')): ?>
                                    <div style="color: red; border: 1px solid red; padding: 10px;" class="alert alert-danger mt-5">
                                        <?= session()->getFlashdata('error'); ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>