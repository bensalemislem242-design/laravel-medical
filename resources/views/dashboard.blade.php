@extends('layout')

@section('title', 'Dashboard ')

@section('content')
<h2 class="nav-icon fas fa-home">  Dashboard </h2>


<div class="container mt-4">


    <div class="row mb-4">
        <!-- TOP CARDS -->
        <div class="col-md-3">
            <div class="card p-3 text-center shadow-sm " style="background-color: #2aa9fb; color: #fff;">
                <h6>Total Doctors</h6>
                <h3>{{ $doctors }}</h3>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card p-3 text-center shadow-sm" style="background-color: #37e1c3; color: #fff;">
                <h6>Total Patients</h6>
                <h3>{{ $patients }}</h3>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card p-3 text-center shadow-sm" style="background-color: #16a34a; color: #fff;">
                <h6>Total Invoices</h6>
                <h4>{{ $totalInvoices }}</h4>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card p-3 text-center shadow-sm" style="background-color: #ef4444; color: #fff;">
                <h6>Total Revenue</h6>
                <h4>{{ $totalRevenue }} DT</h4>
            </div>
        </div>
        <div class="col-md-3 mt-3">
            <div class="card p-3 text-center shadow-sm" style="background-color: #6366f1; color: #fff;">
                <h6>Total Appointment</h6>
                <h4>{{ $appointmentsTotal }}</h4>
            </div>
        </div>
    </div>

    <!-- APPOINTMENTS STATUS -->
    <div class="card-modern mb-4 p-4 shadow-sm">
        <h5 class="mb-4">Appointments Status</h5>

        <div class="mb-3">
            <div class="d-flex justify-content-between">
                <span>Confirmed</span>
                <span>{{ $appointmentsConfirmed }} ({{ $appointmentsConfirmedPercent }}%)</span>
            </div>
            <div class="progress" style="height: 16px; border-radius: 12px; overflow: hidden;">
                <div class="bg-success" style="width: {{ $appointmentsConfirmedPercent }}%; height: 100%; transition: 0.5s;"></div>
            </div>
        </div>

        <div class="mb-3">
            <div class="d-flex justify-content-between">
                <span>Pending</span>
                <span>{{ $appointmentsPending }} ({{ $appointmentsPendingPercent }}%)</span>
            </div>
            <div class="progress" style="height: 16px; border-radius: 12px; overflow: hidden;">
                <div class="bg-warning" style="width: {{ $appointmentsPendingPercent }}%; height: 100%; transition: 0.5s;"></div>
            </div>
        </div>

        <div class="mb-3">
            <div class="d-flex justify-content-between">
                <span>Canceled</span>
                <span>{{ $appointmentsCanceled }} ({{ $appointmentsCanceledPercent }}%)</span>
            </div>
            <div class="progress" style="height: 16px; border-radius: 12px; overflow: hidden;">
                <div class="bg-danger" style="width: {{ $appointmentsCanceledPercent }}%; height: 100%; transition: 0.5s;"></div>
            </div>
        </div>
    </div>

    <!-- CHARTS -->
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

        <div class="mt-3 d-flex justify-content-around">
            <div class="text-center">
                <p class="mb-1" style="color:#16a34a; font-weight:bold;">Paid</p>
                <h5 style="color:#16a34a;">{{ $totalPaid }} DT</h5>
            </div>
            <div class="text-center">
                <p class="mb-1" style="color:#ef4444; font-weight:bold;">Unpaid</p>
                <h5 style="color:#ef4444;">{{ $totalUnpaid }} DT</h5>
            </div>
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
                borderColor: '#2aa9fb',
                backgroundColor: '#2aa9fb',
                tension: 0.3
            }]
        },
        options: {
            responsive: true,
            plugins: { legend: { display: false } },
            scales: { y: { beginAtZero: true } }
        }
    });

    // DOUGHNUT CHART
    new Chart(document.getElementById('pieChart'), {
        type: 'doughnut',
        data: {
            labels: ['Paid', 'Unpaid'],
            datasets: [{
                data: [{{ $totalPaid }}, {{ $totalUnpaid }}],
                backgroundColor: ['#16a34a','#ef4444']
            }]
        },
        options: { responsive: true, plugins: { legend: { position: 'bottom' } } }
    });

});
</script>