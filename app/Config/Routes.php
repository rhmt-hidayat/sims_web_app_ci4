<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->post('/auth', 'Home::auth');
$routes->get('/profil', 'Home::profil');
//CRUD produk
$routes->get('/produk', 'Produk::index');
$routes->get('/produk/(:num)', 'Produk::detail/$1');
$routes->add('/produk/add', 'Produk::create');
$routes->add('/produk/(:segment)/edit', 'Produk::edit/$1');
$routes->get('/produk/(:segment)/delete', 'Produk::delete/$1');
