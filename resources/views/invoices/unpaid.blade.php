@extends('layout')
@section('title', 'Unpaid Invoices')
@section('content')

<div class="card shadow-sm border-0 rounded">
    <div class="card-body">

        <div class="d-flex justify-content-between mb-3">
            <h4>Unpaid Invoices</h4>
            <a href="{{ route('invoices.index') }}" class="btn btn-secondary">
                Back to All Invoices
            </a>
        </div>

        <table class="table table-striped table-hover">
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Amount</th>
                    <th>Patient</th>
                    <th>Date</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($invoices as $invoice)
                <tr>
                    <td>{{ $invoice->title }}</td>
                    <td>{{ $invoice->amount }}</td>
                    <td>{{ $invoice->patient?->name ?? '-' }}</td>
                    <td>{{ $invoice->invoice_date }}</td>
                    <td>
                        <span class="badge bg-danger">
                            Unpaid
                        </span>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center text-muted">
                        No unpaid invoices found.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>

    </div>
</div>

@endsection
