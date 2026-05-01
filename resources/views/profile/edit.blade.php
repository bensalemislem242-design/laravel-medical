@extends('layout', ['includeNavbar' => true])
@section('title', 'Profile Settings')

@section('content')
<div class="container" style="max-width:600px; margin-top:50px;">
    <h2>Profile Settings</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    {{-- عرض الصورة الحالية --}}
    @if($user->image)
        <div class="text-center mb-3">
            <img src="{{ asset('storage/' . $user->image) }}"
                 alt="Profile Image"
                 style="width:120px; height:120px; border-radius:50%; object-fit:cover;">
        </div>
    @endif

    <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="form-group mb-3">
            <label for="name">First Name</label>
            <input type="text" name="name" class="form-control"
                   value="{{ old('name', $user->name) }}" required>
        </div>

        <div class="form-group mb-3">
            <label for="lastname">Last Name</label>
            <input type="text" name="lastname" class="form-control"
                   value="{{ old('lastname', $user->lastname) }}" required>
        </div>

        <div class="form-group mb-3">
            <label for="email">Email</label>
            <input type="email" name="email" class="form-control"
                   value="{{ old('email', $user->email) }}" required>
        </div>

        <div class="form-group mb-3">
            <label for="password">New Password (optional)</label>
            <input type="password" name="password" class="form-control">
        </div>

        <div class="form-group mb-3">
            <label for="password_confirmation">Confirm New Password</label>
            <input type="password" name="password_confirmation" class="form-control">
        </div>

        {{-- صورة البروفايل --}}
        <div class="form-group mb-3">
            <label for="image">Profile Picture</label>
            <input type="file" name="image" class="form-control">
        </div>

        <button type="submit" class="btn btn-primary w-100">
            Update Profile
        </button>
    </form>
</div>
@endsection
