@extends('layout')
@section('title', 'Edit Doctor')
@section('header', 'Edit Doctor')

@section('content')
    <form action="{{ route('doctors.update', $doctor) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label>Name</label>
            <input type="text" name="name" class="form-control" value="{{ $doctor->name }}" required>
        </div>
        <div class="form-group">
            <label>Specialty</label>
            <input type="text" name="specialty" class="form-control" value="{{ $doctor->specialty }}" required>
        </div>
        <div class="form-group">
            <label>Phone</label>
            <input type="text" name="phone" class="form-control" value="{{ $doctor->phone }}" required>
        </div>
        <div class="form-group">
            <label>Email</label>
            <input type="email" name="email" class="form-control" value="{{ $doctor->email }}" required>
        </div>
        <button class="btn btn-primary mt-3">Update</button>
    </form>
@endsection
