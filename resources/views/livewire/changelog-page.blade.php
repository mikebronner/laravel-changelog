<div>
    <h1 class="mb-6 text-2xl font-bold">Change Log</h1>

    @forelse ($groups as $minorVersion => $group)
        <div
            class="mb-4"
            @if ($minorVersion === $focusMinor)
                id="minor-{{ str_replace('.', '-', $minorVersion) }}"
                x-init="$el.scrollIntoView({ behavior: 'smooth' })"
            @else
                id="minor-{{ str_replace('.', '-', $minorVersion) }}"
            @endif
        >
            <button
                wire:click="toggleGroup('{{ $minorVersion }}')"
                class="flex w-full items-center justify-between rounded-lg bg-gray-100 px-4 py-3 text-left font-semibold text-gray-800 hover:bg-gray-200 transition-colors"
                type="button"
            >
                <span>v{{ $minorVersion }}.x <span class="ml-2 text-sm font-normal text-gray-500">({{ $group->total }} {{ Str::plural('release', $group->total) }})</span></span>
                <svg
                    class="h-5 w-5 transform transition-transform {{ isset($expandedGroups[$minorVersion]) ? 'rotate-180' : '' }}"
                    fill="none" stroke="currentColor" viewBox="0 0 24 24"
                >
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                </svg>
            </button>

            @if (isset($expandedGroups[$minorVersion]))
                <div class="mt-2 space-y-4">
                    @foreach ($group->entries as $entry)
                        @if ($entry->details)
                            <div>
                                <h2 class="mb-2 font-sans text-lg">
                                    {{ $entry->version }}
                                    <span class="ml-6 font-normal text-gray-400">
                                        {{ $entry->date }}
                                    </span>
                                </h2>
                                <div class="mb-4 overflow-hidden rounded-lg bg-white p-4 shadow-md font-sans">
                                    <div class="changelog-details font-sans">
                                        {!! $entry->details !!}
                                    </div>
                                </div>
                            </div>
                        @endif
                    @endforeach

                    @if ($group->hasMore)
                        <div class="text-center">
                            <button
                                wire:click="loadMoreEntries('{{ $minorVersion }}')"
                                class="rounded-md bg-gray-200 px-4 py-2 text-sm text-gray-700 hover:bg-gray-300 transition-colors"
                                type="button"
                            >
                                Load more entries
                            </button>
                        </div>
                    @endif
                </div>
            @endif
        </div>
    @empty
        <p class="text-gray-500">No changelog entries found.</p>
    @endforelse
</div>
