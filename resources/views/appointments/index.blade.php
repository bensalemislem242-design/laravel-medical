@extends('layout') 
@section('title', 'Appointment Management')
@section('header', 'Appointment list')

@section('content')
    <div class="card">
        <div class="card-body">
            <div id="appointment_table_wrapper" class="dataTables_wrapper dt-bootstrap4">
                <div class="row">
                    <div class="col-sm-12">
                        <table id="appointment_table" class="table table-bordered table-striped dataTable dtr-inline"
                            role="grid" aria-describedby="example1_info">
                            <thead>
                                <tr role="row">
                                    <th>Date</th>
                                    <th>Start time</th>
                                    <th>End time</th>
                                    <th>Doctor</th>
                                    <th>Motivation</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $counter = 1; @endphp
                                @foreach ($appointments as $appointment)
                                    <tr class="{{ $counter % 2 == 0 ? 'even' : 'odd' }}">
                                        <td>{{ $appointment['date'] }}</td>
                                        <td>{{ $appointment['start_time'] }}</td>
                                        <td>{{ $appointment['end_time'] }}</td>
                                        <td>{{ $appointment->doctor ? $appointment->doctor->name : 'No Doctor' }}</td>
                                        <td class="truncate">{{ $appointment['motivation'] }}</td>
                                        <td style="padding-right: -3.25rem;border-right-width: 0px;height: 37px;width: 95.833px;">
                                            TBD later
                                            {{-- Actions buttons commented --}}
                                        </td>
                                    </tr>
                                    @php $counter++; @endphp
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="add-btn-container">
                <button type="button" class="btn-success add-btn" data-toggle="modal" data-target="#modal_add_appointment">
                    +
                </button>
            </div>
        </div>
    </div>
    @include('modals._add_appointment')
@endsection
