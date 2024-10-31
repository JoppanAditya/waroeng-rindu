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
                                        <li>
                                            <div class="d-flex justify-content-between fruite-name">
                                                <a href="#"><i class="fas fa-apple-alt me-2"></i>Apples</a>
                                                <span>(3)</span>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="d-flex justify-content-between fruite-name">
                                                <a href="#"><i class="fas fa-apple-alt me-2"></i>Oranges</a>
                                                <span>(5)</span>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="d-flex justify-content-between fruite-name">
                                                <a href="#"><i class="fas fa-apple-alt me-2"></i>Strawbery</a>
                                                <span>(2)</span>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="d-flex justify-content-between fruite-name">
                                                <a href="#"><i class="fas fa-apple-alt me-2"></i>Banana</a>
                                                <span>(8)</span>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="d-flex justify-content-between fruite-name">
                                                <a href="#"><i class="fas fa-apple-alt me-2"></i>Pumpkin</a>
                                                <span>(5)</span>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="mb-3">
                                    <h4 class="mb-2">Price</h4>
                                    <input type="range" class="form-range w-100" id="rangeInput" name="rangeInput" min="0" max="500" value="0" oninput="amount.value=rangeInput.value">
                                    <output id="amount" name="amount" min-velue="0" max-value="500" for="rangeInput">0</output>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="mb-3">
                                    <h4>Additional</h4>
                                    <div class="mb-2">
                                        <input type="radio" class="me-2" id="Categories-1" name="Categories-1" value="Beverages">
                                        <label for="Categories-1"> Organic</label>
                                    </div>
                                    <div class="mb-2">
                                        <input type="radio" class="me-2" id="Categories-2" name="Categories-1" value="Beverages">
                                        <label for="Categories-2"> Fresh</label>
                                    </div>
                                    <div class="mb-2">
                                        <input type="radio" class="me-2" id="Categories-3" name="Categories-1" value="Beverages">
                                        <label for="Categories-3"> Sales</label>
                                    </div>
                                    <div class="mb-2">
                                        <input type="radio" class="me-2" id="Categories-4" name="Categories-1" value="Beverages">
                                        <label for="Categories-4"> Discount</label>
                                    </div>
                                    <div class="mb-2">
                                        <input type="radio" class="me-2" id="Categories-5" name="Categories-1" value="Beverages">
                                        <label for="Categories-5"> Expired</label>
                                    </div>
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

                            <?php foreach ($menu as $m): ?>
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
                                                        <input type="hidden" name="menu_id" value="<?= $m['id'] ?>">
                                                        <input type="hidden" name="quantity" value="1">
                                                        <input type="hidden" name="user_id" value="<?= user_id() ?>">
                                                        <input type="hidden" name="price" value="<?= $m['price'] ?>">
                                                        <button class="btn border border-secondary rounded-pill px-3 text-primary addButton"><i class="fa fa-shopping-bag me-2 text-primary"></i> Add to cart</button>
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

    $(document).ready(function() {
        $('.addCartForm').submit(function(e) {
            e.preventDefault();

            $.ajax({
                url: $(this).attr('action'),
                type: 'POST',
                data: $(this).serialize(),
                dataType: 'json',
                beforeSend: function() {
                    $('.addButton').attr('disabled', 'disabled');
                    $('.addButton').html('<span class="spinner-border spinner-border-sm me-1" aria-hidden="true"></span><span role="status">Loading...</span>');
                },
                complete: function() {
                    $('.addButton').removeAttr('disabled', 'disabled');
                    $('.addButton').html('Add To Cart');
                },
                error: function(xhr) {
                    console.error("Error:", xhr.responseText);
                }
            });
        });

        // $('.addCartForm').submit(function(e) {
        //     e.preventDefault();

        //     $.ajax({
        //         url: $(this).attr('action'),
        //         type: 'POST',
        //         data: $(this).serialize(),
        //         dataType: 'json',
        //         beforeSend: function() {
        //             $('.addButton').attr('disabled', 'disabled');
        //             $('.addButton').html('<span class="spinner-border spinner-border-sm me-1" aria-hidden="true"></span><span role="status">Loading...</span>');
        //         },
        //         complete: function() {
        //             $('.addButton').removeAttr('disabled', 'disabled');
        //             $('.addButton').html('Add To Cart');
        //         },
        //         success: function(response) {
        //             if (response.error) {
        //                 Toast.fire({
        //                     icon: "error",
        //                     title: response.message
        //                 });
        //             } else {
        //                 Toast.fire({
        //                     icon: "success",
        //                     title: response.message
        //                 });
        //             }
        //             // window.location.href = document.referrer
        //         },
        //         error: function(xhr, ajaxOptions, thrownError) {
        //             console.error(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
        //         }
        //     });
        // });
    });
</script>
<?= $this->endSection(); ?>
