<?php namespace GeneaLabs\LaravelChangelog\Providers;

use GeneaLabs\LaravelChangelog\Http\Middleware\Authorize;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Laravel\Nova\Events\ServingNova;
use Laravel\Nova\Nova;

class Tool extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadViewsFrom(__DIR__.'/../../resources/views', 'laravel-changelog');

        $this->app->booted(function () {
            $this->routes();
        });

        Nova::serving(function (ServingNova $event) {
            //
        });
    }

    /**
     * Register the tool's routes.
     *
     * @return void
     */
    protected function routes()
    {
        $namespace = 'GeneaLabs\LaravelChangelog\Http\Controllers';
        // if ($this->app->routesAreCached()) {
        //     return;
        // }

        // Route::middleware(['nova', Authorize::class])
        Route::middleware([])
            ->prefix('genealabs/laravel-changelog/api')
            ->namespace($namespace . "\Api")
            ->group(__DIR__ . '/../../routes/api.php');
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
