<div class="col-lg-12">
    <div class="row g-4">
        <?php if ($menus): ?>
            <?php foreach ($menus as $m): ?>
                <div class="col-md-6 col-lg-6 col-xl-3">
                    <a href="<?= base_url('shop/' . $m['slug']); ?>">
                        <div class="rounded position-relative fruite-item">
                            <div class="fruite-img">
                                <img src="<?= base_url('assets/img/menu/') . $m['image']; ?>" class="img-fluid w-100 rounded-top" alt="<?= $m['name'] . ' image'; ?>">
                            </div>
                            <div class="text-white bg-secondary px-3 py-1 rounded position-absolute" style="top: 10px; left: 10px;"><?= $m['category_name']; ?></div>
                            <div class="p-4 border border-secondary border-top-0 rounded-bottom">
                                <h4 class="text-start"><?= $m['name']; ?></h4>
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

            <?= $pager->links('favorites', 'shop_pagination') ?>
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
    </div>
</div>
