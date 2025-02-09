<!-- HEADER -->
<?= $this->include('layout/header') ?>

<body id="page-top">
    <div id="wrapper">
        <!-- SIDEBAR -->
        <?= $this->include('layout/sidebar') ?>

        <div id="content-wrapper" class="d-flex flex-column">
            <!-- CONTENT -->
            <?= $this->renderSection('content') ?>
        </div>
    </div>

    <!-- FOOTER -->
    <?= $this->include('layout/footer') ?>