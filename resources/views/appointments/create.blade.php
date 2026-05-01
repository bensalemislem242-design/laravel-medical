@extends('layout')
@section('title', 'Add Appointment')
@section('header', 'Add New Appointment')

@section('content')
<div class="card shadow-sm border-0 rounded">
    <div class="card-body">
        <form action="{{ route('appointments.store') }}" method="POST">
            @csrf

            <div class="form-group mb-3">
                <label for="date">Date</label>
                <input type="date" name="date" id="date" class="form-control" 
                       value="{{ old('date') }}" required>
            </div>

            <div class="form-group mb-3">
                <label for="start_time">Start Time</label>
                <input type="time" name="start_time" id="start_time" class="form-control" 
                       value="{{ old('start_time') }}" required>
            </div>

            <div class="form-group mb-3">
                <label for="end_time">End Time</label>
                <input type="time" name="end_time" id="end_time" class="form-control" 
                       value="{{ old('end_time') }}" required>
            </div>

            <div class="form-group mb-3">
                <label for="doctor_id">Doctor</label>
                <select name="doctor_id" id="doctor_id" class="form-control" required>
                    <option value="">-- Select Doctor --</option>
                    @foreach($doctors as $doctor)
                        <option value="{{ $doctor->id }}" 
                            {{ old('doctor_id') == $doctor->id ? 'selected' : '' }}>
                            {{ $doctor->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group mb-3">
                <label for="motivation">Motivation</label>
                <textarea name="motivation" id="motivation" class="form-control" 
                          rows="3">{{ old('motivation') }}</textarea>
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
            <button type="submit" class="btn btn-success">Add Appointment</button>
            <a href="{{ route('appointments.index') }}" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</div>
@endsection
