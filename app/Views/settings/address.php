<?= $this->extend('settings/template'); ?>

<?= $this->section('card-content'); ?>
<div class="d-flex justify-content-between align-items-center">
    <!-- Add Button trigger modal -->
    <button type="button" class="btn btn-primary mt-2 addButton">
        <i class="fas fa-plus me-2"></i>
        Add New Address
    </button>
</div>

<div class="viewData"></div>

<div class="viewModal"></div>
<?= $this->endSection(); ?>

<?= $this->section('scripts'); ?>
<script>
    function addressData() {
        $.ajax({
            url: '<?= base_url('address/get') ?>',
            method: 'GET',
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
    };

    $(document).ready(function() {
        addressData();

        $('.addButton').click(function(e) {
            e.preventDefault();

            $.ajax({
                url: '<?= base_url('address/addForm') ?>',
                dataType: 'json',
                beforeSend: function() {
                    $('.addButton').attr('disabled', 'disabled');
                    $('.addButton').html('<span class="spinner-border spinner-border-sm me-1" aria-hidden="true"></span><span role="status">Loading...</span>');
                },
                complete: function() {
                    $('.addButton').removeAttr('disabled', 'disabled');
                    $('.addButton').html('<i class="fas fa-plus me-1"></i>Add New Address');
                },
                success: function(response) {
                    $('.viewModal').html(response.data).show();
                    $('#addModal').modal('show');
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    console.error(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                }
            });
        });
    });
</script>
<?= $this->endSection(); ?>
