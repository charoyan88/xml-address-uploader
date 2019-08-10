<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\AddressService;

class AddressServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(AddressService::class);
    }
}
