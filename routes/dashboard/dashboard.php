<?php

/** @var \Laravel\Lumen\Routing\Router $router */

$router->group(['prefix' => 'api/dashboards'], function () use ($router) {
    $router->get('/calendar', 'API\Dashboard\DashboardController@calendar');
    $router->get('/report-summary', 'API\Dashboard\DashboardController@reportSummary');
});
