<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'User::index');
$routes->post('/auth', 'User::auth');
$routes->get('/register', 'User::register');
$routes->post('/authRegister', 'User::proses_register');
$routes->get('/logout', 'User::logout');
$routes->get('/profil', 'User::profil');
//CRUD produk
$routes->get('/produk', 'Produk::index');
$routes->get('/produk/(:num)', 'Produk::detail/$1');
$routes->add('/produk/add', 'Produk::create');
$routes->add('/produk/(:segment)/edit', 'Produk::edit/$1');
$routes->get('/produk/(:segment)/delete', 'Produk::delete/$1');
