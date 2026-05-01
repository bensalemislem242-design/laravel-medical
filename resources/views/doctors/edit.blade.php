@extends('layout') 
@section('title', 'Edit Doctor')
@section('header', 'Edit Doctor')

@section('content')
<div class="card shadow-sm border-0 rounded">
    <div class="card-body">
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('doctors.update', $doctor->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group mb-3">
                <label for="name">Name</label>
                <input type="text" name="name" class="form-control" value="{{ old('name', $doctor->name) }}" required>
            </div>

            <div class="form-group mb-3">
                <label for="specialty">Specialty</label>
                <input type="text" name="specialty" class="form-control" value="{{ old('specialty', $doctor->specialty) }}" required>
            </div>

            <div class="form-group mb-3">
                <label for="phone">Phone</label>
                <input type="text" name="phone" class="form-control" value="{{ old('phone', $doctor->phone) }}" required>
            </div>

            <div class="form-group mb-3">
                <label for="email">Email</label>
                <input type="email" name="email" class="form-control" value="{{ old('email', $doctor->email) }}" required>
            </div>

            <button type="submit" class="btn btn-warning">Update Doctor</button>
            <a href="{{ route('doctors.index') }}" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</div>
@endsection
