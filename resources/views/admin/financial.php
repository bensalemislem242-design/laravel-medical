@extends('layout')

@section('content')

<h2>Financial Overview Panel</h2>

<div style="display:flex; gap:20px; margin-bottom:20px;">
    <div>Total Revenue: {{ $totalRevenue }} TND</div>
    <div>Total Expenses: {{ $totalExpenses }} TND</div>
    <div>Net Profit: {{ $profit }} TND</div>
</div>

<hr>

<h3>Monthly Income Graph</h3>

<canvas id="incomeChart"></canvas>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
const ctx = document.getElementById('incomeChart');

new Chart(ctx, {
    type: 'bar',
    data: {
        labels: {!! json_encode($monthlyIncome->keys()) !!},
        datasets: [{
            label: 'Monthly Revenue',
            data: {!! json_encode($monthlyIncome->values()) !!},
            borderWidth: 1
        }]
    }
});
</script>

<hr>

<h3>Unpaid Invoices</h3>

<table border="1">
<tr>
    <th>ID</th>
    <th>Patient</th>
    <th>Amount</th>
    <th>Status</th>
</tr>

@foreach($unpaidInvoices as $invoice)
<tr>
    <td>{{ $invoice->id }}</td>
    <td>{{ $invoice->patient->name }}</td>
    <td>{{ $invoice->amount }} TND</td>
    <td style="color:red">{{ $invoice->status }}</td>
</tr>
@endforeach

</table>

@endsection
