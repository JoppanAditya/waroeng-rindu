<?= $this->extend('settings/template'); ?>

<?= $this->section('card-content'); ?>
<div>
    <h5 class="text-start mb-3 mt-3 mt-md-0">My Favorite Menu</h5>
</div>

<div class="viewData"></div>

<?= $this->endSection(); ?>

<?= $this->section('scripts'); ?>
<script>
    function wishlistData() {
        $.ajax({
            url: '<?= base_url('cart/getFavorite') ?>',
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
        wishlistData();
    });
</script>
<?= $this->endSection(); ?>
