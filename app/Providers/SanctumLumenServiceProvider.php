<?php

namespace App\Providers;

use Laravel\Sanctum\SanctumServiceProvider;

class SanctumLumenServiceProvider extends SanctumServiceProvider
{
    public function register()
    {
        // Jangan panggil parent::register() kalau tidak perlu
        // untuk mencegah pemanggilan config yang tidak ada
        $this->mergeConfigFrom(
            __DIR__ . '/../../config/sanctum.php', 'sanctum'
        );
    }

    public function boot()
    {
        // Hindari parent::boot() karena ada configurationIsCached()
        // Inisialisasi manual bagian penting Sanctum
        $this->publishes([
            __DIR__.'/../../vendor/laravel/sanctum/config/sanctum.php' => config_path('sanctum.php'),
        ], 'config');
    }
}
