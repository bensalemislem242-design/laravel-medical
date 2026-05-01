@extends('layout')

@section('title', 'Financial Dashboard')

@section('content')

<h2 class="nav-icon fas fa-home">  Financial Dashboard</h2>

<form method="GET" action="{{ route('financial.index') }}">
    <label for="month">Select Month:</label>
    <input type="month" id="month" name="month" value="{{ $month }}">
    <button type="submit">Go</button>
</form>

<canvas id="financialChart" style="max-width:100%; height:400px;"></canvas>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
const ctx = document.getElementById('financialChart').getContext('2d');
const financialChart = new Chart(ctx, {
    data: {
        labels: @json($labels),
        datasets: [
            {
                type: 'bar',
                label: 'Income',
                data: @json($incomesData),
                backgroundColor: 'rgba(54, 162, 235, 0.7)',
            },
            {
                type: 'bar',
                label: 'Expenses',
                data: @json($expensesData),
                backgroundColor: 'rgba(255, 99, 132, 0.7)',
            },
            {
                type: 'line',
                label: 'Profit',
                data: @json($profitData),
                borderColor: 'rgba(255, 159, 64, 1)',
                borderWidth: 2,
                fill: false,
                tension: 0.3,
            }
        ]
    },
    options: {
        responsive: true,
        plugins: {
            legend: { position: 'top' }
        },
        scales: {
            y: { beginAtZero: true }
        },
        onClick: (evt, elements) => {
            if(elements.length > 0){
                const datasetIndex = elements[0].datasetIndex;
                const datasetLabel = financialChart.data.datasets[datasetIndex].label;

                if(datasetLabel === 'Income'){
                    window.location.href = "{{ route('incomes.index') }}";
                } else if(datasetLabel === 'Expenses'){
                    window.location.href = "{{ route('expenses.index') }}";
                }
            }
        }
    }
});
</script>

@endsection
