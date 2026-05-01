@extends('layout') 
@section('title', 'Doctors Management')
@section('header', 'Doctors List')

@section('content')
<div class="card shadow-sm border-0 rounded">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped table-hover align-middle">
                <thead class="thead-light">
                    <tr>
                        <th>Name</th>
                        <th>Specialty</th>
                        <th>Phone</th>
                        <th>Email</th>
                        <th class="text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($doctors as $doctor)
                    <tr>
                        <td>{{ $doctor->name }}</td>
                        <td>{{ $doctor->specialty }}</td>
                        <td>{{ $doctor->phone }}</td>
                        <td>{{ $doctor->email }}</td>
                        <td class="text-center">
                            <a href="{{ route('doctors.show', $doctor) }}" class="btn btn-sm btn-info" title="View">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="{{ route('doctors.edit', $doctor) }}" class="btn btn-sm btn-warning" title="Edit">
                                <i class="fas fa-pen"></i>
                            </a>
                            <form action="{{ route('doctors.destroy', $doctor) }}" method="POST" class="d-inline-block">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" title="Delete"
                                        onclick="return confirm('Are you sure you want to delete this doctor?')">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Floating Add Doctor button -->
        <a href="{{ route('doctors.create') }}" class="btn btn-success rounded-circle shadow-lg"
           style="position: fixed; bottom: 30px; right: 30px; width: 55px; height: 55px; font-size: 24px; display: flex; align-items: center; justify-content: center;"
           title="Add Doctor">
            <i class="fas fa-user-md"></i>
        </a>
    </div>
</div>

<!-- Optional: initialize DataTables if needed -->
<script>
    $(document).ready(function() {
        $('.table').DataTable({
            "paging": true,
            "lengthChange": false,
            "searching": true,
            "ordering": true,
            "info": true,
            "autoWidth": false,
        });
    });
</script>
@endsection