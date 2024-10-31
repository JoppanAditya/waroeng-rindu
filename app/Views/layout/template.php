<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title><?= $title != 'Home' ? $title . ' | ' : ''; ?>Waroeng Rindu</title>
    <meta content="" name="keywords">
    <meta content="" name="description">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600&family=Raleway:wght@600;800&display=swap" rel="stylesheet">

    <!-- Icon Font Stylesheet -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="<?= base_url('assets/'); ?>lib/lightbox/css/lightbox.min.css" rel="stylesheet">
    <link href="<?= base_url('assets/'); ?>lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Customized Bootstrap Stylesheet -->
    <link href="<?= base_url('assets/'); ?>css/bootstrap.min.css" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="<?= base_url('assets/'); ?>css/style.css" rel="stylesheet">
</head>

<body>

    <!-- Spinner Start -->
    <div id="spinner" class="show w-100 vh-100 bg-white position-fixed translate-middle top-50 start-50  d-flex align-items-center justify-content-center">
        <div class="spinner-grow text-primary" role="status"></div>
    </div>
    <!-- Spinner End -->

    <!-- Flashdata Start -->
    <?php if (session()->getFlashdata('success')): ?>
        <div class="flash-data" data-type="success" data-flashdata="<?= session()->getFlashdata('success'); ?>"></div>
    <?php endif; ?>

    <?php if (session()->getFlashdata('error')): ?>
        <div class="flash-data" data-type="error" data-flashdata="<?= session()->getFlashdata('error'); ?>"></div>
    <?php endif; ?>
    <!-- Flashdata End -->

    <?= $title != 'Transaction' ? view('layout/navbar') : ''; ?>

    <?= $this->renderSection('content') ?>

    <?= $title != 'Transaction' ? view('layout/footer') : ''; ?>

    <!-- Back to Top -->
    <a href="#" class="btn btn-primary border-3 border-primary rounded-circle back-to-top"><i class="fa fa-arrow-up"></i></a>

    <!-- JavaScript Libraries -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="<?= base_url('assets/'); ?>lib/easing/easing.min.js"></script>
    <script src="<?= base_url('assets/'); ?>lib/waypoints/waypoints.min.js"></script>
    <script src="<?= base_url('assets/'); ?>lib/lightbox/js/lightbox.min.js"></script>
    <script src="<?= base_url('assets/'); ?>lib/owlcarousel/owl.carousel.min.js"></script>

    <!-- Template Javascript -->
    <script src="<?= base_url('assets/'); ?>js/main.js"></script>
    <?= $this->renderSection('scripts'); ?>
</body>

</html>
