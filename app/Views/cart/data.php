<?php if (!empty($cart)): ?>
    <div class="container py-5">
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">Products</th>
                        <th scope="col">Name</th>
                        <th scope="col">Price</th>
                        <th scope="col">Quantity</th>
                        <th scope="col">Total</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $total = 0 ?>
                    <?php foreach ($cart as $c): ?>
                        <tr>
                            <th scope="row">
                                <div class="d-flex align-items-center">
                                    <img src="<?= base_url('assets/img/menu/') . $c['image']; ?>" class="img-fluid me-5 rounded-circle" style="width: 80px; height: 80px; object-fit: cover;" alt="<?= $c['name']; ?> image">
                                </div>

                            </th>
                            <td>
                                <p class="mb-0 mt-4 fw-bold"><?= $c['name']; ?></p>
                                <input class="form-control mt-1 w-auto"
                                    placeholder="Add a note..."
                                    id="note-input-<?= $c['id']; ?>"
                                    oninput="updateCart(<?= $c['id']; ?>)"
                                    value="<?= isset($c['notes']) ? $c['notes'] : ''; ?>">
                                </input>
                            </td>
                            <td>
                                <p class="mb-0 mt-4"><?= number_to_currency($c['price'], 'IDR', 'id_ID'); ?></p>
                            </td>
                            <td>
                                <div class="input-group mt-4" style="width: 100px;">
                                    <div class="input-group-btn">
                                        <button class="btn btn-sm btn-minus rounded-circle bg-light border" type="button" onclick="updateCart(<?= $c['id'] ?>, 'decrement')">
                                            <i class="fa fa-minus"></i>
                                        </button>
                                    </div>
                                    <input type="text" class="form-control form-control-sm text-center border-0" id="inputValue-<?= $c['id'] ?>" value="<?= $c['quantity']; ?>" name="quantity" oninput="updateCart(<?= $c['id'] ?>)">
                                    <div class="input-group-btn">
                                        <button class="btn btn-sm btn-plus rounded-circle bg-light border" type="button" onclick="updateCart(<?= $c['id'] ?>, 'increment')">
                                            <i class="fa fa-plus"></i>
                                        </button>
                                    </div>
                                </div>
                            </td>
                            <td data-price="<?= $c['price']; ?>">
                                <p class="mb-0 mt-4 fw-bold subtotal" id="subtotal-<?= $c['id']; ?>" data-subtotal="<?= $c['subtotal']; ?>"><?= number_to_currency($c['subtotal'], 'IDR', 'id_ID'); ?></p>
                            </td>
                            <td>
                                <button onclick="remove(<?= $c['id'] ?>)" class="btn btn-md rounded-circle bg-light border mt-4">
                                    <i class="fa fa-times text-danger"></i>
                                </button>
                            </td>
                        </tr>
                        <?php $total += $c['subtotal'] ?>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <div class="d-flex justify-content-between mt-5">
            <div class="w-75">
                <input type="text" class="border-0 border-bottom rounded me-5 py-3 mb-4" placeholder="Coupon Code">
                <button class="btn border-secondary rounded-pill px-4 py-3 text-primary" type="button">Apply Coupon</button>
            </div>
            <div class="row g-4 justify-content-end" style="width: 200rem;">
                <div class="col-8"></div>
                <div class="col-sm-8 col-md-7 col-lg-6 col-xl-4">
                    <div class="bg-light rounded">
                        <div class="p-4">
                            <h1 class="display-6">Cart <span class="fw-normal">Total</span></h1>
                        </div>
                        <div class="pb-4 mb-4 border-bottom d-flex justify-content-between">
                            <h5 class="mb-0 ps-4 me-4">Total</h5>
                            <p class="mb-0 pe-4" id="total"><?= number_to_currency($total ?: 0, 'IDR', 'id_ID'); ?></p>
                        </div>
                        <a href="<?= base_url('transaction/address'); ?>" class="btn border-secondary rounded-pill px-4 py-3 text-primary text-uppercase mb-4 ms-4" type="button">Proceed Checkout</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php else: ?>
    <div class="d-block d-lg-flex text-center text-lg-start justify-content-center align-items-center gap-4 p-4">
        <img src="<?= base_url('assets/') ?>img/empty-cart.png" alt="empty cart" width="350" height="350">
        <div>
            <h4 class="my-3">Your cart is empty</h4>
            <p class="my-3">Want something? Add it to your cart now!</p>
            <a href="<?= base_url('shop') ?>" class="btn btn-primary px-5 py-2">Shop Now</a>
        </div>
    </div>
<?php endif; ?>

<script>
    function remove(id) {
        $.ajax({
            url: '<?= base_url('cart/remove') ?>',
            type: 'POST',
            data: {
                id: id,
            },
            success: function(response) {
                if (response.success) {
                    Toast.fire({
                        icon: "success",
                        title: response.success
                    });
                    cartData();
                } else {
                    Toast.fire({
                        icon: "error",
                        title: response.error
                    });
                }
            },
            error: function(xhr, status, error) {
                console.error("Failed to remove item:", error);
            }
        });
    }

    // function updateCart(id, action = null) {
    //     let inputQuantity = $('#inputValue-' + id);
    //     let quantity = parseInt(inputQuantity.val());
    //     let noteInput = $('#note-input-' + id).val();
    //     let rowId = $('#rowId-' + id).val();
    //     let price = parseFloat($('#subtotal-' + id).closest('tr').find('td[data-price]').data('price'));

    //     if (action === 'increment' && quantity < 5) {
    //         quantity += 1;
    //     } else if (action === 'decrement' && quantity > 1) {
    //         quantity -= 1;
    //     }

    //     $.ajax({
    //         url: '<?= base_url('cart/update') ?>',
    //         type: 'POST',
    //         data: {
    //             id: id,
    //             quantity: quantity,
    //             notes: noteInput
    //         },
    //         success: (response) => {
    //             if (response.success) {
    //                 inputQuantity.val(quantity);

    //                 if (noteInput !== null) {
    //                     $('#note-text-' + id).text(noteInput);
    //                 }

    //                 let subtotal = quantity * price;
    //                 $('#subtotal-' + id).text(new Intl.NumberFormat('id-ID', {
    //                     style: 'currency',
    //                     currency: 'IDR',
    //                     minimumFractionDigits: 0,
    //                 }).format(subtotal));
    //                 $('#subtotal-' + id).data('subtotal', subtotal);

    //                 let total = 0;
    //                 $('.subtotal').each(function() {
    //                     total += parseFloat($(this).data('subtotal'));
    //                 });
    //                 $('#total').text(new Intl.NumberFormat('id-ID', {
    //                     style: 'currency',
    //                     currency: 'IDR',
    //                     minimumFractionDigits: 0,
    //                 }).format(total));
    //             } else {
    //                 Toast.fire({
    //                     icon: "error",
    //                     title: response.error
    //                 });
    //             }
    //         },
    //         error: (xhr, status, error) => {
    //             console.error(xhr.responseText);
    //         }
    //     });
    // };
</script>
