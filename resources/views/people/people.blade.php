<ul>
    @foreach($people as $person)
        <li>
            {{ $person->name }}

            @if(count($person->children()))

                @include('people.people', ['people' => $person->children()])

            @endif
        </li>
    @endforeach
</ul>
