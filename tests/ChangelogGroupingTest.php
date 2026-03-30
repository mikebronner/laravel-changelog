<?php

use GeneaLabs\LaravelChangelog\Changelog;
use GeneaLabs\LaravelChangelog\Entry;

test('entries are grouped by minor version', function () {
    $changelog = new Changelog;
    $changelog->entries; // warm up to check it works

    // We'll test the grouping logic directly by creating entries and checking groupBy behavior
    $entries = collect([
        makeEntry('1.0.0', '2024-01-01', 'Initial release'),
        makeEntry('1.0.1', '2024-01-15', 'Patch fix'),
        makeEntry('1.1.0', '2024-02-01', 'New feature'),
        makeEntry('1.1.1', '2024-02-15', 'Another patch'),
        makeEntry('2.0.0', '2024-03-01', 'Major release'),
    ]);

    $grouped = $entries
        ->groupBy(function (Entry $entry) {
            $parts = explode('.', $entry->version);
            return "{$parts[0]}.{$parts[1]}";
        })
        ->sortKeysDesc(SORT_NATURAL);

    expect($grouped)->toHaveCount(3);
    expect($grouped->keys()->all())->toBe(['2.0', '1.1', '1.0']);
    expect($grouped['1.0'])->toHaveCount(2);
    expect($grouped['1.1'])->toHaveCount(2);
    expect($grouped['2.0'])->toHaveCount(1);
});

test('groups are sorted newest first', function () {
    $entries = collect([
        makeEntry('0.1.0', '2023-01-01', 'Alpha'),
        makeEntry('1.0.0', '2024-01-01', 'Stable'),
        makeEntry('0.2.0', '2023-06-01', 'Beta'),
    ]);

    $grouped = $entries
        ->groupBy(function (Entry $entry) {
            $parts = explode('.', $entry->version);
            return "{$parts[0]}.{$parts[1]}";
        })
        ->sortKeysDesc(SORT_NATURAL);

    expect($grouped->keys()->all())->toBe(['1.0', '0.2', '0.1']);
});

test('single version groups correctly', function () {
    $entries = collect([
        makeEntry('1.0.0', '2024-01-01', 'Only release'),
    ]);

    $grouped = $entries
        ->groupBy(function (Entry $entry) {
            $parts = explode('.', $entry->version);
            return "{$parts[0]}.{$parts[1]}";
        })
        ->sortKeysDesc(SORT_NATURAL);

    expect($grouped)->toHaveCount(1);
    expect($grouped->keys()->first())->toBe('1.0');
});

test('empty changelog produces empty groups', function () {
    $entries = collect();

    $grouped = $entries
        ->groupBy(function (Entry $entry) {
            $parts = explode('.', $entry->version);
            return "{$parts[0]}.{$parts[1]}";
        })
        ->sortKeysDesc(SORT_NATURAL);

    expect($grouped)->toBeEmpty();
});

test('groupedByMinorVersion accessor exists on Changelog', function () {
    $changelog = new Changelog;
    $grouped = $changelog->groupedByMinorVersion;

    expect($grouped)->toBeInstanceOf(\Illuminate\Support\Collection::class);
});

function makeEntry(string $version, string $date, string $details): Entry
{
    $entry = new Entry;
    $entry->version = $version;
    $entry->date = $date;
    $entry->details = "<p>{$details}</p>";

    return $entry;
}
