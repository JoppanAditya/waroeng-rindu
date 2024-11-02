<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>
<!-- Navbar Start -->
<nav class="navbar navbar-expand-lg bg-body-tertiary">
    <div class="container">
        <a class="navbar-brand m-0" style="cursor: pointer;" data-bs-toggle="modal" data-bs-target="#ConfirmModal">
            <img src="<?= base_url('assets/img/logo.svg') ?>" alt="Waroeng Rindu Logo" height="120" />
        </a>
    </div>
</nav>
<!-- Navbar End -->

<main>
    <div class="container my-4">
    </div>
</main>

<!-- Confirmation Modal -->
<div class="modal fade" id="ConfirmModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="ConfirmModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md">
        <div class="modal-content">
            <div class="modal-body text-center p-4">
                <h4 class="fw-semibold">Back To Cart?</h4>
                <p style="font-size: 14px;">Discard all changes and return to cart?</p>
                <button type="button" class="btn btn-primary w-100" data-bs-dismiss="modal">Stay On This Page</button>
                <a type="button" class="btn btn-link text-decoration-none mt-2" href="<?= base_url('cart') ?>">Back and Discard Changes</a>
            </div>
        </div>
    </div>
</div>

<!-- Copyright -->
<div class="text-center py-3 bg-body-tertiary mt-auto">
    &copy; <?= date("Y"); ?> Waroeng Rindu. All rights reserved.
</div>
<?= $this->endSection(); ?>

<?= $this->section('scripts'); ?>
<script></script>
<?= $this->endSection(); ?>
