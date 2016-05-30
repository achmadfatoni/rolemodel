<?php

namespace Klsandbox\RoleModel;

use Illuminate\Support\ServiceProvider;
use Klsandbox\SiteConfig\Services\SiteConfig;

class RoleModelServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [];
    }

    public function boot()
    {
        $this->app['router']->middleware('role', \Klsandbox\RoleModel\Http\Middleware\RoleMiddleware::class);

        $this->publishes([
            __DIR__ . '/../../../database/migrations/' => database_path('/migrations'),
                ], 'migrations');

        $this->publishes([
            __DIR__ . '/../../../config/' => config_path(),
                ], 'config');

        SiteConfig::macro('has_staff', function () {
            return (bool) config('role.roles.staff');
        });

        SiteConfig::macro('has_dropship', function () {
            return (bool) config('role.roles.dropship');
        });

        SiteConfig::macro('dropship_can_register', function () {
            return (bool) config('role.can_register.dropship');
        });

        SiteConfig::macro('has_sales', function () {
            return (bool) config('role.roles.sales');
        });
    }
}
