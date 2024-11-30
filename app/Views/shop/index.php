<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>
<!-- Single Page Header start -->
<div class="container-fluid page-header py-5">
    <h1 class="text-center text-white display-6">Shop</h1>
    <ol class="breadcrumb justify-content-center mb-0">
        <li class="breadcrumb-item"><a href="<?= base_url(); ?>">Home</a></li>
        <li class="breadcrumb-item active text-white">Shop</li>
    </ol>
</div>
<!-- Single Page Header End -->


<!-- Fruits Shop Start-->
<div class="container-fluid fruite py-5">
    <div class="container py-5">
        <h1 class="mb-4">Menu Waoreng Rindu</h1>
        <div class="row g-4">
            <div class="col-lg-12">
                <div class="row g-4">
                    <div class="col-xl-3">
                        <form action="" method="post">
                            <?= csrf_field(); ?>
                            <div class="input-group w-100 mx-auto d-flex">
                                <input type="text" class="form-control" placeholder="Search a menu" aria-describedby="button-addon2" name="keyword">
                                <button class="btn btn-secondary" type="submit" id="button-addon2" name="submit"><i class="fa fa-search"></i></button>
                            </div>
                        </form>
                    </div>
                    <div class="col-6"></div>
                    <div class="col-xl-3">
                        <div class="bg-light ps-3 py-3 rounded d-flex justify-content-between mb-4">
                            <label for="fruits">Default Sorting:</label>
                            <select id="fruits" name="fruitlist" class="border-0 form-select-sm bg-light me-3" form="fruitform">
                                <option value="volvo">Nothing</option>
                                <option value="saab">Popularity</option>
                                <option value="opel">Organic</option>
                                <option value="audi">Fantastic</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row g-4">
                    <div class="col-lg-3">
                        <div class="row g-4">
                            <div class="col-lg-12">
                                <div class="mb-3">
                                    <h4>Categories</h4>
                                    <ul class="list-unstyled fruite-categorie">
                                        <?php foreach ($categories as $c): ?>
                                            <li>
                                                <div class="d-flex justify-content-between fruite-name">
                                                    <a href="#"><i class="fas fa-utensils me-2"></i></i><?= $c['name']; ?></a>
                                                </div>
                                            </li>
                                        <?php endforeach; ?>
                                    </ul>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="mb-3">
                                    <h4 class="mb-2">Price</h4>
                                    <form action="<?= base_url('shop') ?>" method="get" id="filter-price">
                                        <div class="input-group mb-3">
                                            <span class="input-group-text" style="font-size: 14px">Rp</span>
                                            <input type="text" class="form-control filter-price" placeholder="Minimum Price" aria-label="Minimum Price" name="minP" value="" style="font-size: 14px" />
                                        </div>
                                        <div class="input-group">
                                            <span class="input-group-text" style="font-size: 14px">Rp</span>
                                            <input type="text" class="form-control filter-price" placeholder="Maximum Price" aria-label="Maximum Price" name="maxP" value="" style="font-size: 14px" />
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="mb-3">
                                    <h3 class="border-top pt-3 mt-4" style="border-color: rgba(0, 0, 0, 0.1) !important">Rating</h3>
                                    <form action="<?= base_url('shop') ?>" method="get" id="filter-rating">
                                        <div>
                                            <input class="btn-check filter-rating" type="radio" name="r" id="rate4" value="4">
                                            <label class="btn btn-outline-light border-0 text-dark" for="rate4"> <i class="fa fa-star" style="color: #ff9843"></i> 4 Keatas </label>
                                        </div>
                                        <div>
                                            <input class="btn-check filter-rating" type="radio" name="r" id="rate3" value="3">
                                            <label class="btn btn-outline-light border-0 text-dark" for="rate3"> <i class="fa fa-star" style="color: #ff9843"></i> 3 Keatas </label>
                                        </div>
                                        <div>
                                            <input class="btn-check filter-rating" type="radio" name="r" id="rate2" value="2">
                                            <label class="btn btn-outline-light border-0 text-dark" for="rate2"> <i class="fa fa-star" style="color: #ff9843"></i> 2 Keatas </label>
                                        </div>
                                        <div>
                                            <input class="btn-check filter-rating" type="radio" name="r" id="rate1" value="1">
                                            <label class="btn btn-outline-light border-0 text-dark" for="rate1"> <i class="fa fa-star" style="color: #ff9843"></i> 1 Keatas </label>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="position-relative bg-dark rounded-3">
                                    <img src="<?= base_url('assets/'); ?>img/nasigoreng.png" class="img-fluid w-100 rounded" alt="">
                                    <div class="position-absolute" style="top: 50%; right: 17px; transform: translateY(-50%);">
                                        <h3 class="text-light fw-bold">Mudah <br> Cepat <br> Nikmat</h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-9">
                        <div class="row g-4 justify-content-center">

                            <?php foreach ($menus as $m): ?>
                                <div class="col-md-6 col-lg-6 col-xl-4">
                                    <a href="<?= base_url('shop/' . $m['slug']); ?>">
                                        <div class="rounded position-relative fruite-item">
                                            <div class="fruite-img">
                                                <img src="<?= base_url('assets/img/menu/') . $m['image']; ?>" class="img-fluid w-100 rounded-top" alt="<?= $m['name'] . ' image'; ?>">
                                            </div>
                                            <div class="text-white bg-secondary px-3 py-1 rounded position-absolute" style="top: 10px; left: 10px;"><?= $m['category_name']; ?></div>
                                            <div class="p-4 border border-secondary border-top-0 rounded-bottom">
                                                <h4><?= $m['name']; ?></h4>
                                                <p class="text-body"><?= $m['description']; ?></p>
                                                <div class="d-flex justify-content-between flex-lg-wrap">
                                                    <p class="text-dark fs-5 fw-bold mb-0"><?= number_to_currency($m['price'], 'IDR', 'id_ID'); ?></p>

                                                    <?= form_open('cart/add', ['class' => 'addCartForm']) ?>
                                                    <?= csrf_field(); ?>
                                                    <?php if (!auth()->loggedIn()) : ?>
                                                        <a href="<?= base_url('login') ?>" class="btn border border-secondary rounded-pill px-3 text-primary"><i class="fa fa-shopping-bag me-2 text-primary"></i> Add to cart</a>
                                                    <?php else : ?>
                                                        <input type="hidden" name="type" value="Shopping">
                                                        <input type="hidden" name="menu_id" value="<?= $m['id'] ?>">
                                                        <input type="hidden" name="user_id" value="<?= user_id() ?>">
                                                        <input type="hidden" name="quantity" value="1">
                                                        <input type="hidden" name="price" value="<?= $m['price'] ?>">
                                                        <button type="submit" class="btn border border-secondary rounded-pill px-3 text-primary addButton"><i class="fa fa-shopping-bag me-2 text-primary"></i> Add to cart</button>
                                                    <?php endif; ?>
                                                    <?= form_close(); ?>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            <?php endforeach; ?>

                            <?= $pager->links('menus', 'shop_pagination') ?>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Fruits Shop End-->
<?= $this->endSection(); ?>

<?= $this->section('scripts'); ?>
<script>
    $(document).ready(function() {
        $('.addCartForm').submit(function(e) {
            e.preventDefault();

            $.ajax({
                url: $(this).attr('action'),
                type: 'POST',
                data: $(this).serialize(),
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        Toast.fire({
                            icon: "success",
                            title: response.success
                        });

                        const base_url = "<?= base_url(); ?>";
                        const cartItems = response.cart;
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
                error: function(xhr, ajaxOptions, thrownError) {
                    console.error(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                }
            });
        });
    });
</script>
<?= $this->endSection(); ?>
