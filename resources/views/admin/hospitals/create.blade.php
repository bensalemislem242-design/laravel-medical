@extends('layout')

@section('title', 'Add Hospital')

@section('content')
<h2 class="mb-4">Add Hospital</h2>
<form action="{{ route('hospitals.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="mb-3">
        <label>Name</label>
        <input type="text" name="name" class="form-control" required>
    </div>
    <div class="mb-3">
        <label>Address</label>
        <input type="text" name="address" class="form-control" required>
    </div>
    <div class="mb-3">
        <label>Logo</label>
        <input type="file" name="logo" class="form-control" id="logoInput">
        <div class="mt-2">
            <img id="logoPreview" width="100" style="display:none; border-radius: 8px;">
        </div>
    </div>
    <button class="btn btn-success">Save</button>
    <a href="{{ route('hospitals.index') }}" class="btn btn-secondary">Cancel</a>
</form>
@endsection

@section('scripts')
<script>
    // Preview logo before upload
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
