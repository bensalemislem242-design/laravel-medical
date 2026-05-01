@extends('layout')

@section('title', 'Manage Hospitals')

@section('content')
<h2 class="mb-4">Hospitals List</h2>
<a href="{{ route('hospitals.create') }}" class="btn btn-primary mb-3">Add Hospital</a>

<table class="table table-bordered" id="hospitalsTable">
    <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Address</th>
            <th>Logo</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach($hospitals as $hospital)
            <tr>
                <td>{{ $hospital->id }}</td>
                <td>{{ $hospital->name }}</td>
                <td>{{ $hospital->address }}</td>
                <td>
                    @if($hospital->logo)
                        <img src="{{ asset('storage/hospital_logos/'.$hospital->logo) }}" width="60">
                    @endif
                </td>
                <td>
                    <a href="{{ route('hospitals.edit', $hospital->id) }}" class="btn btn-warning btn-sm">Edit</a>
                    <form action="{{ route('hospitals.destroy', $hospital->id) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger btn-sm" onclick="return confirm('Delete this hospital?')">Delete</button>
                    </form>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
@endsection

@section('scripts')
<script>
    $(document).ready(function () {
        $('#hospitalsTable').DataTable({
            "paging": true,
            "searching": true,
            "info": false
        });
    });
</script>
@endsection
