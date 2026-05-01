@extends('layout')

@section('title', 'Appointments of ' . $date)

@section('content')

<div class="card p-4 shadow-sm">
    <h4>Appointments for {{ $date }}</h4>

    <table class="table table-bordered mt-3">
        <thead>
            <tr>
                <th>Start</th>
                <th>End</th>
                <th>Doctor</th>
                <th>Motivation</th>
            </tr>
        </thead>
        <tbody>
            @foreach($appointments as $appointment)
            <tr>
                <td>{{ $appointment->start_time }}</td>
                <td>{{ $appointment->end_time }}</td>
                <td>{{ $appointment->doctor?->name ?? 'No Doctor' }}</td>
                <td>{{ $appointment->motivation }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

</div>

@endsection
