<?= $this->extend('dashboard/layout/template'); ?>

<?= $this->section('content'); ?>
<main id="main" class="main">

    <div class="pagetitle">
        <h1>Menu Category Management</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= base_url('admin/dashboard'); ?>">Home</a></li>
                <li class="breadcrumb-item"><a href="<?= base_url('admin'); ?>">Menu</a></li>
                <li class="breadcrumb-item active">Category</li>
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
                                <h5>Menu Category List</h5>
                            </div>
                            <div>
                                <button type="button" class="btn btn-primary addButton"><i class="bx bx-plus"></i> Add Category</button>
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
    const Toast = Swal.mixin({
        toast: true,
        position: "top-end",
        showConfirmButton: false,
        timer: 5000,
        timerProgressBar: true,
        didOpen: (toast) => {
            toast.onmouseenter = Swal.stopTimer;
            toast.onmouseleave = Swal.resumeTimer;
        }
    });

    function categoryData() {
        $.ajax({
            url: '<?= base_url('admin/category/get') ?>',
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
        categoryData();

        $('.addButton').click(function(e) {
            e.preventDefault();

            $.ajax({
                url: '<?= base_url('admin/category/addForm') ?>',
                dataType: 'json',
                success: function(response) {
                    $('.viewModal').html(response.data).show();
                    $('#addModal').modal('show');
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    console.error(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                }
            });
        })
    });
</script>

<?= $this->endSection(); ?>
