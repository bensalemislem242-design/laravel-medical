@extends('layout')

@section('title', 'Expenses List')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4">Expenses List</h2>

    <a href="{{ route('expenses.create') }}" class="btn btn-primary mb-3">Add Expense</a>

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
            @forelse($expenses as $expense)
                <tr>
                    <td>{{ $expense->id }}</td>
                   <td>{{ $expense->title }}</td>

                    <td>{{ $expense->amount }}</td>
                    <td>{{ $expense->created_at->format('d-m-Y') }}</td>
                    <td>
                        <a href="{{ route('expenses.edit', $expense->id) }}" class="btn btn-warning btn-sm">Edit</a>

                        <form action="{{ route('expenses.destroy', $expense->id) }}" method="POST" style="display:inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this expense?')">
                                Delete
                            </button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center">No expenses found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
