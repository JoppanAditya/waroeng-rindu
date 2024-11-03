<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>
<script type="text/javascript"
    src="https://app.sandbox.midtrans.com/snap/snap.js"
    data-client-key="<?= getenv('MIDTRANS_CLIENT_KEY'); ?>"></script>

<!-- Navbar Start -->
<nav class="navbar navbar-expand-lg bg-body-tertiary">
    <div class="container">
        <a class="navbar-brand m-0" style="cursor: pointer;" data-bs-toggle="modal" data-bs-target="#ConfirmModal">
            <img src="<?= base_url('assets/img/logo.svg') ?>" alt="Waroeng Rindu Logo" height="120" />
        </a>
    </div>
</nav>
<!-- Navbar End -->

<main>
    <div id="snap-container"></div>
    <div class="container my-4">
        <div class="row">
            <h2 class="mb-4">Delivery</h2>
            <div class="col-sm-8">
                <section class="mb-4">
                    <div class="card mb-3">
                        <div class="card-body">
                            <h4 class="fs-5 text-secondary">Delivery Address</h4>
                            <?php if (!empty($address)) : ?>
                                <?php foreach ($address as $a) : ?>
                                    <input type="hidden" id="destination" value="<?= $a['city']; ?>">
                                    <input type="hidden" id="user_id" value="<?= $a['user_id']; ?>">
                                    <input type="hidden" id="address_id" value="<?= $a['id']; ?>">
                                    <?php if ($a['is_selected'] == 1) : ?>
                                        <div class="d-flex gap-2 align-items-center mb-2">
                                            <i class="fas fa-map-marker-alt" style="color: #3468c0;"></i>
                                            <p class="mb-0 fw-medium">
                                                <?= $a['label']; ?>
                                                &VerticalLine;
                                                <?= $a['name']; ?>
                                            </p>
                                        </div>
                                        <p>
                                            <?= $a['full_address']; ?>
                                            <?= $a['notes'] ? ' (' . $a['notes'] . '), ' : ''; ?>
                                            <?= $a['city_name'] . ', ' . $a['province_name'] . ' ' . $a['postal_code'] . ', ' . $a['phone']; ?>
                                        </p>
                                        <button type="button" class="btn btn-outline-secondary btn-sm dataButton">Change Address</button>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            <?php else : ?>
                                <!-- Add Button trigger modal -->
                                <button type="button" class="btn btn-secondary mt-2 addButton">
                                    <i class="fas fa-plus me-1"></i>
                                    Add New Address
                                </button>
                            <?php endif; ?>

                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <ul class="list-group list-group-flush my-3">
                                <?php $totalPrice = 0;
                                $deliveryFee = 0;
                                $serviceFee = 1000;
                                $shoppingTotal = 0;
                                foreach (session('cart') as $index => $c) : ?>
                                    <?php $totalWeight = 0;
                                    $weight = $c['weight'] * $c['quantity'];
                                    $totalWeight += $weight; ?>
                                    <input type="hidden" id="weight" value="<?= $totalWeight; ?>">
                                    <input type="hidden" name="items[<?= $index ?>][id]" value="<?= $c['id'] ?>">
                                    <input type="hidden" name="items[<?= $index ?>][price]" value="<?= $c['price'] ?>">
                                    <input type="hidden" name="items[<?= $index ?>][quantity]" value="<?= $c['quantity'] ?>">
                                    <input type="hidden" name="items[<?= $index ?>][name]" value="<?= $c['name'] ?>">
                                    <input type="hidden" name="items[<?= $index ?>][notes]" value="<?= $c['notes'] ?>">

                                    <li class="list-group-item border-0 rounded-4 p-0">
                                        <div class="dropdown-item d-flex justify-content-between text-reset text-decoration-none p-0">
                                            <div class="d-flex align-items-start gap-3">
                                                <div>
                                                    <img src="<?= base_url('assets/img/menu/') . $c['image'] ?>" alt="Menu Image" class="rounded" width="75" height="75">
                                                </div>
                                                <div class="d-flex flex-column">
                                                    <p class="text-wrap text-decoration-none fw-bold" style="max-width: 250px;"><?= $c['name'] ?></p>
                                                    <span class="text-muted">Notes: <?= $c['notes']; ?></span>
                                                </div>
                                            </div>
                                            <p class="fw-semibold"><span><?= $c['quantity'] ?></span> &times; <?= number_to_currency($c['price'], 'IDR', 'id-ID'); ?></p>
                                        </div>
                                    </li>
                                    <hr>
                                    <?php $totalPrice += $c['subtotal'] ?>
                                <?php endforeach; ?>

                                <select class="form-select my-2" aria-label="Courier select" id="courierSelect">
                                    <option selected disabled>Select Courier</option>
                                    <option value="jne">JNE</option>
                                    <option value="pos">POS</option>
                                    <option value="tiki">TIKI</option>
                                </select>

                                <select class="form-select mt-2" aria-label="Sercive select" id="serviceSelect">
                                    <option selected disabled>Select Service</option>
                                </select>
                            </ul>
                        </div>
                    </div>
                </section>
            </div>
            <div class="col-sm-4">
                <div class="card my-card position-sticky" style="top: 2rem;">
                    <div class="card-body">
                        <h5>Shopping summary</h5>
                        <div class="d-flex justify-content-between mb-1">
                            <p class="card-text text-muted mb-0">Total Price</p>
                            <p class="mb-0"><?= number_to_currency($totalPrice, 'IDR', 'id-ID'); ?></p>
                        </div>
                        <div class="d-flex justify-content-between mb-1">
                            <p class="card-text text-muted mb-0">Total Delivery Fee</p>
                            <p class="mb-0" id="deliveryFee">-</p>
                        </div>
                        <div class="d-flex justify-content-between mb-1">
                            <p class="card-text text-muted mb-0">App Services Fee</p>
                            <p class="mb-0" id="serviceFee">-</p>
                        </div>
                        <hr>
                        <div class="d-flex justify-content-between">
                            <p class="card-text mb-0">Shopping Total</p>
                            <p class="fw-semibold mb-0" id="shoppingTotal">-</p>
                        </div>
                        <hr>

                        <input type="hidden" name="courier">
                        <input type="hidden" name="courierService">
                        <input type="hidden" name="deliveryFee">
                        <input type="hidden" name="shoppingTotal">
                        <button type="button" class="btn btn-primary w-100 py-2" id="pay-button">Select Payment</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<!-- Confirmation Modal -->
<div class="modal fade" id="ConfirmModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="ConfirmModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md">
        <div class="modal-content">
            <div class="modal-body text-center p-4">
                <h4 class="fw-semibold">Back To Cart?</h4>
                <p style="font-size: 14px;">Discard all changes and return to cart?</p>
                <button type="button" class="btn btn-primary w-100" data-bs-dismiss="modal">Stay On This Page</button>
                <a type="button" class="btn btn-link text-decoration-none mt-2" href="<?= base_url('cart') ?>">Back and Discard Changes</a>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="viewModal"></div>

<!-- Copyright -->
<div class="text-center py-3 bg-body-tertiary mt-auto">
    &copy; <?= date("Y"); ?> Waroeng Rindu. All rights reserved.
</div>
<!-- Copyright -->
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

    function addressData() {
        $.ajax({
            url: '<?= base_url('admin/menu/get') ?>',
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
        $('#pay-button').attr('disabled', 'disabled');
        $('#serviceSelect').attr('disabled', 'disabled');

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

        $('.dataButton').click(function(e) {
            e.preventDefault();

            $.ajax({
                url: '<?= base_url('address/dataModal') ?>',
                dataType: 'json',
                beforeSend: function() {
                    $('.dataButton').attr('disabled', 'disabled');
                    $('.dataButton').html('<span class="spinner-border spinner-border-sm me-1" aria-hidden="true"></span><span role="status">Loading...</span>');
                },
                complete: function() {
                    $('.dataButton').removeAttr('disabled', 'disabled');
                    $('.dataButton').html('Change Address');
                },
                success: function(response) {
                    $('.viewModal').html(response.data).show();
                    $('#addressModal').modal('show');
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    console.error(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                }
            });
        });

        const checkButtonState = () => {
            const courierSelected = $('#courierSelect').val();
            const serviceSelected = $('#serviceSelect').val();
            const address = JSON.parse('<?= json_encode($address) ?>');
            const addressSelected = address.some(a => a.is_selected == 1);

            if (courierSelected && serviceSelected && addressSelected) {
                $('#pay-button').removeAttr('disabled');
            } else {
                $('#pay-button').attr('disabled', 'disabled');
            }
        }

        $('#courierSelect').change(function() {
            const courier = $(this).val();
            $('input[name=courier]').val(courier);
            const destination = $('#destination').val();
            const weight = $('#weight').val();

            $.ajax({
                url: '<?= base_url('shipment/cost') ?>',
                type: 'POST',
                data: {
                    destination,
                    weight,
                    courier
                },
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        $('#serviceSelect').removeAttr('disabled', 'disabled');
                        $('#serviceSelect').empty().append('<option selected disabled>Select Service</option>');
                        response.services.forEach(service => {
                            const etdValue = service.cost[0].etd;
                            const match = etdValue.match(/(\d+)(?:-(\d+))?/);
                            let estimatedDelivery;
                            if (match) {
                                const startEtd = parseInt(match[1]);
                                const endEtd = match[2] ? parseInt(match[2]) : startEtd;

                                if (startEtd === 0 || startEtd === 1) {
                                    estimatedDelivery = "(arrives today)";
                                } else if (startEtd === endEtd) {
                                    estimatedDelivery = `(estimated ${startEtd} day)`;
                                } else {
                                    estimatedDelivery = `(estimated ${startEtd}-${endEtd} days)`;
                                }
                            } else {
                                estimatedDelivery = "";
                            }

                            $('#serviceSelect').append(
                                `<option value="${service.cost[0].value}" data-service="${service.service}">${service.service} - ${service.description} ${estimatedDelivery}</option>`
                            );
                        });
                    } else {
                        $('#serviceSelect').empty().append('<option disabled>No services available</option>');
                        Toast.fire({
                            icon: 'error',
                            title: 'No shipment services available.'
                        });
                    }
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    console.error(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                }
            });
        });

        $('#serviceSelect').change(function(e) {
            const deliveryFee = parseInt($(this).val());
            const totalPrice = <?= $totalPrice ?>;
            const serviceFee = <?= $serviceFee ?>;
            const shoppingTotal = totalPrice + deliveryFee + serviceFee;
            $('input[name=courierService]').val($(this).find(":selected").data('service'));

            $('#deliveryFee').text('Rp' + deliveryFee.toLocaleString('id-ID'));
            $('#serviceFee').text('Rp' + serviceFee.toLocaleString('id-ID'));
            $('#shoppingTotal').text('Rp' + shoppingTotal.toLocaleString('id-ID'));
            $('input[name=deliveryFee]').val(deliveryFee);
            $('input[name=shoppingTotal]').val(shoppingTotal);

            checkButtonState();
        });

        $('#pay-button').click(function(e) {
            e.preventDefault();
            const userId = $('#user_id').val();
            const addressId = $('#address_id').val();
            const courier = $('input[name=courier]').val();
            const courierService = $('input[name=courierService]').val();
            const deliveryFee = $('input[name=deliveryFee]').val();
            const shoppingTotal = $('input[name=shoppingTotal]').val();

            const items = [];
            $('input[name^="items"]').each(function() {
                const name = $(this).attr('name');
                const value = $(this).val();
                const nameParts = name.match(/items\[(\d+)\]\[(\w+)\]/);

                if (nameParts) {
                    const index = nameParts[1];
                    const key = nameParts[2];

                    if (!items[index]) {
                        items[index] = {};
                    }
                    items[index][key] = value;
                }
            });

            $.ajax({
                url: '<?= base_url('transaction/payment') ?>',
                method: 'POST',
                dataType: 'json',
                data: {
                    courier: courier,
                    courierService: courierService,
                    deliveryFee: deliveryFee,
                    shoppingTotal: shoppingTotal,
                    userId: userId,
                    addressId: addressId,
                    items: items
                },
                beforeSend: function() {
                    $('.pay-button').attr('disabled', 'disabled');
                    $('.pay-button').html('<span class="spinner-border spinner-border-sm me-1" aria-hidden="true"></span><span role="status">Loading...</span>');
                },
                success: (response) => {
                    if (response.success) {
                        window.snap.pay(response.snapToken, {
                            onSuccess: function(result) {
                                $.ajax({
                                    url: '<?= base_url('transaction/save') ?>',
                                    type: 'POST',
                                    data: {
                                        transactionId: result.order_id,
                                        paymentType: result.payment_type,
                                        transactionStatus: result.transaction_status,
                                        transactionData: response.transactionData,
                                        transactionItems: response.transactionItems
                                    },
                                    dataType: 'json',
                                    success: function(response) {
                                        if (response.success) {
                                            Swal.fire({
                                                icon: 'success',
                                                title: 'Payment Success',
                                                text: 'Your payment has been confirmed successfully and your order has been placed',
                                            }).then((result) => {
                                                window.location.href = '<?= base_url('order-list') ?>'
                                            });
                                        } else {
                                            Toast.fire({
                                                icon: "error",
                                                title: response.error
                                            }).then((result) => {
                                                window.location.href = '<?= base_url('cart') ?>'
                                            });
                                        }
                                    }
                                });
                            },
                            onPending: function(result) {
                                $.ajax({
                                    url: '<?= base_url('transaction/save') ?>',
                                    type: 'POST',
                                    data: {
                                        transactionId: result.order_id,
                                        paymentType: result.payment_type,
                                        transactionStatus: result.transaction_status,
                                        transactionData: response.transactionData,
                                        transactionItems: response.transactionItems
                                    },
                                    dataType: 'json',
                                    success: function(response) {
                                        if (response.success) {
                                            window.location.href = '<?= base_url('order-list') ?>'
                                        } else {
                                            Toast.fire({
                                                icon: "error",
                                                title: response.error
                                            }).then((result) => {
                                                window.location.href = '<?= base_url('cart') ?>'
                                            });
                                        }
                                    }
                                });
                            },
                            onError: function(result) {
                                $.ajax({
                                    url: '<?= base_url('transaction/save') ?>',
                                    type: 'POST',
                                    data: {
                                        transactionId: result.order_id,
                                        paymentType: result.payment_type,
                                        transactionStatus: result.transaction_status,
                                        transactionData: response.transactionData,
                                        transactionItems: response.transactionItems
                                    },
                                    dataType: 'json',
                                    success: function(response) {
                                        if (response.success) {
                                            window.location.href = '<?= base_url('order-list') ?>'
                                        } else {
                                            Toast.fire({
                                                icon: 'error',
                                                title: 'Payment Error',
                                                text: response.error
                                            }).then(() => {
                                                window.location.href = '<?= base_url('cart') ?>'
                                            });
                                        }
                                    }
                                });
                            },
                            onClose: function() {
                                Swal.fire({
                                    title: "Warning",
                                    text: "You closed the popup without finishing the payment",
                                    icon: "warning"
                                }).then((result) => {
                                    window.location.href = '<?= base_url('order-list') ?>';
                                });
                            }
                        });
                    } else {
                        Toast.fire({
                            icon: "error",
                            title: response.error,
                            text: 'Your payment has failed due to some technical error. Please try again'
                        }).then(() => {
                            location.reload();
                        });
                    }
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    console.error(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                }
            });
        });
    });
</script>

<?= $this->endSection(); ?>
