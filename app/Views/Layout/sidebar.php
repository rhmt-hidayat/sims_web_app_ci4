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
        <a class="nav-link" href="#" data-toggle="modal" data-target="#logoutModal">
            <img src="<?php echo base_url('icon/SignOut.png'); ?>" class="img-fluid" alt="logo">
            <span>Logout</span></a>
    </li>
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>
</ul>

<div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel" style="color:red">Peringatan</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">Apakah anda yakin ingin keluar ?</div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Tidak</button>
                <a class="btn btn-primary" href="<?php echo base_url() . 'logout'; ?>">Iya</a>
            </div>
        </div>
    </div>
</div>