<?php

use GeneaLabs\LaravelChangelog\Http\Livewire\ChangelogPage;
use Livewire\Livewire;

test('changelog page component renders', function () {
    Livewire::test(ChangelogPage::class)
        ->assertOk();
});

test('changelog page mounts with focus minor version', function () {
    $component = Livewire::test(ChangelogPage::class, [
        'major' => '1',
        'minor' => '0',
    ]);

    $component->assertOk();
    expect($component->get('focusMinor'))->toBe('1.0');
});

test('toggle group expands collapsed group', function () {
    $component = Livewire::test(ChangelogPage::class);

    // All groups except the first should be collapsed
    // Toggle a collapsed group to expand it
    $component->call('toggleGroup', '0.0');
    expect($component->get('expandedGroups'))->toHaveKey('0.0');
});

test('toggle group collapses expanded group', function () {
    $component = Livewire::test(ChangelogPage::class);

    // Expand then collapse
    $component->call('toggleGroup', 'test.group');
    expect($component->get('expandedGroups'))->toHaveKey('test.group');

    $component->call('toggleGroup', 'test.group');
    expect($component->get('expandedGroups'))->not->toHaveKey('test.group');
});

test('load more entries increments page for group', function () {
    $component = Livewire::test(ChangelogPage::class);

    $component->call('loadMoreEntries', '1.0');

    expect($component->get('groupPages.1.0') ?? $component->get('groupPages')['1.0'] ?? null)->toBe(2);
});

test('component renders with no changelog', function () {
    // No CHANGELOG.md in base_path — should render empty state
    Livewire::test(ChangelogPage::class)
        ->assertOk();
});

test('per page defaults to 10', function () {
    $component = Livewire::test(ChangelogPage::class);

    expect($component->get('perPage'))->toBe(10);
});
