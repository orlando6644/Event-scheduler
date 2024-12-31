<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{

    //create array of interfaces and their respective implementations
    private $repositories = [
        \App\Repositories\Contracts\UserRepositoryInterface::class => \App\Repositories\Eloquent\UserRepository::class,
        \App\Repositories\Contracts\EventRepositoryInterface::class => \App\Repositories\Eloquent\EventRepository::class,
    ];

    /**
     * Register any application services.
     */
    public function register(): void
    {
        //Bind the interfaces to their respective implementations
        foreach ($this->repositories as $interface => $implementation) {
            $this->app->bind($interface, $implementation);
        }
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
