@extends('layout')
@section('title', 'Edit Invoice')
@section('content')

<div class="card shadow-sm border-0 rounded">
    <div class="card-body">
        <form action="{{ route('invoices.update', $invoice) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label>Title</label>
                <input type="text" name="title" class="form-control" value="{{ $invoice->title }}" required>
            </div>
            <div class="mb-3">
                <label>Amount</label>
                <input type="number" name="amount" class="form-control" step="0.01" value="{{ $invoice->amount }}" required>
            </div>
            <div class="mb-3">
                <label>Invoice Date</label>
                <input type="date" name="invoice_date" class="form-control" value="{{ $invoice->invoice_date }}" required>
            </div>
            <div class="mb-3">
                <label>Status</label>
                <select name="status" class="form-control">
                    <option value="unpaid" {{ $invoice->status == 'unpaid' ? 'selected' : '' }}>Unpaid</option>
                    <option value="paid" {{ $invoice->status == 'paid' ? 'selected' : '' }}>Paid</option>
                </select>
            </div>
            <div class="mb-3">
                <label>Patient (optional)</label>
                <select name="patient_id" class="form-control">
                    <option value="">-- Select Patient --</option>
                    @foreach($patients as $patient)
                        <option value="{{ $patient->id }}" {{ $invoice->patient_id == $patient->id ? 'selected' : '' }}>
                            {{ $patient->name }} {{ $patient->lastname }}
                        </option>
                    @endforeach
                </select>
            </div>
            <button class="btn btn-primary">Update Invoice</button>
        </form>
    </div>
</div>

@endsection
