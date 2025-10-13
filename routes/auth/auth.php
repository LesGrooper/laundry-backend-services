<?php

/** @var \Laravel\Lumen\Routing\Router $router */

$router->group(['prefix' => 'auth'], function () use ($router) {
    $router->post('logout', 'Auth\AuthController@logout');
    $router->post('login', 'Auth\AuthController@login');
    $router->get('me', 'Auth\AuthController@me');
});
