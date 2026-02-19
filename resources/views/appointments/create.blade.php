@extends('layout')

@section('content')
<div class="container">
    <h2>Create Appointment</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

           </select>
       <form action="{{ route('appointments.store') }}" method="POST">
    @csrf

    <input type="text" name="motivation" placeholder="Motivation" required>
    <input type="date" name="date" required>
    <input type="time" name="start_time" required>
    <input type="time" name="end_time" required>

    <select name="doctor_id" required>
    <div class="form-group">
    <label for="doctor_id">Doctor</label>

    <select name="doctor_id" class="form-control" required>
        <option value="">-- Select Doctor --</option>

        @foreach($doctors as $doctor)
            <option value="{{ $doctor->id }}">
                {{ $doctor->name }} {{ $doctor->lastname }}
            </option>
        @endforeach

    </select>
</div>


    <select name="patient_id" required>
        <option value="">-- Choose Patient --</option>
        @foreach($patients as $patient)
            <option value="{{ $patient->id }}">{{ $patient->name }} {{ $patient->lastname }}</option>
        @endforeach
    </select>

    <button type="submit">Create Appointment</button>
</form>

</div>
@endsection
