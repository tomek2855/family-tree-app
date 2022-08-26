<a href="{{ route('person', ['person' => $person]) }}">
    {{ $person->name }}
</a>

@if($person->birth_date or $person->death_date)
    ({{ $person->birth_date?->format('d-m-Y') }} - {{ $person->death_date?->format('d-m-Y') }})
@endif

{{ $person->gender->name }}
