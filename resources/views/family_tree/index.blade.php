All trees
<ul>
    @foreach($trees as $tree)
        <li>{{ $tree->name }} - <a href="{{ route('family-tree', ['tree' => $tree]) }}">GO</a></li>
    @endforeach
</ul>
