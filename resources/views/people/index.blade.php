@extends('layout')

@section('content')

    <h1 class="text-2xl pb-2">{{ $person->name }}</h1>
    <hr>

    @if ($youngestPerson)
        <div class="py-4">
            <span class="text-green-700">Youngest descendant - </span>
            @include('people.person-details', ['person' => $youngestPerson])
        </div>

        <hr>
    @endif

    @if (count($person->children()))
        <div class="py-4">
            <span class="text-green-700">All descendants</span>

            @include('people.person-descendants', ['people' => $person->children()])
        </div>
    @endif

@endsection
