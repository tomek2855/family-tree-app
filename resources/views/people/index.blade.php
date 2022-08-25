Zstępni: {{ $person->name }}

@if ($youngestPerson)
    Najmłodsza osoba: {{ $youngestPerson->name }}
@endif

@include('people.people', ['people' => $person->children()])
