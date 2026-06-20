<?php

declare(strict_types=1);

namespace GeneaLabs\LaravelChangelog\Http\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\View\View;

class ChangelogController extends Controller
{
    public function index(): View
    {
        return view('laravel-changelog::changelog-grouped');
    }

    public function showMinorVersion(string $major, string $minor): View
    {
        return view('laravel-changelog::changelog-grouped', [
            'major' => $major,
            'minor' => $minor,
        ]);
    }
}
