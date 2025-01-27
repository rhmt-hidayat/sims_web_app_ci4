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
                    <div class="p-5">
                        <div class="text-center">
                            <h1 class="h4 text-gray-900 mb-4"><canvas id="canvas" width="20" height="20"></canvas><strong> SIMS Web App</strong></h1>
                            <h1 class="h4 text-gray-900 mb-4">Silahkan Mengisi Data</h1>
                        </div>
                        <form class="user" action="<?php echo base_url() . 'authRegister'; ?>" method="post">
                            <div class="form-group">
                                <input type="text" class="form-control form-control-user"
                                    id="nama" name="nama" aria-describedby="nama"
                                    placeholder="Masukan Nama Anda" required>
                            </div>
                            <div class="form-group">
                                <input type="email" class="form-control form-control-user"
                                    id="email" name="email" aria-describedby="email"
                                    placeholder="Masukan Email Anda" required>
                            </div>
                            <div class="form-group password-wrapper">
                                <input type="password" class="form-control form-control-user"
                                    id="password" name="password" placeholder="Password" required>
                                <span class="toggle-password" onclick="togglePasswordVisibility()">
                                    👁️ <!-- Icon mata -->
                                </span>
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control form-control-user"
                                    id="posisi" name="posisi" aria-describedby="posisi"
                                    placeholder="Masukan Posisi Jabatan" required>
                            </div>
                            <button type="submit" class="btn btn-warning btn-user btn-block">
                                Daftar
                            </button>
                        </form>
                        <div class="text-center mt-3">
                            <a class="small" href="<?php echo base_url() . '/'; ?>">Sudah Memiliki Akun? Login</a>
                        </div>
                    </div>
                </div>
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