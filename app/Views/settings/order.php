<?= $this->extend('settings/template'); ?>

<?= $this->section('card-content'); ?>
<?php

use Carbon\Carbon;

foreach ($transactions as $t) :

    $status = strtolower($t['status']);
    if (strpos($status, 'finish') !== false) {
        $bg_color = 'bg-success';
    } elseif (strpos($status, 'cancel') !== false || strpos($status, 'fail') !== false) {
        $bg_color = 'bg-danger';
    } else {
        $bg_color = 'bg-warning text-dark';
    }
?>

    <div class="card mt-3">
        <div class="card-body text-start row" style="font-size: 14px;">
            <div class="d-flex gap-2 align-items-center">
                <p class="mb-0"><?= Carbon::parse($t['created_at'])->format('d M Y, h:i'); ?></p>
                <span class="badge <?= $bg_color; ?>"><?= $t['status']; ?></span>
                <a href="<?= base_url('invoice?id=' . urlencode($t['invoice'])); ?>" target="blank" class="mb-0 text-decoration-none" style="color: #3468c0;"><?= $t['invoice']; ?></a>
            </div>
            <div class="d-flex mt-3">
                <img src="<?= base_url('assets/img/menu/') . $t['menu_image'] ?>" alt="<?= $t['menu_name'] ?>" class="rounded" width="75" height="75">
                <div class="row w-100 fs-6 ms-2">
                    <div class="col-md-9 d-flex flex-column">
                        <a href=<?= base_url('shop/') . $t['slug'] ?> class="text-decoration-none fw-medium text-reset"><?= $t['menu_name']; ?></a>
                        <span class="text-secondary" style="font-size: 14px;">
                            <?= $t['quantity'] . ' &times; ' . number_to_currency($t['total_price'] * $t['quantity'], 'IDR', 'id_ID'); ?>
                        </span>
                    </div>
                    <div class="col-md-3 border-start d-flex justify-content-center flex-column">
                        <span class="text-secondary" style="font-size: 14px;">Total Price</span>
                        <p class="fw-semibold m-0" style="color: #3468c0;"><?= number_to_currency($t['total_price'], 'IDR', 'id_ID'); ?></p>
                    </div>
                </div>
            </div>
            <div class="d-flex gap-2 justify-content-end">
                <button type="button" class="btn btn-link btn">View Order Details</button>
                <?php if ($t['status'] == 'Finished' && $t['is_reviewed'] == 0): ?>
                    <button type="button" class="btn btn-outline-primary finish-order" data-id="<?= $t['id']; ?>">Write Review</button>
                <?php endif;
                if ($t['status'] == 'Finished'): ?>
                    <button type="button" class="btn btn-primary buy-again">Buy Again</button>
                <?php elseif ($t['status'] == 'Arrive at Destination'): ?>
                    <button type="button" class="btn btn-primary finish-order" data-id="<?= $t['id']; ?>">Finish Order</button>
                <?php endif ?>
            </div>
        </div>
    </div>
<?php endforeach; ?>
<?= $this->endSection(); ?>

<?= $this->section('scripts'); ?>
<script>
    $('.finish-order').on('click', function() {
        var transactionId = $(this).data('id');

        Swal.fire({
            title: 'Is the Order Correct?',
            text: 'Please make sure everything is correct before completing the transaction.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, Complete the Order!',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '<?= base_url('transaction/updateStatus'); ?>',
                    method: 'POST',
                    data: {
                        transaction_id: transactionId,
                        status: 'Finished'
                    },
                    success: function(response) {
                        if (response.success) {
                            Toast.fire({
                                icon: "success",
                                title: response.success
                            }).then(() => {
                                location.reload();
                            });
                        } else {
                            Toast.fire({
                                icon: "error",
                                title: response.error
                            });
                        }
                    },
                    error: function(xhr, ajaxOptions, thrownError) {
                        console.error(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                    }
                });
            }
        });
    });
</script>
<?= $this->endSection(); ?>
