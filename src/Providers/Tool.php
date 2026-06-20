<?php

declare(strict_types=1);

namespace GeneaLabs\LaravelChangelog\Providers;

use GeneaLabs\LaravelChangelog\Http\Livewire\ChangelogPage;
use Illuminate\Support\ServiceProvider;
use Livewire\Livewire;

class Tool extends ServiceProvider
{
    public function boot(): void
    {
        $this->loadViewsFrom(__DIR__ . '/../../resources/views', 'laravel-changelog');

        if (class_exists(Livewire::class)) {
            Livewire::component('changelog-page', ChangelogPage::class);
        }

        $this->app->booted(function () {
            $this->routes();
        });
    }

    protected function routes(): void
    {
        $namespace = 'GeneaLabs\LaravelChangelog\Http\Controllers';

        if ($this->app->routesAreCached()) {
            return;
        }

        app('router')
            ->middleware(['nova'])
            ->prefix('genealabs/laravel-changelog/api')
            ->namespace($namespace . '\Api')
            ->group(__DIR__ . '/../../routes/api.php');

        app('router')
            ->middleware(['web'])
            ->namespace($namespace)
            ->group(__DIR__ . '/../../routes/web.php');
    }

    public function register(): void
    {
        //
    }
}
