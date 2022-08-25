One tree

{{ $tree->name }}

People count {{ count($tree->people) }}

<ul>
    @foreach($tree->people as $person)
        <li>{{ $person->name }} <a href="{{ route('person', ['person' => $person]) }}">GO</a></li>
    @endforeach
</ul>
