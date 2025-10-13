<?php

/** @var \Laravel\Lumen\Routing\Router $router */

$router->group(['prefix' => 'api/invoices'], function () use ($router) {
    $router->get('/', 'API\Invoice\InvoiceController@index');
    $router->post('/', 'API\Invoice\InvoiceController@store');
    $router->get('/{id}', 'API\Invoice\InvoiceController@show');
    $router->put('/{id}', 'API\Invoice\InvoiceController@update');
    $router->delete('/{id}', 'API\Invoice\InvoiceController@destroy');
    // $router->get('/report', 'API\Invoice\InvoiceController@report');
});
