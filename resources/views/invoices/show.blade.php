@extends('layout')
@section('title', 'Invoice Details')
@section('content')

<div class="card shadow-sm border-0 rounded">
    <div class="card-body">
        <h4>{{ $invoice->title }}</h4>
        <p><strong>Amount:</strong> {{ $invoice->amount }}</p>
        <p><strong>Patient:</strong> {{ $invoice->patient?->name ?? '-' }}</p>
        <p><strong>Date:</strong> {{ $invoice->invoice_date }}</p>
        <p><strong>Status:</strong> <span class="badge {{ $invoice->status == 'paid' ? 'bg-success' : 'bg-danger' }}">{{ ucfirst($invoice->status) }}</span></p>
        <a href="{{ route('invoices.index') }}" class="btn btn-secondary">Back to list</a>
    </div>
</div>

@endsection
