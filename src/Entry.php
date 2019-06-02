<?php namespace GeneaLabs\LaravelChangelog;

use Jenssegers\Model\Model;

class Entry extends Model
{
    protected $fillable = [
        "date",
        "details",
        "version",
    ];
}
