<?php

declare(strict_types=1);

namespace GeneaLabs\LaravelChangelog;

use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Jenssegers\Model\Model;

class Changelog extends Model
{
    protected string $fileName = "CHANGELOG.md";

    protected function getChangelog() : string
    {
        $changelog = collect(scandir(base_path()))
            ->reject(function ($path): bool {
                return is_dir($path);
            })
            ->filter(function ($existingFileName): bool {
                return Str::lower($existingFileName) === Str::lower($this->fileName);
            })
            ->first();

        if (! $changelog) {
            return "";
        }

        return file_get_contents(base_path($changelog));
    }

    protected function parseChangelog() : Collection
    {
        $changelog = $this->getChangelog();
        $versions = collect(explode("\n## ", $changelog));
        $versions->shift();

        return $versions
            ->reject(function ($entry): bool {
                return Str::startsWith($entry, "Unreleased");
            })
            ->map(function ($entry): Entry {
                $matches = [];
                preg_match("/\[(.*?)\].*?(\d{4}-\d{2}-\d{2})?\n(.*)?/s", $entry, $matches);
                $entry = new Entry;
                $entry->date = data_get($matches, 2)
                    ?? "";
                $entry->version = data_get($matches, 1)
                    ?? "";
                $entry->details = Str::markdown(data_get($matches, 3) ?? "");

                return $entry;
            });
    }

    public function find(string $version) : Entry
    {
        return $this
            ->entries
            ->filter(function ($entry) use ($version) {
                return version_compare($entry->version, $version, "==");
            })
            ->first();
    }

    public function load(?string $filename = "CHANGELOG.md"): self
    {
        $this->fileName = $filename;

        return $this;
    }

    public function getEntriesAttribute() : Collection
    {
        return $this
            ->parseChangelog()
            ->sort(function ($entry1, $entry2) {
                return version_compare($entry1->version, $entry2->version, ">")
                    ? -1
                    : 1;
            })
            ->values();
    }

    public function getLatestVersionEntryAttribute() : Entry
    {
        return $this
            ->entries
            ->filter(function ($entry) {
                return version_compare($entry->version, "0.0.1", ">=") >= 0
                    && $entry->date;
            })
            ->first();
    }
}
