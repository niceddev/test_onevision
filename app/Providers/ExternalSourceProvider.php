<?php

namespace App\Providers;

use App\Contracts\ExternalSourceInterface;
use App\Repositories\DummyJsonRepository;
use Illuminate\Support\ServiceProvider;

class ExternalSourceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(ExternalSourceInterface::class, DummyJsonRepository::class);
//        $this->app->singleton(ExternalSourceInterface::class, AnotherSource::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
