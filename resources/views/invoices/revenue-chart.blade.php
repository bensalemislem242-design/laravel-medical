@extends('layout')

@section('title', 'Revenue Chart')

@section('content')

<div class="card shadow-sm border-0 rounded p-4">
    <h4 class="mb-4">Revenue Chart</h4>

    <canvas id="revenueChart" height="100"></canvas>
</div>

@endsection


<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
document.addEventListener("DOMContentLoaded", function () {

    const ctx = document.getElementById('revenueChart');

    const revenueChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: {!! json_encode(array_keys($revenues)) !!},
            datasets: [{
                label: 'Monthly Revenue',
                data: {!! json_encode(array_values($revenues)) !!},
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });

});
</script>
