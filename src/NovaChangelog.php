<?php namespace GeneaLabs\LaravelChangelog;

use Laravel\Nova\Nova;
use Laravel\Nova\Tool;

class NovaChangelog extends Tool
{
    /**
     * Perform any tasks that need to happen when the tool is booted.
     *
     * @return void
     */
    public function boot()
    {
        Nova::script('laravel-changelog', __DIR__.'/../dist/js/tool.js');
        Nova::style('laravel-changelog', __DIR__.'/../dist/css/tool.css');
    }

    /**
     * Build the view that renders the navigation links for the tool.
     *
     * @return \Illuminate\View\View
     */
    public function renderNavigation()
    {
        $latestVersion = (new Changelog)->latestVersion;

        return view('laravel-changelog::navigation')
            ->with(compact(
                "latestVersion"
            ));
    }
}
