@extends('layout')
@section('title', 'Doctors Management')
@section('header', 'Doctors List')

@section('content')
    <div class="card">
        <div class="card-body">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Specialty</th>
                        <th>Phone</th>
                        <th>Email</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($doctors as $doctor)
                    <tr>
                        <td>{{ $doctor->name }}</td>
                        <td>{{ $doctor->specialty }}</td>
                        <td>{{ $doctor->phone }}</td>
                        <td>{{ $doctor->email }}</td>
                        <td>
                            <a href="{{ route('doctors.show', $doctor) }}" class="btn btn-info"><i class="fas fa-eye"></i></a>
                            <a href="{{ route('doctors.edit', $doctor) }}" class="btn btn-warning"><i class="fas fa-pen"></i></a>
                            <form action="{{ route('doctors.destroy', $doctor) }}" method="POST" style="display:inline-block;">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger" onclick="return confirm('Are you sure?')">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <a href="{{ route('doctors.create') }}" class="btn btn-success mt-3"><i class="fas fa-user-md"></i> Add Doctor</a>
        </div>
    </div>
@endsection
