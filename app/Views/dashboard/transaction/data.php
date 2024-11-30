<?php

use Carbon\Carbon;

if (!empty($transactions)): ?>
    <!-- Table with stripped rows -->
    <table class="table datatable">
        <thead>
            <tr>
                <th>
                    <b>Order ID</b>
                </th>
                <th>Total Price</th>
                <th>Courier</th>
                <th>Payment Method</th>
                <th>Status</th>
                <th>Invoice</th>
                <th>Order Time</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($transactions as $item): ?>
                <tr>
                    <td><?= $item['id']; ?></td>
                    <td><?= number_to_currency($item['total_price'], 'IDR', 'id_ID'); ?></td>
                    <td><?= strtoupper($item['courier']) . ' - ' . $item['courier_service']; ?></td>
                    <td><?= $item['payment_method']; ?></td>
                    <td>
                        <?php if (strpos(strtolower($item['status']), 'finish') !== false): ?>
                            <p class="badge text-bg-success"><?= $item['status']; ?></p>
                        <?php elseif (strpos(strtolower($item['status']), 'cancel') !== false || strpos(strtolower($item['status']), 'fail') !== false): ?>
                            <p class="badge text-bg-danger"><?= $item['status']; ?></p>
                        <?php else: ?>
                            <p class="badge text-bg-warning"><?= $item['status']; ?></p>
                        <?php endif; ?>
                    </td>
                    <td><?= $item['invoice']; ?></td>
                    <td><?= Carbon::parse($item['created_at'])->format('d M Y, h:i'); ?></td>
                    <td>
                        <button type="button" class="btn btn-success" onclick="detail('<?= $item['id'] ?>')"><i class="ri-eye-fill"></i></button>
                        <?php if (in_array($item['status'], ['Awaiting Confirmation', 'Processed', 'Sent', 'Arrive at Destination'])): ?>
                            <button type="button" class="btn btn-warning" onclick="edit('<?= $item['id'] ?>')">
                                <i class="bx bxs-edit"></i>
                            </button>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <!-- End Table with stripped rows -->
<?php else: ?>
    <h3 class="text-center my-5">Belum ada data</h3>
<?php endif; ?>

<div class="viewModal"></div>


<script>
    function detail(id) {
        window.location.href = '<?= base_url('admin/transaction/detail/') ?>' + id;
    }

    function edit(id) {
        $.ajax({
            type: 'POST',
            url: '<?= base_url('admin/transaction/editForm') ?>',
            data: {
                id: id,
            },
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    $('.viewModal').html(response.success).show();
                    $('#editModal').modal('show');
                }
            },
            error: function(xhr, ajaxOptions, thrownError) {
                console.error(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
            }
        });
    }
</script>
