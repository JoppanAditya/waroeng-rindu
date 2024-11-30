<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>
<main class="my-5 py-3">
    <div class="mt-5 pt-4">
        <div class="container my-5">
            <div class="card text-center mt-5">
                <div class="card-header">
                    <ul class="nav nav-tabs card-header-tabs">
                        <li class="nav-item">
                            <a class="nav-link py-1 px-2 py-sm-2 px-sm-3 rounded-top-3 <?= $title == 'My Profile' ? 'active' : 'text-dark' ?>" aria-current="true" href="<?= base_url('settings'); ?>" style="color: #FF9843; font-weight: 500;">My Profile</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link py-1 px-2 py-sm-2 px-sm-3 rounded-top-3 <?= $title == 'Address List' ? 'active' : 'text-dark' ?>" href="<?= base_url('settings/address'); ?>">Address List</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link py-1 px-2 py-sm-2 px-sm-3 rounded-top-3 <?= $title == 'Favorite' ? 'active' : 'text-dark' ?>" href="<?= base_url('favorite'); ?>">Favorite</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link py-1 px-2 py-sm-2 px-sm-3 rounded-top-3 <?= $title == 'Order List' ? 'active' : 'text-dark' ?>" href="<?= base_url('order-list'); ?>">Order List</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link py-1 px-2 py-sm-2 px-sm-3 rounded-top-3 <?= $title == 'Payment List' ? 'active' : 'text-dark' ?>" href="<?= base_url('payment-list'); ?>">Payment List</a>
                        </li>
                        <!-- <li class="nav-item">
                            <a class="nav-link py-1 px-2 py-sm-2 px-sm-3 rounded-top-3 <?= $title == 'Security' ? 'active' : 'text-dark' ?>" href="<?= base_url('settings/security'); ?>">Security</a>
                        </li> -->
                    </ul>
                </div>

                <div class="card-body">
                    <?= $this->renderSection('card-content') ?>
                </div>
            </div>
        </div>
    </div>
</main>
<?= $this->endSection(); ?>
