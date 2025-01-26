<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->post('/auth', 'Home::auth');
$routes->get('/profil', 'Home::profil');
$routes->get('/produk', 'Produk::index');
$routes->get('/add', 'Produk::insert');
