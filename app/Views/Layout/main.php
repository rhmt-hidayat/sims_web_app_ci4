<!-- HEADER -->
<?= $this->include('layout/header') ?>

<body id="page-top">
    <div id="wrapper">
        <!-- SIDEBAR -->
        <?= $this->include('layout/sidebar') ?>

        <div id="content-wrapper" class="d-flex flex-column">
            <?= $this->renderSection('content') ?>

            <!-- <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-right my-auto">
                        <span>Copyright &copy; 2025</span>
                    </div>
                </div>
            </footer> -->
        </div>
    </div>

    <!-- FOOTER -->
    <?= $this->include('layout/footer') ?>