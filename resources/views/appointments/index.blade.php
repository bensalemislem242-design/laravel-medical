@extends('layout')
@section('title', 'Appointment Management')
@section('header', 'Appointment list')

@section('content')
    <div class="card">
        <div class="card-body">
            <div id="appointment_table_wrapper" class="dataTables_wrapper dt-bootstrap4">

                <div class="row">
                    <div class="col-sm-12">
                        <table>
    <tr>
        <th>Motivation</th>
        <th>Date</th>
        <th>Start Time</th>
        <th>End Time</th>
        <th>Doctor</th>
        <th>Patient</th>
    </tr>
    @foreach($appointments as $appointment)
        <tr>
            <td>{{ $appointment->motivation }}</td>
            <td>{{ $appointment->date }}</td>
            <td>{{ $appointment->start_time }}</td>
            <td>{{ $appointment->end_time }}</td>
            <td>{{ $appointment->doctor->name }} {{ $appointment->doctor->lastname }}</td>
            <td>{{ $appointment->patient->name }} {{ $appointment->patient->lastname }}</td>
        </tr>
    @endforeach
</table>


                    </div>
                </div>
            </div>
            <div class="add-btn-container">
                <button type="button" class="  btn-success add-btn" data-toggle="modal"
                    data-target="#modal_add_appointment">
                    +
                </button>
            </div>
        </div>
        <!-- /.card-body -->
    </div>
    <!-- /.card -->
    @include('modals._add_appointment')

@endsection
