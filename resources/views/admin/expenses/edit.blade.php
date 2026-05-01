@extends('layout')

@section('title', 'Edit Expense')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4">Edit Expense</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('expenses.update', $expense->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="title" class="form-label">Title</label>
            <input type="text" name="title" id="title" class="form-control" 
                   value="{{ old('title', $expense->title) }}" required>
            @error('title')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        <div class="mb-3">
            <label for="amount" class="form-label">Amount</label>
            <input type="number" name="amount" id="amount" class="form-control" 
                   value="{{ old('amount', $expense->amount) }}" step="0.01" required>
            @error('amount')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        <div class="mb-3">
            <label for="expense_date" class="form-label">Expense Date</label>
            <input type="date" name="expense_date" id="expense_date" class="form-control" 
                   value="{{ old('expense_date', $expense->expense_date->format('Y-m-d')) }}" required>
            @error('expense_date')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        <button type="submit" class="btn btn-success">Update Expense</button>
        <a href="{{ route('expenses.index') }}" class="btn btn-secondary">Back</a>
    </form>
</div>
@endsection
