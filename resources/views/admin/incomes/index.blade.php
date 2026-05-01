@extends('layout')

@section('title', 'Incomes List')

@section('content')
<div class="container mt-4">
    <h2>Incomes List</h2>

    <a href="{{ route('incomes.create') }}" class="btn btn-primary mb-3">Add Income</a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered">
        <thead class="table-dark">
            <tr>
                <th>#</th>
                <th>Title</th>
                <th>Amount</th>
                <th>Date</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($incomes as $income)
            <tr>
                <td>{{ $income->id }}</td>
                <td>{{ $income->title }}</td>
                <td>{{ $income->amount }}</td>
                <td>{{ $income->income_date->format('d-m-Y') }}</td>
                <td>
                    <a href="{{ route('incomes.edit', $income->id) }}" class="btn btn-warning btn-sm">Edit</a>
                    <form action="{{ route('incomes.destroy', $income->id) }}" method="POST" style="display:inline-block;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm"
                                onclick="return confirm('Are you sure?')">Delete</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="text-center">No incomes found.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    
</div>
@endsection
