@extends('layout')

@section('content')

    <h1 class="text-2xl pb-2">{{ $person->name }}</h1>
    @if($person->birth_date or $person->death_date)
        ({{ $person->birth_date?->format('d-m-Y') }} - {{ $person->death_date?->format('d-m-Y') }})
    @endif

    {{ $person->gender->name }}
    <hr>

    @if ($partner)
        <div class="py-4">
            <span class="text-green-700">Partner - </span>
            @include('people.person-details', ['person' => $partner])
        </div>

        <hr>
    @endif

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

    <div class="py-4 flex flex-row gap-4">
        @if (!$person->getPartner())
            <a href="{{ route('add-person', ['person' => $person, 'type' => \App\Enums\AddPersonToRelationshipType::partner->name]) }}" class="bg-green-500 text-white rounded py-2 px-4">
                Add partner
            </a>
        @endif

        <a href="{{ route('add-person', ['person' => $person, 'type' => \App\Enums\AddPersonToRelationshipType::child->name]) }}" class="bg-yellow-500 text-white rounded py-2 px-4">
            Add child
        </a>

        @if (!$person->getParents() || count($person->getParents()) < 2)
            <a href="{{ route('add-person', ['person' => $person, 'type' => \App\Enums\AddPersonToRelationshipType::parent->name]) }}" class="bg-orange-500 text-white rounded py-2 px-4">
                Add parent
            </a>
        @endif
    </div>

@endsection
