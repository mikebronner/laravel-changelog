<?php namespace GeneaLabs\LaravelChangelog\Http\Controllers\Api;

use Illuminate\Routing\Controller;
use Illuminate\Support\Collection;
use GeneaLabs\LaravelChangelog\Changelog;
use GeneaLabs\LaravelChangelog\Entry;

class ChangelogController extends Controller
{
    public function index() : Collection
    {
        return (new Changelog)
            ->entries;
    }

    public function show(string $version) : Entry
    {
        return (new Changelog)
            ->find($version);
    }
}
