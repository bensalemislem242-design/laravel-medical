@extends('layout')
@section('title', 'Patients Management')
@section('header', 'Patients list')

@section('content')
    <div class="card">
        <div class="card-body">
            <div id="patients_table_wrapper" class="dataTables_wrapper dt-bootstrap4">

                <div class="row">
                    <div class="col-sm-12">
                        <table id="patients_table" class="table table-bordered table-striped dataTable dtr-inline"
                            role="grid" aria-describedby="patients_table_info">
                            <thead>
                                <tr role="row">
                                    <th>Name</th>
                                    <th>Last Name</th>
                                    <th>Date of Birth</th>
                                    <th>Phone</th>
                                    <th>Email</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $counter = 1; @endphp
                                @foreach ($patients as $patient)
                                    <tr role="row" class="{{ $counter % 2 == 0 ? 'even' : 'odd' }}">
                                        <td>{{ $patient['name'] }}</td>
                                        <td>{{ $patient['lastname'] }}</td>
                                        <td>{{ $patient['dob'] }}</td>
                                        <td>{{ $patient['phone'] }}</td>
                                        <td>{{ $patient['email'] }}</td>
                                        <td style="width: 140px;">

                                            <!-- Show button -->
                                            <a href="{{ route('patients.show', [$patient]) }}" class="btn btn-profile"
                                                style="height: 41px; min-width: 46px; margin: 0; padding: 0;">
                                                <i class="fas fa-external-link-alt"></i>
                                            </a>

                                            <!-- Edit button -->
                                            <a href="{{ route('patients.edit', [$patient]) }}" class="btn btn-app"
                                                style="height: 41px; min-width: 46px; margin: 0; padding: 0;">
                                                <i class="fas fa-pen"></i>
                                            </a>

                                            <!-- Delete button -->
                                            <form action="{{ route('patients.destroy', [$patient]) }}" method="POST" style="display:inline-block;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger"
                                                    style="height: 41px; min-width: 46px; margin:0; padding:0;"
                                                    onclick="return confirm('Are you sure you want to delete this patient? This will also delete the associated user if exists.');">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>

                                        </td>
                                    </tr>
                                    @php $counter++; @endphp
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Add patient button -->
            <div class="add-btn-container">
                <button type="button" class="btn-default add-btn" data-toggle="modal" data-target="#modal-add-patient">
                    <i class="fas fa-user-plus" style="font-size: 29px; margin-bottom: 8px; margin-left: 1px;"></i>
                </button>
            </div>

        </div>
        <!-- /.card-body -->
    </div>
    <!-- /.card -->

    @include('modals._add_patient')

@endsection
