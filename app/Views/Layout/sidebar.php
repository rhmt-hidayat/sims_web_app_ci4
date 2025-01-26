<body id="page-top">
    <div id="wrapper">
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
            <div class="sidebar-brand d-flex align-items-center justify-content-center" href="#">
                <img src="<?php echo base_url('icon/Handbag.png'); ?>" class="img-fluid" alt="logo">
                <div class="sidebar-brand-text mx-7">&nbsp SIMS Web App</div>
                <!-- <i class="fas fa-bars"></i> -->
            </div>
            <li class="nav-item">
                <a class="nav-link" href="<?php echo base_url() . 'produk'; ?>">
                    <img src="<?php echo base_url('icon/Package.png'); ?>" class="img-fluid" alt="logo">
                    <span>Produk</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="<?php echo base_url() . 'profil'; ?>">
                    <img src="<?php echo base_url('icon/User.png'); ?>" class="img-fluid" alt="logo">
                    <span>Profil</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="<?php echo base_url() . '/'; ?>">
                    <img src="<?php echo base_url('icon/SignOut.png'); ?>" class="img-fluid" alt="logo">
                    <span>Logout</span></a>
            </li>
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>
        </ul>

        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                <nav class="navbar"></nav>