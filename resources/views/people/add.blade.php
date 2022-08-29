@extends('layout')

@section('content')

    <h1 class="text-2xl pb-2">Add new {{ $type->name }} to {{ $person->name }}</h1>
    <hr>

    <div class="py-4">
        {{ $form->generate() }}
    </div>

@endsection
