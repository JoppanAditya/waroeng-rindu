<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'HomeController::index');

$routes->group('shop', static function ($routes) {
    $routes->match(['GET', 'POST'], '/', 'ShopController::index');
    $routes->get('(:segment)', 'ShopController::detail/$1');
});

$routes->get('/contact', 'HomeController::contact');

$routes->group('cart', static function ($routes) {
    $routes->get('/', 'CartController::index');
    $routes->get('get', 'CartController::get');
    // $routes->get('getTotalItems', 'CartController::getCartTotal');
    $routes->post('add', 'CartController::add');
    $routes->post('update', 'CartController::update');
    $routes->post('remove', 'CartController::remove');
});

$routes->group('admin', ['filter' => 'group:admin,superadmin'], static function ($routes) {
    $routes->get('dashboard', 'DashboardController::index');
    $routes->get('profile', 'DashboardController::profile');

    $routes->group('menu', static function ($routes) {
        $routes->get('/', 'MenuController::index');
        $routes->get('get', 'MenuController::get');
        $routes->get('addForm', 'MenuController::addForm');
        $routes->post('add', 'MenuController::add');
        $routes->post('editForm', 'MenuController::editForm');
        $routes->post('update', 'MenuController::update');
        $routes->post('delete', 'MenuController::delete');
        $routes->post('detail', 'MenuController::detail');
    });

    $routes->group('category', static function ($routes) {
        $routes->get('/', 'MenuCategoryController::index');
        $routes->get('get', 'MenuCategoryController::get');
        $routes->get('addForm', 'MenuCategoryController::addForm');
        $routes->post('add', 'MenuCategoryController::add');
        $routes->post('editForm', 'MenuCategoryController::editForm');
        $routes->post('update', 'MenuCategoryController::update');
        $routes->post('delete', 'MenuCategoryController::delete');
    });

    $routes->group('admin', static function ($routes) {
        $routes->get('/', 'AdminAdminController::index');
        $routes->get('get', 'AdminAdminController::get');
        $routes->get('addForm', 'AdminAdminController::addForm');
        $routes->post('add', 'AdminAdminController::add');
        $routes->post('editForm', 'AdminAdminController::editForm');
        $routes->post('update', 'AdminAdminController::update');
        $routes->post('delete', 'AdminAdminController::delete');
        $routes->post('detail', 'AdminAdminController::detail');
    });

    $routes->group('user', static function ($routes) {
        $routes->get('/', 'AdminUserController::index');
        $routes->get('get', 'AdminUserController::get');
        $routes->post('editForm', 'AdminUserController::editForm');
        $routes->post('update', 'AdminUserController::update');
        $routes->post('delete', 'AdminUserController::delete');
        $routes->post('detail', 'AdminUserController::detail');
    });
});

$routes->group('transaction', static function ($routes) {
    $routes->get('/', 'TransactionController::index');
    $routes->get('shipping', 'TransactionController::shipping');
    $routes->get('payment-method', 'TransactionController::paymentMethod');
    $routes->post('payment', 'TransactionController::payment');
    $routes->post('save', 'TransactionController::save');
});

$routes->group('address', static function ($routes) {
    $routes->get('get', 'AddressController::get');
    $routes->get('dataModal', 'AddressController::dataModal');
    $routes->get('addForm', 'AddressController::addForm');
    $routes->post('editForm', 'AddressController::editForm');
    $routes->post('add', 'AddressController::add');
    $routes->post('update', 'AddressController::update');
    $routes->post('updateSelected', 'AddressController::updateSelected');
    $routes->post('updatePrimary', 'AddressController::updatePrimary');
    $routes->post('delete', 'AddressController::delete');
});

$routes->group('shipment', static function ($routes) {
    $routes->get('province', 'RajaOngkir::province');
    $routes->get('city', 'RajaOngkir::city');
    $routes->post('cost', 'RajaOngkir::cost');
});

service('auth')->routes($routes);
