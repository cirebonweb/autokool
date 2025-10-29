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
        $routes->get('getid', 'Api\SupplierData::getId');
        $routes->get('detail/(:num)', 'Api\SupplierData::detail/$1');
        $routes->post('simpan', 'Api\SupplierData::simpan');
    });

    $routes->group('supplier-bank', function ($routes) {
        $routes->get('tabel', 'Api\SupplierBank::tabel');
        $routes->get('getid', 'Api\SupplierBank::getId');
        $routes->get('detail/(:num)', 'Api\SupplierBank::detail/$1');
        $routes->post('simpan', 'Api\SupplierBank::simpan');
    });

    $routes->group('invoice-master', function ($routes) {
        $routes->get('', 'Api\InvoiceMaster::index');
        $routes->get('tabel', 'Api\InvoiceMaster::tabel');
        $routes->get('detail/(:num)', 'Api\InvoiceMaster::detail/$1');
        $routes->post('simpan', 'Api\InvoiceMaster::simpan');
    });

    $routes->group('invoice-data', function ($routes) {
        $routes->get('tabel', 'Api\InvoiceData::tabel');
        $routes->get('get-idtgl/(:segment)', 'Api\InvoiceData::getIdTgl/$1');
        $routes->get('get-tahun', 'Api\InvoiceData::getTahun');
        $routes->get('get-bulan', 'Api\InvoiceData::getBulan');
        $routes->get('get-ttd/(:num)', 'Api\InvoiceData::getTtd/$1');
        $routes->get('hapus/(:num)', 'Api\InvoiceData::hapus/$1');
        $routes->post('simpan', 'Api\InvoiceData::simpan');
    });
    
    $routes->group('invoice-supplier', function ($routes) {
        $routes->get('tabel-data/(:num)', 'Api\InvoiceSupplier::tabelData/$1');
        $routes->get('tabel-isi/(:num)/(:num)', 'Api\InvoiceSupplier::tabelIsi/$1/$2');
        $routes->get('hitung-isi/(:num)', 'Api\InvoiceSupplier::hitungIsi/$1');
        $routes->get('print-isi/(:num)', 'Api\InvoiceSupplier::printIsi/$1');
        $routes->get('print-isites', 'Api\InvoiceSupplier::printIsiTes');
        $routes->get('hapus/(:num)', 'Api\InvoiceSupplier::hapus/$1');
        $routes->post('simpan-isi', 'Api\InvoiceSupplier::simpanIsi');
    });
});

service('auth')->routes($routes);
