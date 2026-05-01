@extends('layout')
@section('title', 'Users Management')
@section('header', 'Users List')

@section('content')
<div class="card shadow-sm border-0 rounded">
    <div class="card-body">
        <div class="table-responsive">
            <table id="users_table" class="table table-striped table-hover align-middle">
                <thead class="thead-light">
                    <tr>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Username</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th class="text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                    <tr>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->lastname }}</td>
                        <td>{{ $user->username }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->role->name }}</td>
                        <td class="text-center">
                            <a href="{{ route('users.edit', $user) }}" class="btn btn-sm btn-warning" title="Edit">
                                <i class="fas fa-user-edit"></i>
                            </a>
                            <form method="POST" action="{{ route('users.destroy', $user) }}" class="d-inline-block">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')" title="Delete">
                                    <i class="fas fa-user-times"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Floating Add User button -->
        <a href="#" class="btn btn-success rounded-circle shadow-lg"
           style="position: fixed; bottom: 30px; right: 30px; width: 55px; height: 55px; font-size: 24px; display: flex; align-items: center; justify-content: center;"
           data-toggle="modal" data-target="#addUser" title="Add User">
            <i class="fas fa-user-plus"></i>
        </a>
    </div>
</div>

@include('modals._add_user')

<script>
    $(document).ready(function() {
        $('#users_table').DataTable({
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