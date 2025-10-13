<?php

/** @var \Laravel\Lumen\Routing\Router $router */

use Illuminate\Support\Facades\File;
use App\Http\Controllers\API\Dashboard\DashboardController;

// Default route
$router->get('/', function () {
    return response()->json(['message' => 'Lumen API is running']);
});

// --- Auto Load Modular Routes ---

// Load semua file di dalam folder routes/auth
foreach (File::allFiles(base_path('routes/auth')) as $routeFile) {
    require $routeFile->getPathname();
}

// Load semua file di dalam folder routes/customers
foreach (File::allFiles(base_path('routes/customers')) as $routeFile) {
    require $routeFile->getPathname();
}

// Load semua file di dalam folder routes/products
foreach (File::allFiles(base_path('routes/products')) as $routeFile) {
    require $routeFile->getPathname();
}

// Load semua file di dalam folder routes/service-products
foreach (File::allFiles(base_path('routes/service-products')) as $routeFile) {
    require $routeFile->getPathname();
}

// Load semua file di dalam folder routes/invoice
foreach (File::allFiles(base_path('routes/invoice')) as $routeFile) {
    require $routeFile->getPathname();
}

// Load semua file di dalam folder routes/invoice-details
foreach (File::allFiles(base_path('routes/invoice-details')) as $routeFile) {
    require $routeFile->getPathname();
}

// Load semua file di dalam folder routes/dashboard
foreach (File::allFiles(base_path('routes/dashboard')) as $routeFile) {
    require $routeFile->getPathname();
}

