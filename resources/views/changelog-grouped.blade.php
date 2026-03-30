@extends ('layouts.app')

@section ('content')
    <livewire:changelog-page
        :major="$major ?? null"
        :minor="$minor ?? null"
    />
@endsection
