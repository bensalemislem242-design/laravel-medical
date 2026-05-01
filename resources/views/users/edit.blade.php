@extends('layout')
@section('title', 'Update user: ' . $user->username)
@section('header', 'Update user: ' . $user->name . ' ' . $user->lastname)

@section('content')
<div class="card shadow-sm border-0 rounded">
    <div class="card-body">
        <form method="POST" action="{{ route('users.update', $user) }}" novalidate>
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="name">First Name</label>
                <input id="name" name="name" type="text"
                    class="form-control @error('name') is-invalid @enderror"
                    value="{{ old('name', $user->name) }}" required>
                @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="lastname">Last Name</label>
                <input id="lastname" name="lastname" type="text"
                    class="form-control @error('lastname') is-invalid @enderror"
                    value="{{ old('lastname', $user->lastname) }}" required>
                @error('lastname')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="username">Username</label>
                <input id="username" name="username" type="text"
                    class="form-control @error('username') is-invalid @enderror"
                    value="{{ old('username', $user->username) }}" required>
                @error('username')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="email">Email</label>
                <input id="email" name="email" type="email"
                    class="form-control @error('email') is-invalid @enderror"
                    value="{{ old('email', $user->email) }}" required>
                @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="role">User Role</label>
                <select id="role" name="role"
                        class="form-control @error('role') is-invalid @enderror" required>
                    @foreach (App\Enums\UserRoles::values() as $key => $value)
                        <option value="{{ $value }}" @if ($value == $user->role->value) selected @endif>
                            {{ $key }}
                        </option>
                    @endforeach
                </select>
                @error('role')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group mt-3">
                <button type="submit" class="btn btn-primary btn-block">
                    Update User
                </button>
            </div>
        </form>
    </div>
</div>
@endsection