@extends('layout')

@section('content')

    <h1 class="text-2xl pb-2">All family trees</h1>
    <hr>

    <div class="py-4">
        <ul>
            @foreach($trees as $tree)
                <li>
                    #{{ $tree->id }} -
                    <a href="{{ route('family-tree', ['tree' => $tree]) }}">{{ $tree->name }}</a>
                </li>
            @endforeach
        </ul>
    </div>

@endsection
