<?= $this->extend('dashboard/layout/template'); ?>

<?= $this->section('content'); ?>
<main id="main" class="main">

    <div class="pagetitle">
        <h1>Transaction Detail</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= base_url('admin/dashboard'); ?>">Home</a></li>
                <li class="breadcrumb-item"><a href="<?= base_url('admin/transaction'); ?>">Transaction</a></li>
                <li class="breadcrumb-item active"><?= $details[0]['transaction_id']; ?></li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="viewData"></div>
                    </div>
                </div>
            </div>
        </div>
        <a href="javascript:void(0)" onclick="window.history.back();" class="btn btn-primary mb-3">
            <i class="bi bi-caret-left-fill"></i> Back
        </a>

    </section>
</main><!-- End #main -->

<?= $this->endSection(); ?>

<?= $this->section('scripts'); ?>
<script>
    function transactionData() {
        $.ajax({
            url: "<?= base_url('admin/transaction/getDetail') ?>",
            type: 'POST',
            data: {
                data: <?= json_encode($details) ?>
            },
            dataType: 'json',
            beforeSend: function() {
                $('.viewData').html('<div class="text-center my-5"><div class="spinner-grow text-primary my-5" role="status"><span class="visually-hidden">Loading...</span></div></div>');
            },
            success: function(response) {
                $('.viewData').html(response.data);
            },
            error: function(xhr, ajaxOptions, thrownError) {
                console.error(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
            }
        });
    }

    $(document).ready(function() {
        transactionData();
    });
</script>
<?= $this->endSection(); ?>
