<?php

namespace GeneaLabs\LaravelChangelog\Providers;

use Illuminate\Support\ServiceProvider;

class Tool extends ServiceProvider
{
    public function boot() : void
    {
        $this->loadViewsFrom(__DIR__.'/../../resources/views', 'laravel-changelog');

        $this->app->booted(function () {
            $this->routes();
        });
    }

    protected function routes() : void
    {
        $namespace = 'GeneaLabs\LaravelChangelog\Http\Controllers';

        if ($this->app->routesAreCached()) {
            return;
        }

        app("router")
            ->middleware(['nova'])
            ->prefix('genealabs/laravel-changelog/api')
            ->namespace($namespace . "\Api")
            ->group(__DIR__ . '/../../routes/api.php');

        app("router")
            ->middleware(['web'])
            ->namespace($namespace)
            ->group(__DIR__ . '/../../routes/web.php');
    }

    public function register() : void
    {
        //
    }
}
