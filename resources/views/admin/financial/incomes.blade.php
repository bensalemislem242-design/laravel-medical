@extends('layout')
@section('title', 'Incomes List')

@section('content')
<div class="container">
    <h2>Incomes - Month {{ $month }}</h2>
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
            @foreach($data as $income)
            <tr>
                <td>{{ $income->id }}</td>
                <td>{{ $income->amount }}</td>
                <td>{{ $income->income_date }}</td>
                <td>{{ $income->description }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <a href="{{ route('financial.index', ['month' => $month]) }}" class="btn btn-primary">Back</a>
</div>
@endsection
