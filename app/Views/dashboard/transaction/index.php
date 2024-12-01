<?= $this->extend('dashboard/layout/template'); ?>

<?= $this->section('content'); ?>
<main id="main" class="main">

    <div class="pagetitle">
        <h1>Transaction Management</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= base_url('admin/dashboard'); ?>">Home</a></li>
                <li class="breadcrumb-item active">Transaction</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="card-title d-flex justify-content-between align-items-center">
                            <div>
                                <h5>Order List</h5>
                            </div>
                            <div>
                                <button type="button" class="btn btn-secondary printBtn"><i class="bi bi-printer"></i></button>
                                <button class="btn btn-primary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="bi bi-download"></i>
                                </button>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="<?= base_url('admin/transaction/reportPdf'); ?>"><i class="bi bi-file-earmark-pdf me-2"></i>PDF</a></li>
                                    <li><a class="dropdown-item" href="<?= base_url('admin/transaction/reportExcel'); ?>"><i class="bi bi-file-earmark-excel me-2"></i>Ms. Excel</a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="viewData"></div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main><!-- End #main -->

<div class="viewModal" style="display: none;"></div>
<?= $this->endSection(); ?>

<?= $this->section('scripts'); ?>
<script>
    function transactionData() {
        $.ajax({
            url: '<?= base_url('admin/transaction/get') ?>',
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

        $('.printBtn').click(function() {
            window.open("<?= base_url('admin/transaction/report') ?>", "_blank");
        });
    });
</script>

<?= $this->endSection(); ?>
