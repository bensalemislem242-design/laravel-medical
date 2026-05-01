@extends('layout')

@section('content')
<div class="container mx-auto p-4">
    <h2 class="text-2xl font-bold mb-4">Update Appointment Status</h2>

    @if(session('success'))
        <div class="bg-green-200 text-green-800 p-2 mb-4 rounded">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('appointments.updateStatus', $appointment->id) }}" method="POST" class="space-y-4">
        @csrf

        <div>
            <label for="status" class="block font-semibold mb-1">Status:</label>
            <select name="status" id="status" class="border p-2 w-full rounded">
                <option value="accepted" {{ $appointment->status == 'accepted' ? 'selected' : '' }}>Accepted</option>
                <option value="en_cours" {{ $appointment->status == 'en_cours' ? 'selected' : '' }}>En cours</option>
                <option value="refused" {{ $appointment->status == 'refused' ? 'selected' : '' }}>Refused</option>
            </select>
            @error('status')
                <span class="text-red-600">{{ $message }}</span>
            @enderror
        </div>

        <div>
            <label for="date" class="block font-semibold mb-1">Appointment Date:</label>
            <input type="date" name="date" id="date" value="{{ $appointment->appointment_date }}" class="border p-2 w-full rounded">
            @error('date')
                <span class="text-red-600">{{ $message }}</span>
            @enderror
        </div>

        <div>
            <label for="time" class="block font-semibold mb-1">Appointment Time:</label>
            <input type="time" name="time" id="time" value="{{ $appointment->appointment_time }}" class="border p-2 w-full rounded">
            @error('time')
                <span class="text-red-600">{{ $message }}</span>
            @enderror
        </div>

        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
            Update Status
        </button>
    </form>
</div>
@endsection
