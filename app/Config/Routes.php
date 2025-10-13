<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

// Api
$routes->group('api', function ($routes) {
    $routes->group('supplier-data', function ($routes) {
        $routes->get('tabel', 'Api\SupplierData::tabel');
        $routes->get('detail/(:num)', 'Api\SupplierData::detail/$1');
        $routes->post('simpan', 'Api\SupplierData::simpan');
    });

    $routes->group('supplier-bank', function ($routes) {
        $routes->get('tabel', 'Api\SupplierBank::tabel');
        $routes->get('detail/(:num)', 'Api\SupplierBank::detail/$1');
        $routes->post('simpan', 'Api\SupplierBank::simpan');
    });

    $routes->group('invoice-master', function ($routes) {
        $routes->get('', 'Api\InvoiceMaster::index');
        $routes->get('tabel', 'Api\InvoiceMaster::tabel');
        $routes->get('detail/(:num)', 'Api\InvoiceMaster::detail/$1');
        $routes->post('simpan', 'Api\InvoiceMaster::simpan');
    });
});

service('auth')->routes($routes);
