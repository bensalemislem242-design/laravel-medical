@extends('layout')

@section('content')
<div class="container mt-5">
    <h2>Appointment Details</h2>

    <p><strong>Patient:</strong> {{ $appointment->patient->name }}</p>
    <p><strong>Hospital:</strong> {{ $appointment->hospital->name }}</p>
    <p><strong>Doctor:</strong> {{ $appointment->doctor->name }}</p>
    <p><strong>Specialty:</strong> {{ $appointment->doctor->specialty->name ?? 'N/A' }}</p>
    <p><strong>Date:</strong> {{ $appointment->date }}</p>
    <p><strong>Start Time:</strong> {{ $appointment->start_time }}</p>
    <p><strong>End Time:</strong> {{ $appointment->end_time }}</p>
    <p><strong>Motivation:</strong> {{ $appointment->motivation }}</p>

    <a href="{{ route('notifications.index') }}" class="btn btn-primary mt-3">Back to Notifications</a>
</div>
@endsection
