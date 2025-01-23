<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIMS Web App</title>
    <link rel="stylesheet" href="<?= base_url('styles.css') ?>">
    <script src="<?= base_url('script.js') ?>" defer></script>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>

<body>
    <div class="sidebar">
        <div class="logo-details">
            <div class="logo_name">SIMS Web App</div>
            <i class='bx bx-menu' id="btn"></i>
        </div>
        <ul class="nav-list">
            <li>
                <a href="<?php echo base_url() . '/'; ?>">
                    <!-- <i class='bx bx-grid-alt'></i> -->
                    <img src="<?php echo base_url('assets/Package.png'); ?>" alt="">
                    <span class="links_name">Produk</span>
                </a>
                <span class="tooltip">Produk</span>
            </li>
            <li>
                <a href="<?php echo base_url() . '/profil'; ?>">
                    <!-- <i class='bx bx-user'></i> -->
                    <img src="<?php echo base_url('assets/User.png'); ?>" alt="">
                    <span class="links_name">Profil</span>
                </a>
                <span class="tooltip">Profil</span>
            </li>
            <li>
                <a href="">
                    <!-- <i class='bx bx-log-out' id="log_out"></i> -->
                    <img src="<?php echo base_url('assets/SignOut.png'); ?>" alt="">
                    <span class="links_name">Logout</span>
                </a>
                <span class="tooltip">Logout</span>
            </li>

        </ul>
    </div>