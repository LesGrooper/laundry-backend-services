<?php

/** @var \Laravel\Lumen\Routing\Router $router */

$router->group(['prefix' => 'api/invoice-details'], function () use ($router) {
    $router->get('/', 'API\Invoice\InvoiceDetailController@index');
    $router->post('/', 'API\Invoice\InvoiceDetailController@store');
    $router->get('/{id}', 'API\Invoice\InvoiceDetailController@show');
    $router->put('/{id}', 'API\Invoice\InvoiceDetailController@update');
    $router->delete('/{id}', 'API\Invoice\InvoiceDetailController@destroy');
    $router->get('/by-invoice/{invoice_id}', 'API\Invoice\InvoiceDetailController@getByInvoice');
});
