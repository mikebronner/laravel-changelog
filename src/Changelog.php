<?php namespace GeneaLabs\LaravelChangelog;

use Illuminate\Support\Collection;
use Jenssegers\Model\Model;

class Changelog extends Model
{
    protected function getChangelog() : string
    {
        // TODO: make filename a configuration variable
        $changelog = collect(scandir(base_path()))
            ->filter(function ($fileName) {
                return strtolower($fileName) === "changelog.md";
            })
            ->first();

        return file_get_contents(base_path($changelog));
    }

    protected function parseChangelog() : Collection
    {
        $changelog = $this->getChangelog();
        $versions = collect(explode("\n## ", $changelog));
        $versions->shift();

        return $versions
            ->map(function ($entry) {
                $matches = [];
                preg_match("/\[(.*?)\].*?(\d{4}-\d{2}-\d{2})?\n(.*)?/s", $entry, $matches);
                $entry = new Entry;
                $entry->date = $matches[2];
                $entry->version = $matches[1];
                $entry->details = parsedown($matches[3]);

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

    public function getEntriesAttribute() : Collection
    {
        return $this
            ->parseChangelog()
            ->sort(function ($entry1, $entry2) {
                return version_compare($entry1->version, $entry2->version, "<=");
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
