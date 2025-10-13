<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

// Api
$routes->group('api', function ($routes) {
    $routes->group('supplier', function ($routes) {
        $routes->get('tabel', 'Api\SupplierData::tabel');
        $routes->get('detail/(:num)', 'Api\SupplierData::detail/$1');
        $routes->post('simpan', 'Api\SupplierData::simpan');
    });

    $routes->group('supplier-bank', function ($routes) {
        $routes->get('tabel', 'Api\SupplierBank::tabel');
        $routes->get('detail/(:num)', 'Api\SupplierBank::detail/$1');
        $routes->post('simpan', 'Api\SupplierBank::simpan');
    });
});

service('auth')->routes($routes);
