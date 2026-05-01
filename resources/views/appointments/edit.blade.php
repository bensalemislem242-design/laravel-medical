@extends('layout')
@section('title', 'Edit Appointment')
@section('header', 'Edit Appointment')

@section('content')
<div class="card shadow-sm border-0 rounded">
    <div class="card-body" style="max-width:600px; margin:auto;">

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('appointments.update', $appointment->id) }}" method="POST">
            @csrf
            @method('PUT') <!-- مهم جدًا لتحديث -->
        <div class="form-group">
    <label for="hospital_id">Hospital</label>
    <select name="hospital_id" id="hospital_id" class="form-control" required>
        <option value="">--Select Hospital--</option>
        @foreach($hospitals as $hospital)
            <option value="{{ $hospital->id }}" {{ $appointment->hospital_id == $hospital->id ? 'selected' : '' }}>
                {{ $hospital->name }}
            </option>
        @endforeach
    </select>
</div>

            <!-- Patient select -->
            <div class="form-group mb-3">
                <label for="patient_id">Patient</label>
                <select name="patient_id" id="patient_id" class="form-control" required>
                    <option value="">--Select Patient--</option>
                    @foreach($patients as $patient)
                        <option value="{{ $patient->id }}" {{ $appointment->patient_id == $patient->id ? 'selected' : '' }}>
                            {{ $patient->name }} {{ $patient->lastname }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Doctor select -->
            <div class="form-group mb-3">
                <label for="doctor_id">Doctor</label>
                <select name="doctor_id" id="doctor_id" class="form-control" required>
                    <option value="">--Select Doctor--</option>
                    @foreach($doctors as $doctor)
                        <option value="{{ $doctor->id }}" {{ $appointment->doctor_id == $doctor->id ? 'selected' : '' }}>
                            {{ $doctor->name }} {{ $doctor->lastname }}
                        </option>
                    @endforeach
                </select>
            </div>


            <!-- Date -->
            <div class="form-group mb-3">
                <label for="date">Date</label>
                <input type="date" name="date" id="date" class="form-control" value="{{ $appointment->date }}" required>
            </div>

            <!-- Start Time -->
            <div class="form-group mb-3">
                <label for="start_time">Start Time</label>
                <input type="time" name="start_time" id="start_time" class="form-control" value="{{ $appointment->start_time }}" required>
            </div>

            <!-- End Time -->
            <div class="form-group mb-3">
                <label for="end_time">End Time</label>
                <input type="time" name="end_time" id="end_time" class="form-control" value="{{ $appointment->end_time }}" required>
            </div>

            <!-- Motivation -->
            <div class="form-group mb-3">
                <label for="motivation">Motivation</label>
                <textarea name="motivation" id="motivation" class="form-control" rows="3" required>{{ $appointment->motivation }}</textarea>
            </div>
            <!--  status -->
            <div class="form-group">
                <label for="status">Status</label>
                <select name="status" id="status" class="form-control">
                    <option value="Pending" {{ old('status', $appointment->status ?? '') == 'Pending' ? 'selected' : '' }}>Pending</option>
                    <option value="Confirmed" {{ old('status', $appointment->status ?? '') == 'Confirmed' ? 'selected' : '' }}>Confirmed</option>
                    <option value="Canceled" {{ old('status', $appointment->status ?? '') == 'Canceled' ? 'selected' : '' }}>Canceled</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Update Appointment</button>
            <a href="{{ route('appointments.index') }}" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</div>
@endsection
