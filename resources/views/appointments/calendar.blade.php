@extends('layout')

@section('title', 'Appointments Calendar')

@section('content')

<div class="card p-4 shadow-sm">
    <h4 class="mb-3">Appointments Calendar</h4>

    <div id="calendar"></div>
</div>

@endsection

<link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.css" rel="stylesheet">

<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {

    var calendarEl = document.getElementById('calendar');

    var calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        events: {!! json_encode($events) !!}
    });

    calendar.render();
});
</script>
