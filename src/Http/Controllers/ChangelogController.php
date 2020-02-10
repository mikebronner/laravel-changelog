<?php namespace GeneaLabs\LaravelChangelog\Http\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Support\Collection;
use GeneaLabs\LaravelChangelog\Changelog;
use GeneaLabs\LaravelChangelog\Entry;
use Illuminate\View\View;

class ChangelogController extends Controller
{
    public function index() : View
    {
        $entries = (new Changelog)->entries;

        return view("laravel-changelog::changelog")
            ->with(compact("entries"));
        // return (new Changelog)
        //     ->entries;
    }

    public function show(string $version) : Entry
    {
        return (new Changelog)
            ->find($version);
    }
}
