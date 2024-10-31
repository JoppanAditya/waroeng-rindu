<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>
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
                                    <?php if ($a['is_selected'] == 1) : ?>
                                        <form method="post">
                                            <input type="hidden" id="user_id" value="<?= $a['user_id'] ?>">
                                            <input type="hidden" id="address_id" value="<?= $a['id'] ?>">
                                        </form>
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
                                            <?= $a['city_name'] . ', ' . $a['province_name'] . ', ' . $a['phone']; ?>
                                        </p>
                                        <button type="button" class="btn btn-outline-secondary dataButton">Change Address</button>
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
                                    <form method="post">
                                        <input type="hidden" name="items[<?= $index ?>][id]" value="<?= $c['id'] ?>">
                                        <input type="hidden" name="items[<?= $index ?>][price]" value="<?= $c['price'] ?>">
                                        <input type="hidden" name="items[<?= $index ?>][quantity]" value="<?= $c['quantity'] ?>">
                                        <input type="hidden" name="items[<?= $index ?>][name]" value="<?= $c['name'] ?>">
                                    </form>
                                    <li class="list-group-item border-0 rounded-4">
                                        <div class="dropdown-item d-flex justify-content-between text-reset text-decoration-none">
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

                                <select class="form-select my-2" aria-label="Delivery select" id="deliverySelect">
                                    <option selected disabled>Select Delivery</option>
                                    <option value="50000">Instant 3 hours</option>
                                    <option value="30000">Same Day 8 hours</option>
                                    <option value="20500">Next Day</option>
                                    <option value="11500">Regular</option>
                                </select>

                                <select class="form-select mt-2" aria-label="Payment select" id="paymentSelect">
                                    <option selected disabled>Select Payment Method</option>
                                    <option value="1">COD</option>
                                    <option value="2">E-Wallet</option>
                                    <option value="3">Bank Transfer</option>
                                    <option value="4">Credit or Debit Card</option>
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
                        <div class="d-flex justify-content-between">
                            <p class="card-text text-muted mb-0">Payment Method</p>
                            <p class="mb-0" id="paymentMethod">-</p>
                        </div>
                        <hr>
                        <div class="d-flex justify-content-between">
                            <p class="card-text mb-0">Shopping Total</p>
                            <p class="fw-semibold mb-0" id="shoppingTotal">-</p>
                        </div>
                        <hr>

                        <form id="transactionForm" enctype="multipart/form-data" method="post">
                            <input type="hidden" name="serviceFee" id="serviceFeeInput" value="<?= $serviceFee ?>">
                            <input type="hidden" name="deliveryFee" id="deliveryFeeInput">
                            <input type="hidden" name="shoppingTotal" id="shoppingTotalInput">
                            <input type="hidden" name="paymentMethod" id="paymentMethodInput">
                            <button type="submit" class="btn btn-primary w-100 py-2" id="pay-button">Pay</button>
                        </form>
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
                    $('.addButton').html('Add Menu');
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

        $('#pay-button').attr('disabled', 'disabled');

        const checkButtonState = () => {
            const deliverySelected = $('#deliverySelect').val();
            const paymentSelected = $('#paymentSelect').val();
            const address = JSON.parse('<?= json_encode($address) ?>');

            const addressSelected = address.some(a => a.is_selected == 1);

            if (deliverySelected && paymentSelected && addressSelected) {
                $('#pay-button').removeAttr('disabled');
            } else {
                $('#pay-button').attr('disabled', 'disabled');
            }
        }


        $('#deliverySelect').change((e) => {
            const selectedValue = parseInt(e.target.value);
            const deliveryFee = selectedValue;
            const totalPrice = <?= $totalPrice ?>;
            const serviceFee = <?= $serviceFee ?>;
            const shoppingTotal = totalPrice + deliveryFee + serviceFee;

            $('#deliveryFee').text('Rp' + deliveryFee.toLocaleString('id-ID'));
            $('#serviceFee').text('Rp' + serviceFee.toLocaleString('id-ID'));
            $('#shoppingTotal').text('Rp' + shoppingTotal.toLocaleString('id-ID'));
            $('#deliveryFeeInput').val(deliveryFee);
            $('#shoppingTotalInput').val(shoppingTotal);

            checkButtonState();
        });

        $('#paymentSelect').change((e) => {
            const selectedValue = parseInt(e.target.value);
            let paymentMethod = '';
            if (selectedValue == 1) {
                paymentMethod = 'COD';
            } else if (selectedValue == 2) {
                paymentMethod = 'E-Wallet';
            } else if (selectedValue == 3) {
                paymentMethod = 'Bank Transfer';
            } else if (selectedValue == 4) {
                paymentMethod = 'Credit or Debit Card';
            }

            $('#paymentMethod').text(paymentMethod);
            $('#paymentMethodInput').val(paymentMethod);

            checkButtonState();
        });

        $('#pay-button').click((e) => {
            e.preventDefault();
            const deliveryFee = $('#deliveryFeeInput').val();
            const serviceFee = $('#serviceFeeInput').val();
            const shoppingTotal = $('#shoppingTotalInput').val();
            const user_id = $('#user_id').val();
            const address_id = $('#address_id').val();
            const paymentMethod = $('#paymentMethodInput').val();

            const items = [];
            $('input[name^="items"]').each(function() {
                const name = $(this).attr('name');
                const value = $(this).val();
                const nameParts = name.match(/items\[(\d+)\]\[(\w+)\]/);
                const index = nameParts[1];
                const key = nameParts[2];

                if (!items[index]) {
                    items[index] = {};
                }
                items[index][key] = value;
            });

            $.ajax({
                method: 'POST',
                dataType: 'json',
                url: '<?= base_url('cart/payment') ?>',
                data: {
                    deliveryFee: deliveryFee,
                    serviceFee: serviceFee,
                    shoppingTotal: shoppingTotal,
                    user_id: user_id,
                    address_id: address_id,
                    paymentMethod: paymentMethod,
                    items: items
                },
                success: (response) => {
                    if (response.status === "success") {
                        window.location.href = '<?= base_url('shop') ?>';
                    } else {
                        window.location.href = '<?= base_url('cart') ?>';
                    }
                },
                error: (xhr, status, error) => {
                    console.error(xhr.responseText);
                    window.location.href = '<?= base_url('cart') ?>';
                }
            });
        });

        // Handle Add
        $('#save-add').click((e) => {
            e.preventDefault();

            const user_id = $('#add_user_id').val();
            const name = $('#add_user_name').val();
            const phone = $('#add_user_phone').val();
            const label = $('#add_address_label').val();
            const city = $('#add_address_city').val();
            const full_address = $('#add_address_full').val();
            const notes = $('#add_address_notes').val();

            $.ajax({
                method: 'POST',
                dataType: 'json',
                url: '<?= base_url('settings/saveAddress') ?>',
                data: {
                    user_id: user_id,
                    name: name,
                    phone: phone,
                    label: label,
                    city: city,
                    full_address: full_address,
                    notes: notes
                },
                success: (response) => {
                    if (response.error) {
                        if (response.errors) {
                            for (let field in response.errors) {
                                if (response.errors.hasOwnProperty(field)) {
                                    const errorElement = $(`#add-${field}-error`);
                                    if (errorElement.length) {
                                        errorElement.text(response.errors[field]);
                                    } else {
                                        console.error(`No element found for ${field}-error`);
                                    }
                                }
                            }
                        }
                    } else {
                        location.reload();
                    }
                },
                error: (xhr, status, error) => {
                    console.error(xhr.responseText);
                }
            });
        });

        // Handle Update
        $('#updateModal').on('show.bs.modal', (e) => {
            const button = $(e.relatedTarget);
            const id = button.data('id');

            // Reset form values
            $('#update_address_id').val();
            $('#update_user_id').val();
            $('#update_user_name').val();
            $('#update_user_phone').val();
            $('#update_address_label').val();
            $('#update_address_city').val();
            $('#update_address_full').val();
            $('#update_address_notes').val();

            $.ajax({
                url: '<?= base_url('settings/getAddressDetail/') ?>' + id,
                method: 'GET',
                dataType: 'json',
                success: (data) => {
                    if (data) {
                        $('#update_address_id').val(data[0].id);
                        $('#update_user_id').val(data[0].user_id);
                        $('#update_user_name').val(data[0].name);
                        $('#update_user_phone').val(data[0].phone);
                        $('#update_address_label').val(data[0].label);
                        $('#update_address_city').val(data[0].city);
                        $('#update_address_full').val(data[0].full_address);
                        $('#update_address_notes').val(data[0].notes);
                    } else {
                        console.error('No data received');
                    }
                },
                error: (xhr, status, error) => {
                    console.error('Error fetching address details:', error);
                }
            });
        });

        // Handle Save Changes
        $('#save-changes').click((e) => {
            e.preventDefault();

            const id = $('#update_address_id').val();
            const user_id = $('#update_user_id').val();
            const name = $('#update_user_name').val();
            const phone = $('#update_user_phone').val();
            const label = $('#update_address_label').val();
            const city = $('#update_address_city').val();
            const full_address = $('#update_address_full').val();
            const notes = $('#update_address_notes').val();

            $.ajax({
                type: 'POST',
                url: '<?= base_url('settings/saveAddress/') ?>' + id,
                data: {
                    user_id: user_id,
                    name: name,
                    phone: phone,
                    label: label,
                    city: city,
                    full_address: full_address,
                    notes: notes
                },
                success: (response) => {
                    if (response.error) {
                        if (response.errors) {
                            for (let field in response.errors) {
                                if (response.errors.hasOwnProperty(field)) {
                                    const errorElement = $(`#update-${field}-error`);
                                    if (errorElement.length) {
                                        errorElement.text(response.errors[field]);
                                    } else {
                                        console.error(`No element found for ${field}-error`);
                                    }
                                }
                            }
                        }
                    } else {
                        location.reload();
                    }
                },
                error: (xhr, status, error) => {
                    console.error(xhr.responseText);
                }
            });
        });

        // Handle Select
        $('.select-button').click((e) => {
            const button = $(e.target);
            const cardBody = button.closest('.card-body');
            const id = cardBody.find('.address-id').val();
            const userId = cardBody.find('.user-id').val();

            console.log('ID:', id);
            console.log('User ID:', userId);

            if (typeof id === 'undefined' || typeof userId === 'undefined') {
                console.error('ID or user ID is undefined.');
                return;
            }

            $.ajax({
                url: '<?= base_url('settings/updateSelect/') ?>' + id,
                method: 'POST',
                data: {
                    user_id: userId
                },
                success: (response) => {
                    if (response.success) {
                        location.reload();
                    }
                },
                error: (xhr, status, error) => {
                    console.error('Error updating selection:', error);
                }
            });
        });

        // Handle Primary Select
        $('.primary-button').click((e) => {
            const button = $(e.target);
            const cardBody = button.closest('.card-body');
            const id = cardBody.find('.address-id').val();
            const userId = cardBody.find('.user-id').val();

            console.log('ID:', id);
            console.log('User ID:', userId);

            if (typeof id === 'undefined' || typeof userId === 'undefined') {
                console.error('ID or user ID is undefined.');
                return;
            }

            $.ajax({
                url: '<?= base_url('settings/updatePrimarySelect/') ?>' + id,
                method: 'POST',
                data: {
                    user_id: userId
                },
                success: (response) => {
                    if (response.success) {
                        location.reload();
                    }
                },
                error: (xhr, status, error) => {
                    console.error('Error updating selection:', error);
                }
            });
        });

        // Handle Delete
        $('#deleteModal').on('show.bs.modal', (e) => {
            const button = $(e.relatedTarget);
            const id = button.data('id');

            $('#deleteButton').off('click').on('click', () => {
                location.reload();
            });
        });
    });
</script>

<?= $this->endSection(); ?>
