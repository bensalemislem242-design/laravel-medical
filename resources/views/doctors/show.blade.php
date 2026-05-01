@extends('layout') 
@section('title', 'Doctor Details')
@section('header', 'Doctor Details')

@section('content')
<div class="card shadow-sm border-0 rounded">
    <div class="card-body">
        <table class="table table-bordered">
            <tr>
                <th>Name</th>
                <td>{{ $doctor->name }}</td>
            </tr>
            <tr>
                <th>Specialty</th>
                <td>{{ $doctor->specialty }}</td>
            </tr>
            <tr>
                <th>Phone</th>
                <td>{{ $doctor->phone }}</td>
            </tr>
            <tr>
                <th>Email</th>
                <td>{{ $doctor->email }}</td>
            </tr>
        </table>

        <a href="{{ route('doctors.edit', $doctor->id) }}" class="btn btn-warning">Edit</a>
        <a href="{{ route('doctors.index') }}" class="btn btn-secondary">Back to List</a>
    </div>
</div>
@endsection
