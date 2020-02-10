<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('changelog/entries', "ChangelogController@index");
Route::get('changelog/entries/{version}', "ChangelogController@show");
