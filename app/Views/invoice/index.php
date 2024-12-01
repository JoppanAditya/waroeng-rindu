<?php

use Carbon\Carbon; ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Invoice | Waroeng Rindu</title>
    <link href="<?= base_url('assets/'); ?>img/favicon.png" rel="icon">

    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet" />
</head>

<body class="bg-gray-100 font-sans print:bg-white">
    <nav class="bg-gray-100 mb-2 mt-4 print:hidden max-w-4xl mx-auto">
        <div class="container mx-auto flex justify-end ">
            <button type="button" id="printButton" class="bg-blue-500 text-white py-2 px-4 rounded flex items-center hover:bg-blue-600">
                <i class="fas fa-print mr-2"></i> Print
            </button>
        </div>
    </nav>

    <div class="max-w-4xl mx-auto my-10 print:my-0 bg-white p-8 rounded-lg">
        <!-- Header -->
        <div class="flex justify-between items-start mb-8">
            <div class="flex items-center">
                <img src="<?= base_url('assets/img/logo.png'); ?>" alt="Waroeng Rindu Logo" class="h-16 mr-4" />
                <div>
                    <h1 class="text-3xl font-bold text-gray-800">Waroeng<span class="text-teal-700"> Rindu</span></h1>
                    <p class="text-gray-500 text-sm">
                        (+021) 3456 7890<br>
                        info@waroengrindu.swmenteng.com
                    </p>
                </div>
            </div>
            <div class="text-center">
                <h2 class="text-2xl font-bold text-gray-700">INVOICE</h2>
                <p class="text-gray-500 mt-1"><?= $data['invoice']; ?></p>
            </div>
        </div>

        <!-- Buyer and Shipping Information -->
        <div class="mb-8">
            <p class="text-gray-600"><i class="fas fa-user icon mr-2"></i><span class="font-semibold">Buyer:</span> <?= $data['fullname']; ?></p>
            <p class="text-gray-600"><i class="fas fa-calendar-day icon mr-2"></i><span class="font-semibold">Purchase Date:</span> <?= Carbon::parse($data['created_at'])->format('d F Y'); ?></p>
            <p class="text-gray-600"><i class="fas fa-map-marker-alt icon mr-2"></i><span class="font-semibold">Shipping Address:</span><br /><?= $data['address_name'] . ' (' . $data['phone'] . ') ' . $data['full_address']; ?><br><?= $data['city_name'] . ', ' . $data['province_name'] . ' ' . $data['postal_code']; ?></p>
        </div>

        <!-- Item List -->
        <table class="w-full mb-8 border border-gray-200 rounded-lg">
            <thead class="bg-gray-100">
                <tr>
                    <th class="text-left py-3 px-4 text-gray-600">ITEM NAME</th>
                    <th class="text-left py-3 px-4 text-gray-600">QUANTITY</th>
                    <th class="text-left py-3 px-4 text-gray-600">UNIT PRICE</th>
                    <th class="text-left py-3 px-4 text-gray-600">SUBTOTAL</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $subtotal = 0;
                $total = 0;
                foreach ($items as $item):
                    $subtotal = $item['menu_price'] * $item['quantity'];
                ?>
                    <tr class="border-t">
                        <td class="py-3 px-4"><?= $item['menu_name']; ?></td>
                        <td class="py-3 px-4"><?= $item['quantity']; ?></td>
                        <td class="py-3 px-4"><?= number_to_currency($item['menu_price'], 'IDR', 'id_ID'); ?></td>
                        <td class="py-3 px-4"><?= number_to_currency($subtotal, 'IDR', 'id_ID'); ?></td>
                    </tr>
                <?php $total += $subtotal;
                endforeach ?>
            </tbody>
        </table>

        <!-- Total and Payment -->
        <div class="mt-6">
            <div class="flex justify-between items-center py-3 border-t">
                <p class="text-gray-600"><i class="fas fa-wallet mr-2"></i>TOTAL PRICE</p>
                <p class="font-semibold"><?= number_to_currency($total, 'IDR', 'id_ID'); ?></p>
            </div>
            <div class="flex justify-between items-center py-3">
                <p class="text-gray-600"><i class="fas fa-truck mr-2"></i>Delivery Fee Total</p>
                <p class="font-semibold"><?= number_to_currency($data['delivery_fee'], 'IDR', 'id_ID'); ?></p>
            </div>
            <div class="flex justify-between items-center py-3">
                <p class="text-gray-600"><i class="fas fa-cogs mr-2"></i>Service Fee Total</p>
                <p class="font-semibold">Rp 1.000</p>
            </div>
            <div class="flex justify-between items-center py-3 border-t font-bold">
                <p class="text-gray-600"><i class="fas fa-money-bill-wave mr-2"></i>TOTAL BILL</p>
                <p class="text-lg"><?= number_to_currency($data['total_price'], 'IDR', 'id_ID'); ?></p>
            </div>
        </div>

        <!-- Shipping and Payment -->
        <div class="flex justify-between items-center mt-8">
            <p class="text-gray-600"><i class="fas fa-shipping-fast mr-2"></i><span class="font-semibold">Courier:</span> <?= strtoupper($data['courier']) . ' - ' . $data['courier_service']; ?></p>
            <div class="text-right">
                <p class="text-gray-600"><i class="fas fa-credit-card mr-2"></i>Payment Method:</p>
                <p class="font-bold text-gray-700"><?= strtoupper(str_replace('_', ' ', $data['payment_method'])); ?></p>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#printButton').on('click', function() {
                window.print();
            });
        });
    </script>
</body>

</html>
