@extends('layout')

@section('title', 'Financial Details')

@section('content')
<h2>{{ ucfirst($type) }} for {{ $month }}</h2>

<table class="table table-bordered">
    <thead>
        <tr>
            <th>#</th>
            <th>Date</th>
            <th>Amount</th>
            <th>Description</th>
        </tr>
    </thead>
    <tbody>
        @forelse($data as $item)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $type === 'incomes' ? $item->income_date : $item->expense_date }}</td>
            <td>{{ $item->amount }}</td>
            <td>{{ $item->description ?? '-' }}</td>
        </tr>
        @empty
        <tr><td colspan="4">No records found.</td></tr>
        @endforelse
    </tbody>
</table>

<a href="{{ route('financial.index') }}">Back to Dashboard</a>
@endsection
