@extends('layout')

@section('title', 'Dashboard Statistics')

@section('content')

<div class="container mt-4">

    <h3 class="mb-4">Dashboard Statistics</h3>

    <div class="row mb-4">

        <div class="col-md-3">
            <div class="card p-3 text-center shadow-sm">
                <h6>Total Invoices</h6>
                <h4>{{ $totalInvoices }}</h4>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card p-3 text-center shadow-sm">
                <h6>Total Revenue</h6>
                <h4>{{ $totalRevenue }} DT</h4>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card p-3 text-center shadow-sm bg-success text-white">
                <h6>Total Paid</h6>
                <h4>{{ $totalPaid }} DT</h4>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card p-3 text-center shadow-sm bg-danger text-white">
                <h6>Total Unpaid</h6>
                <h4>{{ $totalUnpaid }} DT</h4>
            </div>
        </div>

    </div>

    <div class="row">

        <div class="col-md-8">
            <div class="card p-4 shadow-sm">
                <h5>Yearly Revenue (Line Chart)</h5>
                <canvas id="lineChart"></canvas>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card p-4 shadow-sm">
                <h5>Paid vs Unpaid</h5>
                <canvas id="pieChart"></canvas>
            </div>
        </div>

    </div>

</div>

@endsection


<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
document.addEventListener("DOMContentLoaded", function () {

    // LINE CHART
    new Chart(document.getElementById('lineChart'), {
        type: 'line',
        data: {
            labels: ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'],
            datasets: [{
                label: 'Monthly Revenue',
                data: {!! json_encode($monthlyRevenue) !!},
                fill: false,
                tension: 0.3
            }]
        }
    });

    // DOUGHNUT CHART
    new Chart(document.getElementById('pieChart'), {
        type: 'doughnut',
        data: {
            labels: ['Paid', 'Unpaid'],
            datasets: [{
                data: [{{ $totalPaid }}, {{ $totalUnpaid }}]
            }]
        }
    });

});
</script>
