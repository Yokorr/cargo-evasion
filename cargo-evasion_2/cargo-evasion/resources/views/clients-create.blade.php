@extends('layouts.app')

@section('content')
    <h1>Ajouter un client</h1>

    <form method="POST" action="/clients">
        @csrf

        <label>
            Nom du client :
            <input type="text" name="name">
        </label>

        <br><br>

        <button type="submit">Ajouter</button>
    </form>
@endsection
