<?php

use Carbon\Carbon; ?>

<div class="card-title d-flex justify-content-between align-content-center">
    <div>
        <h5>Order Id: <?= $transaction['id']; ?></h5>
    </div>
    <div>
        <p class="fw-normal fs-6">Order Date: <?= Carbon::parse($transaction['created_at'])->format('D, d M Y, h:i'); ?></p>
    </div>
</div>

<?php if (!empty($details)): ?>
    <!-- Table with stripped rows -->
    <table class="table datatable">
        <thead>
            <tr>
                <th>Menu ID</th>
                <th>Menu Name</th>
                <th>Price</th>
                <th>Quantity</th>
                <th>Total Price</th>
                <th>Notes</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $total = 0;
            $subtotal = 0;
            foreach ($details as $item):
                $total = $item['quantity'] * $item['menu_price']; ?>
                <tr>
                    <td><?= $item['menu_id']; ?></td>
                    <td><?= $item['menu_name']; ?></td>
                    <td><?= number_to_currency($item['menu_price'], 'IDR', 'id_ID'); ?></td>
                    <td><?= $item['quantity']; ?></td>
                    <td><?= number_to_currency($total, 'IDR', 'id_ID'); ?></td>
                    <td><?= $item['notes']; ?></td>
                </tr>
            <?php $subtotal += $total;
            endforeach; ?>
        </tbody>
    </table>

    <div class="row">
        <div class="col-7"></div>
        <div class="col-2">
            <p>Subtotal</p>
            <p>Service Fee</p>
            <p>Delivery</p>
            <p>Delivery Fee</p>
            <p>Total Shopping</p>
        </div>
        <div class="col-3">
            <p>: <?= number_to_currency($subtotal, 'IDR', 'id_ID'); ?></p>
            <p>: Rp 1.000</p>
            <p>: <?= strtoupper($transaction['courier']) . ' - ' . $transaction['courier_service']; ?></p>
            <p>: <?= number_to_currency($transaction['delivery_fee'], 'IDR', 'id_ID'); ?></p>
            <p>: <?= number_to_currency($transaction['total_price'], 'IDR', 'id_ID'); ?></p>
        </div>
    </div>

    <!-- End Table with stripped rows -->
<?php else: ?>
    <h3 class="text-center my-5">Belum ada data</h3>
<?php endif; ?>
