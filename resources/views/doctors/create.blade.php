@extends('layout') 
@section('title', 'Add Doctor')
@section('header', 'Add New Doctor')

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

        <form action="{{ route('doctors.store') }}" method="POST">
            @csrf
            <div class="form-group mb-3">
                <label for="name">Name</label>
                <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
            </div>
            <div class="mb-3">
    <label>Last Name</label>
    <input type="text" name="lastname" class="form-control" required>
</div>
<div class="mb-3">
    <label>Username</label>
    <input type="text" name="username" class="form-control" required>
</div>

            <div class="form-group mb-3">
                <label for="specialty">Specialty</label>
                <input type="text" name="specialty" class="form-control" value="{{ old('specialty') }}" required>
            </div>

            <div class="form-group mb-3">
                <label for="phone">Phone</label>
                <input type="text" name="phone" class="form-control" value="{{ old('phone') }}" required>
            </div>


            <div class="form-group mb-3">
                <label for="email">Email</label>
                <input type="email" name="email" class="form-control" value="{{ old('email') }}" required>
            </div>

            <button type="submit" class="btn btn-success">Add Doctor</button>
            <a href="{{ route('doctors.index') }}" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</div>
@endsection
