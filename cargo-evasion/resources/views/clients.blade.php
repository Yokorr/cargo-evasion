@extends('layouts.app')

@section('content')
    <h1>Liste des clients</h1>

    <ul>
        @foreach ($clients as $client)
            <li>{{ $client }}</li>
        @endforeach
    </ul>
@endsection
