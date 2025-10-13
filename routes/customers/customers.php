<?php

/** @var \Laravel\Lumen\Routing\Router $router */

$router->group(['prefix' => 'api/customers'], function () use ($router) {
    $router->get('/', 'API\Customers\CustomersController@index');
    $router->post('/', 'API\Customers\CustomersController@store');
    $router->get('/{id}', 'API\Customers\CustomersController@show');
    $router->put('/{id}', 'API\Customers\CustomersController@update');
    $router->delete('/{id}', 'API\Customers\CustomersController@destroy');
});
