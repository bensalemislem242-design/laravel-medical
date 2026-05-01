@extends('layout')
@section('title', 'Appointment Management')
@section('header', 'Appointment List')

@section('content')
<div class="card shadow-sm border-0 rounded">
    <div class="card-body">
        <div class="table-responsive">
            <table id="appointment_table" class="table table-striped table-hover align-middle">
                <thead class="thead-light">
                    <tr>
                        <th>Hospital</th> <!-- Hospital column first -->
                        <th>Date</th>
                        <th>Start Time</th>
                        <th>End Time</th>
                        <th>Doctor</th>
                        <th>Specialty</th>
                        <th>Motivation</th>
                        <th class="text-center">Status</th>
                        <th class="text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($appointments as $appointment)
                    <tr>
                        <td>{{ $appointment->hospital?->name ?? 'No Hospital' }}</td> <!-- Hospital Data first -->
                        <td>{{ $appointment->date }}</td>
                        <td>{{ $appointment->start_time }}</td>
                        <td>{{ $appointment->end_time }}</td>
                        <td>{{ $appointment->doctor?->name ?? 'No Doctor' }}</td>
                        <td>{{ $appointment->doctor?->specialty?->name ?? 'No Specialty' }}</td>
                        <td class="text-truncate" style="max-width: 250px;" title="{{ $appointment->motivation }}">
                            {{ $appointment->motivation }}
                        </td>

                        <!-- ===== Status Column ===== -->
                        <td class="text-center">
                            <a href="{{ route('appointments.editStatus', $appointment->id) }}">
                                <span class="badge 
                                    @if($appointment->status === 'pending') bg-secondary
                                    @elseif($appointment->status === 'accepted') bg-success
                                    @elseif($appointment->status === 'en_cours') bg-warning
                                    @elseif($appointment->status === 'refused') bg-danger
                                    @endif
                                ">
                                    {{ ucfirst($appointment->status) }}
                                </span>
                            </a>

                            @if($appointment->appointment_date)
                                <div class="mt-1">
                                    <small>
                                        📅 {{ $appointment->appointment_date }} <br>
                                        ⏰ {{ $appointment->appointment_time }}
                                    </small>
                                </div>
                            @endif
                        </td>

                        <!-- ===== Action Column ===== -->
                        <td class="text-center">
                            <a href="{{ route('appointments.edit', $appointment->id) }}" class="btn btn-sm btn-primary" title="Edit">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('appointments.destroy', $appointment->id) }}" method="POST" class="d-inline-block">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" title="Delete"
                                        onclick="return confirm('Are you sure you want to delete this appointment?')">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Floating add button -->
        <button type="button" class="btn btn-success rounded-circle shadow-lg"
                style="position: fixed; bottom: 30px; right: 30px; width: 55px; height: 55px; font-size: 28px; display: flex; align-items: center; justify-content: center;"
                data-toggle="modal" data-target="#modal_add_appointment" title="Add Appointment">
            <i class="fas fa-plus"></i>
        </button>
    </div>
</div>

<!-- ===== Add Appointment Modal ===== -->
@include('appointments.partials.add_modal')

<!-- Initialize DataTables -->
<script>
    $(document).ready(function() {
        $('#appointment_table').DataTable({
            "paging": true,
            "lengthChange": false,
            "searching": true,
            "ordering": true,
            "info": true,
            "autoWidth": false,
        });
    });
</script>
@endsection
