<?php
/** @var \Laravel\Lumen\Routing\Router $router */

$router->group(['prefix' => 'api/products'], function () use ($router) {
    $router->get('/', 'API\Products\ProductsController@index');
    $router->post('/', 'API\Products\ProductsController@store');
    $router->get('/{id}', 'API\Products\ProductsController@show');
    $router->put('/{id}', 'API\Products\ProductsController@update');
    $router->delete('/{id}', 'API\Products\ProductsController@destroy');
});
