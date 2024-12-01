<?= $this->extend('dashboard/layout/template'); ?>

<?= $this->section('content'); ?>
<main id="main" class="main">

    <div class="pagetitle">
        <h1>Dashboard</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                <li class="breadcrumb-item active">Dashboard</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section dashboard">
        <div class="row">

            <!-- Left side columns -->
            <div class="col-lg-12">
                <div class="row">

                    <!-- Sales Card -->
                    <div class="col-xxl-4 col-md-6">
                        <div class="card info-card sales-card">
                            <div class="card-body">
                                <h5 class="card-title">Orders</h5>
                                <div class="d-flex align-items-center">
                                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                        <i class="bi bi-cart"></i>
                                    </div>
                                    <div class="ps-3">
                                        <h6><?= countData("transactions"); ?></h6>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div><!-- End Sales Card -->

                    <!-- Revenue Card -->
                    <div class="col-xxl-4 col-md-6">
                        <div class="card info-card revenue-card">
                            <div class="card-body">
                                <h5 class="card-title">Revenue</h5>
                                <div class="d-flex align-items-center">
                                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                        <i class="bi bi-currency-dollar"></i>
                                    </div>
                                    <div class="ps-3">
                                        <h6><?= number_to_currency($totalRevenue, 'IDR', 'id_ID'); ?></h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div><!-- End Revenue Card -->

                    <!-- Customers Card -->
                    <div class="col-xxl-4 col-xl-12">
                        <div class="card info-card customers-card">
                            <div class="card-body">
                                <h5 class="card-title">Customers</h5>
                                <div class="d-flex align-items-center">
                                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                        <i class="bi bi-people"></i>
                                    </div>
                                    <div class="ps-3">
                                        <h6><?= countData("users"); ?></h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div><!-- End Customers Card -->

                    <!-- Reports -->
                    <div class="col-12">
                        <div class="card">

                            <div class="card-body">
                                <h5 class="card-title">Reports</h5>

                                <!-- Line Chart -->
                                <div id="reportsChart"></div>

                                <script>
                                    document.addEventListener("DOMContentLoaded", () => {
                                        $.ajax({
                                            url: "<?= base_url('admin/reports/sales') ?>",
                                            type: 'GET',
                                            dataType: 'json',
                                            beforeSend: function() {
                                                $('.reportsChart').html('<div class="text-center my-5"><div class="spinner-grow text-primary my-5" role="status"><span class="visually-hidden">Loading...</span></div></div>');
                                            },
                                            success: function(response) {
                                                new ApexCharts(document.querySelector("#reportsChart"), {
                                                    series: response.series,
                                                    chart: {
                                                        type: 'area',
                                                        height: 350,
                                                    },
                                                    xaxis: {
                                                        categories: response.categories,
                                                        type: 'datetime'
                                                    },
                                                    colors: ['#4154f1', '#2eca6a'],
                                                    stroke: {
                                                        curve: 'smooth',
                                                        width: 2
                                                    }
                                                }).render();
                                            },
                                            error: function(xhr, ajaxOptions, thrownError) {
                                                console.error(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                                            }
                                        });

                                    });
                                </script>
                                <!-- End Line Chart -->

                            </div>

                        </div>
                    </div><!-- End Reports -->

                    <!-- Recent Sales -->
                    <div class="col-12">
                        <div class="card recent-sales overflow-auto">

                            <div class="card-body">
                                <h5 class="card-title">Recent Sales</h5>

                                <table class="table table-borderless datatable">
                                    <thead>
                                        <tr>
                                            <th scope="col">Transaction ID</th>
                                            <th scope="col">Customer</th>
                                            <th scope="col">Payment Method</th>
                                            <th scope="col">Courier</th>
                                            <th scope="col">Price</th>
                                            <th scope="col">Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        foreach ($recentSales as $rs):
                                            $status = strtolower($rs['status']);
                                            if (strpos($status, 'finish') !== false) {
                                                $bg_color = 'text-bg-success';
                                            } elseif (strpos($status, 'cancel') !== false || strpos($status, 'fail') !== false) {
                                                $bg_color = 'text-bg-danger';
                                            } else {
                                                $bg_color = 'text-bg-warning';
                                            }
                                        ?>
                                            <tr>
                                                <th scope="row"><a href="<?= base_url('admin/transaction/detail/') . $rs['id']; ?>"><?= $rs['id']; ?></a></th>
                                                <td><?= $rs['fullname']; ?></td>
                                                <td><?= $rs['payment_method']; ?></td>
                                                <td><?= strtoupper($rs['courier']) . ' - ' . $rs['courier_service']; ?></td>
                                                <td><?= number_to_currency($rs['total_price'], 'IDR', 'id_ID'); ?></td>
                                                <td><span class="badge <?= $bg_color; ?>"><?= $rs['status']; ?></span></td>
                                            </tr>
                                        <?php endforeach ?>
                                    </tbody>
                                </table>

                            </div>

                        </div>
                    </div><!-- End Recent Sales -->

                    <!-- Top Selling -->
                    <div class="col-12">
                        <div class="card top-selling overflow-auto">

                            <div class="card-body pb-0">
                                <h5 class="card-title">Top Selling</h5>

                                <table class="table table-borderless">
                                    <thead>
                                        <tr>
                                            <th scope="col">Preview</th>
                                            <th scope="col">Menus</th>
                                            <th scope="col">Price</th>
                                            <th scope="col">Sold</th>
                                            <th scope="col">Revenue</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($topMenus as $tm): ?>
                                            <tr>
                                                <th scope="row"><img src="<?= base_url('assets/img/menu/') . $tm['menu_image']; ?>" alt="Menu Image"></th>
                                                <td><a href="<?= base_url('shop/') . $tm['slug']; ?>" class="text-primary fw-bold"><?= $tm['menu_name']; ?></a></td>
                                                <td><?= number_to_currency($tm['menu_price'], 'IDR', 'id_ID'); ?></td>
                                                <td class="fw-bold"><?= $tm['total_sold']; ?></td>
                                                <td><?= number_to_currency(($tm['menu_price'] * $tm['total_sold']), 'IDR', 'id_ID'); ?></td>
                                            </tr>
                                        <?php endforeach ?>
                                    </tbody>
                                </table>

                            </div>

                        </div>
                    </div><!-- End Top Selling -->

                </div>
            </div><!-- End Left side columns -->

        </div>
    </section>

</main><!-- End #main -->

<?= $this->endSection(); ?>
