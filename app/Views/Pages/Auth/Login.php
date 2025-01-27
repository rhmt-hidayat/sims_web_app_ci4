<style>
    .password-wrapper {
        position: relative;
        /* display: inline-block; */
        display: flex;
        flex-direction: column;
        max-width: 650px;
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

<div class="card-body p-0">
    <div class="container-fluid h-100">
        <div class="row h-100 d-flex justify-content-center align-items-center">
            <div class="col-lg-6">
                <div class="p-5">
                    <div class="text-center">
                        <!-- <img src="<?php echo base_url('icon/Handbag.png'); ?>" class="colored-image" alt="logo"> -->
                        <h1 class="h4 text-gray-900 mb-4"><canvas id="canvas" width="20" height="20"></canvas><strong> SIMS Web App</strong></h1>
                        <h1 class="h4 text-gray-900 mb-4"><strong>Masuk atau buat akun<br>untuk memulai</strong> </h1>
                    </div>
                    <form class="user" action="<?php echo base_url() . 'auth'; ?>" method="post">
                        <?= csrf_field() ?>
                        <div class="form-group">
                            <input type="email" class="form-control form-control-user"
                                id="email" name="email" aria-describedby="email"
                                placeholder="@ masukan email anda" required>
                        </div>
                        <div class="form-group password-wrapper">
                            <input type="password" class="form-control form-control-user"
                                id="password" name="password" placeholder="Password">
                            <span class="toggle-password" onclick="togglePasswordVisibility()">
                                👁️ <!-- Icon mata -->
                            </span>
                        </div>
                        <button type="submit" class="btn btn-danger btn-user btn-block">
                            Login
                        </button>
                    </form>
                    <div class="text-center mt-3">
                        <a class="small" href="<?php echo base_url() . 'register'; ?>">Create an Account!</a>
                    </div>
                    <!-- Flashdata Pesan -->
                    <?php if (session()->getFlashdata('success')): ?>
                        <div style="color: green; border: 1px solid green; padding: 10px;" class="alert alert-success mt-5">
                            <?= session()->getFlashdata('success'); ?>
                        </div>
                    <?php endif; ?>

                    <?php if (session()->getFlashdata('error')): ?>
                        <div style="color: red; border: 1px solid red; padding: 10px;" class="alert alert-danger mt-5">
                            <?= session()->getFlashdata('error'); ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
            <div class="col-lg-6 d-none d-lg-block bg-login-image">
                <img src="<?php echo base_url('icon/Frame 98699.png'); ?>" class="img-fluid" alt="logo">
            </div>
        </div>
    </div>
</div>

<script>
    //logo canvas icon warna merah
    const canvas = document.getElementById('canvas');
    const ctx = canvas.getContext('2d');
    const img = new Image();
    img.src = '<?php echo base_url('icon/Handbag.png'); ?>';

    img.onload = () => {
        ctx.drawImage(img, 0, 0, 20, 20);

        const imageData = ctx.getImageData(0, 0, 150, 150);
        const data = imageData.data;

        for (let i = 0; i < data.length; i += 4) {
            // Jika warna putih (R=255, G=255, B=255), ubah jadi merah
            if (data[i] === 255 && data[i + 1] === 255 && data[i + 2] === 255) {
                data[i] = 255; // Merah
                data[i + 1] = 0; // Hijau
                data[i + 2] = 0; // Biru
            }
        }

        ctx.putImageData(imageData, 0, 0);
    };

    //fungsi toggle password
    function togglePasswordVisibility() {
        const passwordInput = document.getElementById('password');
        const toggleIcon = document.querySelector('.toggle-password');

        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            toggleIcon.textContent = '🙈'; // Ganti ikon menjadi "mata tertutup"
        } else {
            passwordInput.type = 'password';
            toggleIcon.textContent = '👁️'; // Ganti ikon menjadi "mata terbuka"
        }
    }
</script>