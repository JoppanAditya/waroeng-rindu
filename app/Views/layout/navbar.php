<!-- Navbar start -->
<div class="container-fluid fixed-top">
    <div class="container topbar bg-primary d-none d-lg-block">
        <div class="d-flex justify-content-between">
            <div class="top-info ps-2">
                <small class="me-3"><i class="fas fa-map-marker-alt me-2 text-secondary"></i> <a href="#" class="text-white">Menteng, Jakarta</a></small>
                <small class="me-3"><i class="fas fa-envelope me-2 text-secondary"></i><a href="#" class="text-white">info@waroengrindu.swmenteng.com</a></small>
            </div>
            <div class="top-link pe-2">
                <a href="#" class="text-white"><small class="text-white mx-2">Privacy Policy</small>/</a>
                <a href="#" class="text-white"><small class="text-white mx-2">Terms of Use</small>/</a>
                <a href="#" class="text-white"><small class="text-white ms-2">Sales and Refunds</small></a>
            </div>
        </div>
    </div>

    <div class="container px-0">
        <nav class="navbar navbar-light bg-white navbar-expand-xl">
            <a href="<?= base_url(); ?>" class="navbar-brand">
                <img src="<?= base_url('assets/img/logo.png'); ?>" alt="Logo Waroeng Rindu" height="70">
            </a>
            <button class="navbar-toggler py-2 px-3" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
                <span class="fa fa-bars text-primary"></span>
            </button>
            <div class="collapse navbar-collapse bg-white" id="navbarCollapse">
                <div class="navbar-nav mx-auto">
                    <a href="<?= base_url(); ?>" class="nav-item nav-link <?= $title == 'Home' ? 'active' : ''; ?>">Home</a>
                    <a href="<?= base_url('shop'); ?>" class="nav-item nav-link <?= $title == 'Shop' ? 'active' : ''; ?>">Shop</a>
                    <a href="<?= base_url('contact'); ?>" class="nav-item nav-link <?= $title == 'Contact Us' ? 'active' : ''; ?>">Contact</a>
                </div>
                <div class="d-flex m-3 me-0 align-items-center justify-content-center">
                    <button class="btn-search btn border border-secondary btn-md-square rounded-circle bg-white me-3" data-bs-toggle="modal" data-bs-target="#searchModal"><i class="fas fa-search text-primary"></i></button>
                    <?php if (auth()->loggedIn()): ?>
                        <div class="nav-item dropdown my-auto">
                            <a href="<?= base_url('cart'); ?>" type="button" class="nav-link position-relative dropdown-toggle">
                                <i class="fa fa-shopping-bag fa-2x"></i>
                                <?php if (!empty(session('cart'))) : ?>
                                    <span id="cart-total" class="position-absolute bg-secondary rounded-circle d-flex align-items-center justify-content-center text-dark px-1" style="top: -5px; right: 8px; height: 20px; min-width: 20px;"><?= session('cartTotal'); ?></span>
                                <?php endif; ?>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end m-0 bg-secondary rounded-0" style="width: 500px;">
                                <div class="dropdown-header">
                                    <h6 class="text-dark m-0">Cart <span class="text-secondary cart-total">(<?= session('cartTotal'); ?>)</span></h6>
                                </div>
                                <hr class="dropdown-divider" />
                                <div id="cart-dropdown">
                                    <?php if (!empty(session('cart'))) : ?>
                                        <?php foreach (session('cart') as $c) : ?>
                                            <li>
                                                <a href=<?= base_url('shop/') . $c['slug'] ?> class="dropdown-item d-flex justify-content-between text-reset text-decoration-none">
                                                    <div class="d-flex align-items-start gap-3">
                                                        <img src="<?= base_url('assets/img/menu/') . $c['image'] ?>" alt="<?= $c['name'] ?>" class="rounded img-thumbnail" width="56" height="56">
                                                        <p class="d-inline-block text-wrap text-decoration-none fw-medium" style="max-width: 250px;"><?= $c['name'] ?></p>
                                                    </div>
                                                    <p class="fw-semibold"><span><?= $c['quantity'] ?></span> &times; <?= number_to_currency($c['price'], 'IDR', 'id_ID'); ?></p>
                                                </a>
                                            </li>
                                        <?php endforeach; ?>
                                    <?php else : ?>
                                        <div class="d-flex flex-column justify-content-center align-items-center gap-3 p-3">
                                            <img src="<?= base_url('assets/') ?>img/empty-cart.png" alt="empty cart" width="200" height="200">
                                            <h4 class="mb-0">Your cart is empty</h4>
                                            <p class="mb-0">Want something? Add it to your cart now!</p>
                                            <a href="<?= base_url('shop') ?>" class="btn btn-primary px-5 py-2">Shop Now</a>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </ul>
                        </div>
                        <div class="nav-item dropdown my-auto">
                            <a href="<?= base_url('settings'); ?>" class="nav-link">
                                <img class="rounded-circle ms-2" src="<?= base_url('assets/img/user/') . $user->image; ?>" alt="profile picture" width="44">
                            </a>
                            <div class="dropdown-menu m-0 bg-secondary rounded-0">
                                <?php if (isset($user) && $user->inGroup('superadmin', 'admin')) : ?>
                                    <a href="<?= base_url('admin/dashboard'); ?>" class="dropdown-item">Dashboard</a>
                                    <hr class="dropdown-divider" />
                                <?php endif; ?>
                                <a href="<?= base_url('order-list'); ?>" class="dropdown-item">Purchase</a>
                                <a href="<?= base_url('favorite'); ?>" class="dropdown-item">Favorites</a>
                                <a href="<?= base_url('settings'); ?>" class="dropdown-item">Settings</a>
                                <hr class="dropdown-divider" />
                                <a href="<?= base_url('logout'); ?>" class="dropdown-item">Logout</a>
                            </div>
                        </div>
                    <?php else: ?>
                        <div class="my-auto">
                            <a href="<?= base_url('register'); ?>" type="button" class="btn btn-primary me-2">Register</a>
                            <a href="<?= base_url('login'); ?>" type="button" class="btn btn-outline-primary">Login</a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </nav>
    </div>
</div>
<!-- Navbar End -->

<!-- Modal Search Start -->
<div class="modal fade" id="searchModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-fullscreen">
        <div class="modal-content rounded-0">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Search by keyword</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body d-flex align-items-center">
                <div class="input-group w-75 mx-auto d-flex">
                    <input type="search" class="form-control p-3" placeholder="keywords" aria-describedby="search-icon-1">
                    <span id="search-icon-1" class="input-group-text p-3"><i class="fa fa-search"></i></span>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Modal Search End -->
