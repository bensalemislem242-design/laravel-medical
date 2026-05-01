@extends('layout')
@section('title', 'Invoices')
@section('content')

<div class="card shadow-sm border-0 rounded">
    <div class="card-body">

        <a href="{{ route('invoices.create') }}" class="btn btn-success mb-3">
            Add Invoice
        </a>

        {{-- Statistics Cards --}}
        <div class="row mb-4">

            <div class="col-md-3">
                <div class="card bg-success text-white">
                    <div class="card-body">
                        <h6>Total Revenue</h6>
                        <h4>{{ $totalRevenue }} TND</h4>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card bg-primary text-white">
                    <div class="card-body">
                        <h6>Monthly Revenue</h6>
                        <h4>{{ $monthlyRevenue }} TND</h4>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card bg-warning text-dark">
                    <div class="card-body">
                        <h6>Unpaid Amount</h6>
                        <h4>{{ $unpaidAmount }} TND</h4>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card bg-danger text-white">
                    <div class="card-body">
                        <h6>Overdue Invoices</h6>
                        <h4>{{ $overdueCount }}</h4>
                    </div>
                </div>
            </div>

        </div>

        {{-- Alert --}}
        @if($overdueCount > 0)
            <div class="alert alert-danger">
                ⚠️ There are {{ $overdueCount }} overdue invoices!
            </div>
        @endif


        {{-- Table --}}
        <table class="table table-striped table-hover">
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Amount</th>
                    <th>Patient</th>
                    <th>Date</th>
                    <th>Status</th>
                    <th class="text-center">Actions</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($invoices as $invoice)
                <tr>
                    <td>{{ $invoice->title }}</td>
                    <td>{{ $invoice->amount }} TND</td>
                    <td>{{ $invoice->patient?->name ?? '-' }}</td>
                    <td>{{ $invoice->invoice_date }}</td>

                    {{-- STATUS LOGIC --}}
                    <td>
                        @if($invoice->status == 'paid')
                            <span class="badge bg-success">Paid</span>

                        @elseif($invoice->status == 'unpaid' && $invoice->invoice_date < \Carbon\Carbon::today())
                            <span class="badge bg-danger">Overdue</span>

                        @else
                            <span class="badge bg-warning text-dark">Unpaid</span>
                        @endif
                    </td>

                    <td class="text-center">
                        <a href="{{ route('invoices.show', $invoice) }}" class="btn btn-sm btn-info">
                            View
                        </a>

                        <a href="{{ route('invoices.edit', $invoice) }}" class="btn btn-sm btn-warning">
                            Edit
                        </a>

                        <form action="{{ route('invoices.destroy', $invoice) }}" 
                              method="POST" 
                              class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger"
                                    onclick="return confirm('Are you sure?')">
                                Delete
                            </button>
                        </form>
                    </td>

                </tr>
                @endforeach
            </tbody>
        </table>

    </div>
</div>

@endsection
