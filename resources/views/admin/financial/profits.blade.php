@extends('layout')
@section('title', 'Profits')

@section('content')
<div class="container">
    <h2>Profits - Month {{ $month }}</h2>
    <p><strong>Total Profit: </strong> {{ $profit }}</p>
    <a href="{{ route('financial.index', ['month' => $month]) }}" class="btn btn-primary">Back to Dashboard</a>
</div>
@endsection
