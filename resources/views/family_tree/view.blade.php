@extends('layout')

@section('content')

    <h1 class="text-2xl pb-2">{{ $tree->name }}</h1>
    <hr>

    <div class="py-4">
        <ol class="list-decimal list-inside">
            @foreach($tree->people as $person)
                @include('people.person-list-item', ['person' => $person])
            @endforeach
        </ol>
    </div>

@endsection
