@extends ("layouts.app")

@section ("content")
    <h1 class="mb-6">Change Log</h1>

    @foreach ($entries as $entry)
        @if ($entry->details)
            <h2 class="mb-2 font-sans">
                {{ $entry->version }}
                <span class="text-gray-400 font-normal ml-6">
                    {{ $entry->date }}
                </span>
            </h2>
            <div class="rounded-lg bg-white shadow-md overflow-hidden mb-8 p-4  font-sans">
                <div class="changelog-details font-sans">
                    {!! $entry->details !!}
                </div>
            </div>
        @endif
    @endforeach
@endsection
