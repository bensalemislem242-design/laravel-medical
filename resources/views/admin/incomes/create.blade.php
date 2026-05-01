@extends('layout')

@section('title', 'Add Income')

@section('content')
<div class="container mt-4">
    <h2>Add New Income</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('incomes.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="title" class="form-label">Title</label>
            <input type="text" name="title" id="title" class="form-control" value="{{ old('title') }}" required>
        </div>

        <div class="mb-3">
            <label for="amount" class="form-label">Amount</label>
            <input type="number" step="0.01" name="amount" id="amount" class="form-control" value="{{ old('amount') }}" required>
        </div>

        <div class="mb-3">
            <label for="income_date" class="form-label">Income Date</label>
            <input type="date" name="income_date" id="income_date" class="form-control" value="{{ old('income_date') }}" required>
        </div>

        <button type="submit" class="btn btn-success">Add Income</button>
        <a href="{{ route('incomes.index') }}" class="btn btn-secondary">Back</a>
    </form>
</div>
@endsection
