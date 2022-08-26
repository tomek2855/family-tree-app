<ul class="list-disc list-inside descendants-list">
    @foreach($people as $person)
        <li class="list-item">
            @include('people.person-details', ['person' => $person])

            @if(count($person->children()))

                @include('people.person-descendants', ['people' => $person->children()])

            @endif
        </li>
    @endforeach
</ul>
