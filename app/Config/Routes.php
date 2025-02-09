<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

$routes->get('/', 'User::index');
$routes->post('/auth', 'User::auth');
$routes->get('/register', 'User::register');
$routes->post('/authRegister', 'User::proses_register');
$routes->get('/forgot-password', 'User::forgotPassword');
$routes->post('/forgot-password', 'User::processForgotPassword');
$routes->get('/reset-password/(:any)', 'User::resetPassword/$1');
$routes->post('/reset-password', 'User::processResetPassword');
$routes->get('/logout', 'User::logout');

$routes->group('', ['filter' => 'auth'], function ($routes) {
    $routes->get('/profil', 'User::profil');
    $routes->get('/produk', 'Produk::index');
    $routes->add('/produk/add', 'Produk::create');
    $routes->get('/produk/detail/(:segment)', 'Produk::detail/$1');
    $routes->add('/produk/(:segment)/edit', 'Produk::edit/$1');
    $routes->get('/produk/(:segment)/delete', 'Produk::delete/$1');
    $routes->get('/produk/export', 'Produk::export');
    // $routes->get('/produk/export/(:any)', 'Produk::export/$1');
    $routes->get('/produk/print/(:num)', 'Produk::cetak_invoice/$1');
});
