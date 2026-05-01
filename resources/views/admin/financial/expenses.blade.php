@extends('layout')
@section('title', 'Expenses List')

@section('content')
<div class="container">
    <h2>Expenses - Month {{ $month }}</h2>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Amount</th>
                <th>Date</th>
                <th>Description</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data as $expense)
            <tr>
                <td>{{ $expense->id }}</td>
                <td>{{ $expense->amount }}</td>
                <td>{{ $expense->expense_date }}</td>
                <td>{{ $expense->description }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <a href="{{ route('financial.index', ['month' => $month]) }}" class="btn btn-primary">Back</a>
</div>
@endsection
