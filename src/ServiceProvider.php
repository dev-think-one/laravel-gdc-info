<?php

namespace GDCInfo;

class ServiceProvider extends \Illuminate\Support\ServiceProvider
{
    public function boot(): void
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/../config/gdc-info.php' => config_path('gdc-info.php'),
            ], 'config');

        }

        $this->commands([

        ]);
    }

    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/gdc-info.php', 'gdc-info');

        $this->app->singleton('gdc-info-manager', function ($app) {
            return new GDCInfoManager;
        });
    }
}
