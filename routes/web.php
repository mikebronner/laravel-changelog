<?php

use Illuminate\Support\Facades\Route;

Route::get('changelog/entries', 'ChangelogController@index');
Route::get('changelog/entries/{version}', 'ChangelogController@show');
Route::get('changelog', 'ChangelogController@index');
Route::get('changelog/{major}.{minor}', 'ChangelogController@showMinorVersion')
    ->where(['major' => '[0-9]+', 'minor' => '[0-9]+']);
