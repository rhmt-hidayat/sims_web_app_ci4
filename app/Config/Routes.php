<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/produk', 'Home::index');
$routes->get('/profil', 'Home::profil');
$routes->get('/login', 'Home::login');
