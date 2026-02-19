@extends('layout')
@section('title', 'Add Doctor')
@section('header', 'Add New Doctor')

@section('content')
    <form action="{{ route('doctors.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label>Name</label>
            <input type="text" name="name" class="form-control" required>
        </div>
        <div class="form-group">
            <label>Specialty</label>
            <input type="text" name="specialty" class="form-control" required>
        </div>
        <div class="form-group">
            <label>Phone</label>
            <input type="text" name="phone" class="form-control" required>
        </div>
        <div class="form-group">
            <label>Email</label>
            <input type="email" name="email" class="form-control" required>
        </div>
        <button class="btn btn-primary mt-3">Save</button>
    </form>
@endsection
