<?php namespace GeneaLabs\LaravelChangelog;



class Entry extends Model
{
    protected $fillable = [
        "date",
        "details",
        "version",
    ];
}
