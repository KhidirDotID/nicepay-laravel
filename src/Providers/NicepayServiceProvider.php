<?php

namespace KhidirDotID\Nicepay\Providers;

use Illuminate\Support\ServiceProvider;
use KhidirDotID\Nicepay\NicepayLib;

class NicepayServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->mergeConfigFrom($this->getConfigPath(), 'nicepay');

        $this->app->singleton('nicepay', function ($app) {
            return new NicepayLib($app);
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        $this->publishes([
            $this->getConfigPath() => config_path('nicepay.php'),
        ], 'nicepay-config');
    }

    public function getConfigPath()
    {
        return __DIR__ . '/../../config/nicepay.php';
    }
}
