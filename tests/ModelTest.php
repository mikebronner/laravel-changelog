<?php

use GeneaLabs\LaravelChangelog\Entry;
use GeneaLabs\LaravelChangelog\Changelog;

test('entry can set and get attributes', function () {
    $entry = new Entry;
    $entry->version = '1.0.0';
    $entry->date = '2024-01-01';
    $entry->details = '<p>Test</p>';

    expect($entry->version)->toBe('1.0.0');
    expect($entry->date)->toBe('2024-01-01');
    expect($entry->details)->toBe('<p>Test</p>');
});

test('entry can be converted to array', function () {
    $entry = new Entry;
    $entry->version = '1.0.0';
    $entry->date = '2024-01-01';

    $array = $entry->toArray();

    expect($array)->toHaveKey('version', '1.0.0');
    expect($array)->toHaveKey('date', '2024-01-01');
});

test('entry can be json serialized', function () {
    $entry = new Entry;
    $entry->version = '2.0.0';

    $json = json_encode($entry);

    expect($json)->toContain('2.0.0');
});

test('changelog can be instantiated', function () {
    $changelog = new Changelog;

    expect($changelog)->toBeInstanceOf(Changelog::class);
});
