@extends('layout')
@section('title', 'Add Invoice')
@section('content')

<div class="card shadow-sm border-0 rounded">
    <div class="card-body">
        <form action="{{ route('invoices.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label>Title</label>
                <input type="text" name="title" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>Amount</label>
                <input type="number" name="amount" class="form-control" step="0.01" required>
            </div>
            <div class="mb-3">
                <label>Invoice Date</label>
                <input type="date" name="invoice_date" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>Status</label>
                <select name="status" class="form-control">
                    <option value="unpaid">Unpaid</option>
                    <option value="paid">Paid</option>
                </select>
            </div>
            <div class="mb-3">
                <label>Patient (optional)</label>
                <select name="patient_id" class="form-control">
                    <option value="">-- Select Patient --</option>
                    @foreach($patients as $patient)
                        <option value="{{ $patient->id }}">{{ $patient->name }} {{ $patient->lastname }}</option>
                    @endforeach
                </select>
            </div>
            <button class="btn btn-primary">Save Invoice</button>
        </form>
    </div>
</div>

@endsection
