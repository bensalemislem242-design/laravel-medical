@extends('layout')

@section('content')
<div class="max-w-lg mx-auto p-6 bg-white shadow rounded mt-10">
    <h2 class="text-xl font-bold mb-4">Modifier Status pour le rendez-vous #{{ $appointment->id }}</h2>

    @if ($errors->any())
        <div class="mb-4">
            <ul class="list-disc list-inside text-red-500">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('appointments.updateStatus', $appointment->id) }}" method="POST">
        @csrf

        <div class="mb-4">
            <label for="status" class="block font-medium mb-1">Status</label>
            <select name="status" id="status" class="border p-2 w-full rounded">
                @foreach(['pending','accepted','en_cours','refused'] as $status)
                    <option value="{{ $status }}" {{ $appointment->status === $status ? 'selected' : '' }}>
                        {{ ucfirst($status) }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-4">
            <label for="date" class="block font-medium mb-1">Appointment Date</label>
            <input type="date" name="date" id="date" value="{{ $appointment->appointment_date }}" class="border p-2 w-full rounded">
        </div>

        <div class="mb-4">
            <label for="time" class="block font-medium mb-1">Appointment Time</label>
            <input type="time" name="time" id="time" value="{{ \Carbon\Carbon::parse($appointment->appointment_time)->format('H:i') }}" class="border p-2 w-full rounded">
        </div>

        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Update</button>
        <a href="{{ route('appointments.index') }}" class="ml-2 text-gray-600">Cancel</a>
    </form>
</div>
@endsection
