<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>Transaction Report | Waroeng Rindu</title>

    <!-- Favicons -->
    <link href="<?= base_url('assets/'); ?>img/favicon.png" rel="icon">
    <link href="<?= base_url('assets/'); ?>img/apple-touch-icon.png" rel="apple-touch-icon">

    <!-- Google Fonts -->
    <link href="https://fonts.gstatic.com" rel="preconnect">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

    <!-- Custom CSS -->
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            font-size: 14px;
            padding: 12px;
        }

        h3 {
            font-size: 24px;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            margin-bottom: 12px;
            background-color: #fff;
            border-radius: 5px;
            border-collapse: collapse;
        }

        table thead {
            background-color: #257180;
            color: white;
        }

        td,
        th {
            padding: 10px 12px;
            text-align: left;
        }

        .table-striped tbody tr:nth-child(odd) {
            background-color: #f2f2f2;
        }

        .text-center {
            text-align: center;
        }

        .badge {
            display: inline-block;
            padding: 5px 10px;
            font-size: 10px;
            border-radius: 5px;
        }

        .text-bg-success {
            background-color: #28a745;
            color: white;
        }

        .text-bg-danger {
            background-color: #dc3545;
            color: white;
        }

        .text-bg-warning {
            background-color: #ffc107;
            color: black;
        }

        .my-3 {
            margin-top: 20px;
            margin-bottom: 20px;
        }

        .my-5 {
            margin-top: 40px;
            margin-bottom: 40px;
        }

        .spinner-grow {
            width: 3rem;
            height: 3rem;
        }

        .text-primary {
            color: #007bff !important;
        }
    </style>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body class="container mt-4">
    <?php

    use Carbon\Carbon;

    if (!empty($transactions)): ?>
        <h3 class="my-3 text-center">Transaction Report</h3>
        <!-- Table with stripped rows -->
        <table class="table-striped table-bordered">
            <thead class="text-center">
                <tr>
                    <th><b>Order ID</b></th>
                    <th>Customer</th>
                    <th>Order Time</th>
                    <th>Payment Method</th>
                    <th>Courier</th>
                    <th>Delivery Fee</th>
                    <th>Total Price</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($transactions as $item):
                    $status = strtolower($item['status']);
                    if (strpos($status, 'finish') !== false) {
                        $bg_color = 'text-bg-success';
                    } elseif (strpos($status, 'cancel') !== false || strpos($status, 'fail') !== false) {
                        $bg_color = 'text-bg-danger';
                    } else {
                        $bg_color = 'text-bg-warning';
                    }
                ?>
                    <tr>
                        <td><?= $item['id']; ?></td>
                        <td><?= $item['fullname']; ?></td>
                        <td><?= Carbon::parse($item['created_at'])->format('d M Y, h:i'); ?></td>
                        <td><?= strtoupper(str_replace('_', ' ', $item['payment_method'])); ?></td>
                        <td><?= strtoupper($item['courier']) . ' - ' . $item['courier_service']; ?></td>
                        <td><?= number_to_currency($item['delivery_fee'], 'IDR', 'id_ID'); ?></td>
                        <td><?= number_to_currency($item['total_price'], 'IDR', 'id_ID'); ?></td>
                        <td><span class="badge <?= $bg_color; ?>"><?= $item['status']; ?></span></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <!-- End Table with stripped rows -->
    <?php else: ?>
        <h3 class="text-center my-5">Belum ada data</h3>
    <?php endif; ?>

    <script>
        $(document).ready(function() {
            window.print();
        });
    </script>

</body>

</html>
