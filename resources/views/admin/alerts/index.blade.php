<!-- resources/views/admin/alerts/index.blade.php -->

@extends('layout')

@section('title', 'Alerts')

@section('content')
    <div class="container">
        <h1>Alerts List</h1>
        @if(count($alerts) > 0)
            <ul>
                @foreach($alerts as $alert)
                    <li>{{ $alert }}</li>
                @endforeach
            </ul>
        @else
            <p>No alerts available.</p>
        @endif
    </div>
@endsection
