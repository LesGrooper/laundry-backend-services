<?php

/** @var \Laravel\Lumen\Routing\Router $router */

$router->group(['prefix' => 'api/service-products'], function () use ($router) {
    $router->get('/', 'API\ServiceProducts\ServiceProductsController@index');
    $router->post('/', 'API\ServiceProducts\ServiceProductsController@store');
    $router->get('/{id}', 'API\ServiceProducts\ServiceProductsController@show');
    $router->put('/{id}', 'API\ServiceProducts\ServiceProductsController@update');
    $router->delete('/{id}', 'API\ServiceProducts\ServiceProductsController@destroy');
});
