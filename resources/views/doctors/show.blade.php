@extends('layout')
@section('title', 'Doctor Details')
@section('header', 'Doctor Details')

@section('content')
    <div class="card">
        <div class="card-body">
            <p><strong>Name:</strong> {{ $doctor->name }} {{ $doctor->lastname ?? '' }}</p>
            <p><strong>Specialty:</strong> {{ $doctor->specialty ?? 'N/A' }}</p>
            <p><strong>Phone:</strong> {{ $doctor->phone ?? 'N/A' }}</p>
            <p><strong>Email:</strong> {{ $doctor->email }}</p>
            <a href="{{ route('doctors.index') }}" class="btn btn-secondary mt-3">Back</a>
        </div>
    </div>
@endsection
