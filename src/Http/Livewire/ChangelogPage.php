<?php

declare(strict_types=1);

namespace GeneaLabs\LaravelChangelog\Http\Livewire;

use GeneaLabs\LaravelChangelog\Changelog;
use Illuminate\Support\Collection;
use Livewire\Component;

class ChangelogPage extends Component
{
    public array $expandedGroups = [];

    public ?string $focusMinor = null;

    public int $perPage = 10;

    /** @var array<string, int> */
    public array $groupPages = [];

    public function mount(?string $major = null, ?string $minor = null): void
    {
        $groups = (new Changelog)->groupedByMinorVersion;

        if ($major !== null && $minor !== null) {
            $this->focusMinor = "{$major}.{$minor}";
        }

        $firstKey = $groups->keys()->first();

        foreach ($groups->keys() as $key) {
            if ($key === $firstKey || $key === $this->focusMinor) {
                $this->expandedGroups[$key] = true;
            }

            $this->groupPages[$key] = 1;
        }
    }

    public function toggleGroup(string $minorVersion): void
    {
        if (isset($this->expandedGroups[$minorVersion])) {
            unset($this->expandedGroups[$minorVersion]);
        } else {
            $this->expandedGroups[$minorVersion] = true;
        }
    }

    public function loadMoreEntries(string $minorVersion): void
    {
        $this->groupPages[$minorVersion] = ($this->groupPages[$minorVersion] ?? 1) + 1;
    }

    public function render()
    {
        $groups = (new Changelog)->groupedByMinorVersion;

        $paginatedGroups = $groups->map(function (Collection $entries, string $key) {
            $page = $this->groupPages[$key] ?? 1;
            $total = $entries->count();
            $visible = $entries->take($page * $this->perPage);

            return (object) [
                'entries' => $visible,
                'total' => $total,
                'hasMore' => $visible->count() < $total,
            ];
        });

        return view('laravel-changelog::livewire.changelog-page', [
            'groups' => $paginatedGroups,
        ]);
    }
}
