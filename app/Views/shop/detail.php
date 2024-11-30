<?= $this->extend('layout/template') ?>

<?= $this->section('content') ?>
<!-- Single Page Header start -->
<div class="container-fluid page-header py-5">
    <h1 class="text-center text-white display-6">Shop Detail</h1>
    <ol class="breadcrumb justify-content-center mb-0">
        <li class="breadcrumb-item"><a href="<?= base_url(); ?>">Home</a></li>
        <li class="breadcrumb-item"><a href="<?= base_url('shop'); ?>">Shop</a></li>
        <li class="breadcrumb-item"><a href="<?= base_url('shop?mc=') . $menu['category_id']; ?>"><?= $menu['category_name']; ?></a></li>
        <li class="breadcrumb-item active text-white"><?= $menu['name']; ?></li>
    </ol>
</div>
<!-- Single Page Header End -->


<!-- Single Product Start -->
<div class="container-fluid py-5 mt-5">
    <div class="container py-5">
        <div class="row g-4 mb-5">
            <div class="col-lg-8 col-xl-9">
                <div class="row g-4">
                    <div class="col-lg-6">
                        <div class="border rounded">
                            <a href="<?= base_url('assets/img/menu/') . $menu['image']; ?>" data-lightbox="<?= $menu['name'] . ' image'; ?>" data-title="<?= $menu['name']; ?>">
                                <img src="<?= base_url('assets/img/menu/') . $menu['image']; ?>" class="img-fluid rounded" alt="<?= $menu['name'] . ' image'; ?>">
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <h4 class="fw-bold mb-3"><?= $menu['name']; ?></h4>
                        <p class="mb-3">Category: <?= $menu['category_name']; ?></p>
                        <h5 class="fw-bold mb-3"><?= number_to_currency($menu['price'], 'IDR', 'id_ID'); ?></h5>
                        <div class="d-flex mb-4">
                            <i class="fa fa-star text-secondary"></i>
                            <i class="fa fa-star text-secondary"></i>
                            <i class="fa fa-star text-secondary"></i>
                            <i class="fa fa-star text-secondary"></i>
                            <i class="fa fa-star"></i>
                        </div>
                        <p class="mb-4"><?= $menu['description']; ?></p>
                    </div>
                    <div class="col-lg-12">
                        <h4 class="my-4 fw-bold">User Reviews</h4>
                        <?php foreach ($comment as $c): ?>
                            <div class="d-flex w-100">
                                <img src="<?= base_url('assets/img/user/') . $c['image']; ?>" class="img-fluid rounded-circle p-3" style="width: 100px; height: 100px; margin-left: -1rem;" alt="profile picture">
                                <div class="w-100">
                                    <p class="mb-2" style="font-size: 14px;"><?= date('d M Y | H:i', strtotime($c['created_at'])); ?></p>
                                    <div class="d-flex justify-content-between">
                                        <h5><?= $c['fullname']; ?></h5>

                                        <div class="d-flex mb-3">
                                            <?php
                                            for ($i = 1; $i <= 4; $i++): ?>
                                                <i class="fa fa-star text-secondary"></i>
                                            <?php endfor; ?>

                                            <?php
                                            for ($i = ceil(4); $i < 5; $i++): ?>
                                                <i class="fa fa-star"></i>
                                            <?php endfor; ?>
                                        </div>
                                    </div>
                                    <p><?= $c['comment']; ?></p>
                                    <div class="d-flex justify-content-end">
                                        <a class="btn fs-6" data-bs-toggle="collapse" href="#collapseReply" role="button" aria-expanded="false" aria-controls="collapseReply">
                                            Show Reply <i class="ms-1 fa fa-chevron-down"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>

                            <!-- Reply -->
                            <?php if (isset($reply[$c['id']])): ?>
                                <div class="mt-2 p-3 pb-0 bg-light rounded-3 collapse" id="collapseReply">
                                    <?php foreach ($reply[$c['id']] as $r): ?>
                                        <div class="d-flex">
                                            <img src="<?= base_url('assets/img/user/') . $r['image']; ?>" class="img-fluid rounded-circle p-3" style="width: 75px; height: 75px;" alt="<?= $r['fullname'] . '\'s profile picture'; ?>">
                                            <div class="">
                                                <p class="mb-2" style="font-size: 12px;"><?= date('d M Y | H:i', strtotime($r['created_at'])); ?></p>
                                                <div class="d-flex justify-content-between">
                                                    <h6><?= $r['fullname']; ?></h6>
                                                </div>
                                                <p><?= $r['comment']; ?></p>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            <?php endif; ?>

                        <?php endforeach; ?>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 pb-4 d-none d-lg-block">
                <div class="card my-card position-sticky" style="top: 8rem;">
                    <div class="card-body">
                        <?= form_open('cart/add', ['class' => 'addCartForm']); ?>
                        <?= csrf_field(); ?>
                        <h5>Set amounts and notes</h5>
                        <div class="mt-4 mb-2">
                            <div class="d-flex align-items-center gap-4 mb-1">
                                <div class="input-group quantity mb-1" style="width: 100px;">
                                    <div class="input-group-btn">
                                        <button class="btn btn-sm btn-minus rounded-circle bg-light border" type="button">
                                            <i class="fa fa-minus"></i>
                                        </button>
                                    </div>
                                    <input type="text" class="form-control form-control-sm text-center border-0" value="1" id="quantity" name="quantity" oninput="updateSubtotal()">
                                    <div class="input-group-btn">
                                        <button class="btn btn-sm btn-plus rounded-circle bg-light border" type="button">
                                            <i class="fa fa-plus"></i>
                                        </button>
                                    </div>
                                </div>
                                <button class="btn btn-link text-decoration-none p-0 ms-auto" type="button" data-bs-toggle="collapse" data-bs-target="#notesCollapse" aria-expanded="false" aria-controls="notesCollapse"><i class="fas fa-pen me-2"></i>Add Note</button>
                            </div>
                            <small class="text-secondary">Max. purchase 5</small>
                        </div>

                        <div class="collapse" id="notesCollapse">
                            <div class="card card-body mt-1">
                                <input type="text" name="notes" placeholder="Ex. No chili, Less sugar" class="border-0" style="outline: unset;">
                            </div>
                        </div>

                        <div class="d-flex justify-content-between align-items-center my-4">
                            <p class="card-text m-0">Subtotal:</p>
                            <strong id="subtotal"><?= number_to_currency($menu['price'], 'IDR', 'id_ID'); ?></strong>
                        </div>
                        <?php if (!auth()->loggedIn()) : ?>
                            <a type="button" href="<?= base_url('login') ?>" class="btn btn-primary w-100 py-2"><i class="fas fa-cart-plus me-2"></i>Add To Cart</a>
                            <div class="d-flex justify-content-between align-items-center mt-2">
                                <a type="button" href="<?= base_url('login') ?>" class="btn border-0 fw-normal"><i class="fas fa-heart me-2"></i>Favorite</a>
                                &VerticalLine;
                                <button type="button" class="btn border-0 fw-normal"><i class="fas fa-share-alt me-2"></i>Share</button>
                            </div>
                        <?php else : ?>
                            <input type="hidden" name="type" value="Shopping">
                            <input type="hidden" id="menu_id" name="menu_id" value="<?= $menu['id'] ?>">
                            <input type="hidden" id="user_id" name="user_id" value="<?= user_id() ?>">
                            <input type="hidden" id="menu_name" name="menu_name" value="<?= $menu['name'] ?>">
                            <input type="hidden" id="price" name="price" value="<?= $menu['price'] ?>">
                            <button type="submit" class="btn btn-primary w-100 py-2 addButton"><i class="fas fa-cart-plus me-2"></i>Add To Cart</button>
                            <div class="d-flex justify-content-between align-items-center mt-2">
                                <button type="button" class="btn border-0 fw-normal addFavorite <?= $favorite ? 'text-danger' : ''; ?>">
                                    <i class="fas fa-heart me-2"></i>Favorite
                                </button>
                                &VerticalLine;
                                <button type="button" class="btn border-0 fw-normal"><i class="fas fa-share-alt me-2"></i>Share</button>
                            </div>
                        <?php endif; ?>
                        <?= form_close(); ?>
                    </div>
                </div>
            </div>

        </div>
        <h1 class="fw-bold mb-0">Related products</h1>
        <div class="vesitable">
            <div class="owl-carousel vegetable-carousel justify-content-center">
                <?php foreach ($related as $r): ?>
                    <div class="border border-primary rounded position-relative vesitable-item">
                        <div class="vesitable-img">
                            <img src="<?= base_url('assets/img/menu/') . $r['image']; ?>" class="img-fluid w-100 rounded-top" alt="Menu Image">
                        </div>
                        <div class="text-white bg-primary px-3 py-1 rounded position-absolute" style="top: 10px; right: 10px;"><?= $r['category_name']; ?></div>
                        <div class="p-4 pb-0 rounded-bottom">
                            <h4 class="menu-title"><?= $r['name']; ?></h4>
                            <p class="desc-text"><?= $r['description']; ?></p>
                            <div class="d-flex justify-content-between flex-lg-wrap">
                                <p class="text-dark fs-5 fw-bold"><?= number_to_currency($r['price'], 'IDR', 'id_ID'); ?></p>
                                <a href="#" class="btn border border-secondary rounded-pill px-3 py-1 mb-4 text-primary"><i class="fa fa-shopping-bag me-2 text-primary"></i> Add to cart</a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>
<!-- Single Product End -->
<?= $this->endSection(); ?>

<?= $this->section('scripts'); ?>
<script>
    const unitPrice = <?= $menu['price']; ?>;

    function updateSubtotal() {
        const input = document.getElementById('quantity');
        const subtotalElement = document.getElementById('subtotal');
        let currentValue = parseInt(input.value);

        if (currentValue > 5) {
            currentValue = 5;
            input.value = 5;
        } else if (currentValue < 1) {
            currentValue = 1;
            input.value = 1;
        }

        const subtotal = currentValue * unitPrice;
        subtotalElement.textContent = 'Rp' + subtotal.toLocaleString('id-ID');
    }

    $('.addCartForm').submit(function(e) {
        e.preventDefault();
        const formData = $(this).serialize();

        $.ajax({
            url: '<?= base_url('cart/add') ?>',
            type: 'POST',
            data: formData,
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    Toast.fire({
                        icon: "success",
                        title: response.success
                    });

                    const base_url = "<?= base_url(); ?>";
                    const cartItems = response.cart ?? 0;
                    let cartDropdownHtml = '';

                    if (cartItems.length > 0) {
                        cartItems.forEach(item => {
                            const price_formatted = new Intl.NumberFormat('id-ID', {
                                style: 'currency',
                                currency: 'IDR',
                                minimumFractionDigits: 0
                            }).format(item.price);

                            cartDropdownHtml += `
                                <li>
                                    <a href="${base_url}/shop/${item.slug}" class="dropdown-item d-flex justify-content-between text-reset text-decoration-none">
                                        <div class="d-flex align-items-start gap-3">
                                            <img src="${base_url}/assets/img/menu/${item.image}" alt="${item.name}" class="rounded img-thumbnail" width="56" height="56">
                                            <p class="d-inline-block text-wrap text-decoration-none fw-medium" style="max-width: 250px;">${item.name}</p>
                                        </div>
                                        <p class="fw-semibold"><span>${item.quantity}</span> &times; ${price_formatted}</p>
                                    </a>
                                </li>`;
                        });
                    } else {
                        cartDropdownHtml = `
                            <div class="d-flex flex-column justify-content-center align-items-center gap-3 p-3">
                                <img src="${base_url}/assets/img/empty-cart.png" alt="empty cart" width="200" height="200">
                                <h4 class="mb-0">Your cart is empty</h4>
                                <p class="mb-0">Want something? Add it to your cart now!</p>
                                <a href="${base_url}/shop" class="btn btn-primary px-5 py-2">Shop Now</a>
                            </div>`;
                    }

                    $('#cart-dropdown').html(cartDropdownHtml);
                    $('#cart-total').text(response.cartTotal);
                    $('.cart-total').text(response.cartTotal);
                } else {
                    Toast.fire({
                        icon: "error",
                        title: response.error
                    });
                }
            },
            error: function(xhr) {
                console.error("Error:", xhr.responseText);
            }
        });
    });

    $('.addFavorite').click(function(e) {
        const button = $(this);
        e.preventDefault();
        const menuId = $('#menu_id').val();
        const userId = $('#user_id').val();
        const price = $('#price').val();
        const quantity = 1;

        $.ajax({
            url: '<?= base_url('cart/add') ?>',
            type: 'POST',
            data: {
                type: 'Favorite',
                menu_id: menuId,
                user_id: userId,
                quantity: quantity,
                price: price
            },
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    if (response.favorite == 'added') {
                        button.addClass('text-danger');
                    } else {
                        button.removeClass('text-danger');
                    }

                    Toast.fire({
                        icon: "success",
                        title: response.success
                    });
                } else {
                    Toast.fire({
                        icon: "error",
                        title: response.error
                    });
                }
            },
            error: function(xhr) {
                console.error("Error:", xhr.responseText);
            }
        });
    });
</script>
<?= $this->endSection(); ?>
