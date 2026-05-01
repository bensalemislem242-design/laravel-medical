@extends('layout')

@section('title', 'Edit Hospital')

@section('content')
<h2 class="mb-4">Edit Hospital</h2>
<form action="{{ route('hospitals.update', $hospital->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <div class="mb-3">
        <label>Name</label>
        <input type="text" name="name" class="form-control" value="{{ $hospital->name }}" required>
    </div>
    <div class="mb-3">
        <label>Address</label>
        <input type="text" name="address" class="form-control" value="{{ $hospital->address }}" required>
    </div>
    <div class="mb-3">
        <label>Logo</label>
        <input type="file" name="logo" class="form-control" id="logoInput">
        <div class="mt-2">
            @if($hospital->logo)
                <img id="logoPreview" src="{{ asset('storage/hospital_logos/'.$hospital->logo) }}" width="100" style="border-radius: 8px;">
            @else
                <img id="logoPreview" width="100" style="display:none; border-radius: 8px;">
            @endif
        </div>
    </div>
    <button class="btn btn-success">Update</button>
    <a href="{{ route('hospitals.index') }}" class="btn btn-secondary">Cancel</a>
</form>
@endsection

@section('scripts')
<script>
    document.getElementById('logoInput').addEventListener('change', function(event){
        let reader = new FileReader();
        reader.onload = function(){
            let img = document.getElementById('logoPreview');
            img.src = reader.result;
            img.style.display = 'block';
        }
        reader.readAsDataURL(event.target.files[0]);
    });
</script>
@endsection
