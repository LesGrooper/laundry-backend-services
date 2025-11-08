<?php

/*
|--------------------------------------------------------------------------
| Create The Application
|--------------------------------------------------------------------------
|
| Bootstrap the Lumen app manually without going through /public/index.php.
|
*/

$app = require __DIR__ . '/bootstrap/app.php';

/*
|--------------------------------------------------------------------------
| Run The Application
|--------------------------------------------------------------------------
|
| Handle the incoming request through the app kernel.
|
*/

$app->run();
