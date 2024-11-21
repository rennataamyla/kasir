<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/products', 'Product::index');
$routes->get('/produk/tampil', 'Product::tampil_products');
$routes->post('/produk/simpan', 'Product::simpan_produk');
$routes->get('/produk/edit', 'Product::edit_produk');
$routes->post('/produk/update', 'Product::perbarui');
$routes->delete('/produk/hapus/(:num)', 'product::delete/$1');


$routes->get('/pelanggan', 'Pelanggan::index');
$routes->get('/pelanggan/tampil', 'pelanggan::tampil_pelanggan');
$routes->post('/pelanggan/simpan', 'pelanggan::simpan_pelanggan');
$routes->get('/pelanggan/edit', 'pelanggan::edit_produk');
$routes->post('/pelanggan/update', 'pelanggan::perbarui');
$routes->delete('/pelanggan/hapus/(:num)', 'pelanggan::delete/$1');