<?php

namespace Klsandbox\RoleModel;

use Illuminate\Support\ServiceProvider;
use Klsandbox\SiteConfig\Services\SiteConfig;

class RoleModelServiceProvider extends ServiceProvider {

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
    public function register() {
        //
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides() {
        return [];
    }

    public function boot() {
        $this->publishes([
            __DIR__ . '/../../../database/migrations/' => database_path('/migrations')
                ], 'migrations');

        $this->publishes([
            __DIR__ . '/../../../config/' => config_path()
                ], 'config');

        SiteConfig::macro('has_staff', function () {
            return !!config('role.roles.staff');
        });
    }

}
