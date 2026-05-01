<!-- PopOut RENDEZ-VOUS Modal -->
<div class="modal fade" id="modal_add_appointment">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg rounded-3">
            <div class="modal-header bg-primary text-white">
                <h4 class="modal-title m-0">Add an Appointment</h4>
                <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
            </div>

            <div class="modal-body px-4 py-3">
                <form class="needs-validation" method="POST" action="{{ route('appointments.store') }}" novalidate>
                    @csrf

                    <!-- Doctor Selection -->
                    @if (\App\Enums\UserRoles::isDoctor(Auth::user()->role))
                        <input id="doctor" name="doctor_id" type="number" value="{{ Auth::user()->id }}" hidden />
                    @else
                        <div class="form-group mb-3">
                            <label class="form-label">Doctor</label>
                            <select name="doctor_id" class="form-control select2-doctor-ajax"></select>
                        </div>
                    @endif

                    <!-- Patient Selection -->
                    <div class="form-group mb-3">
                        <label class="form-label">Patient</label>
                        <select name="patient_id" class="form-control select2-patient-ajax"></select>
                    </div>

                    <!-- Motivation -->
                    <div class="form-group mb-3">
                        <label class="form-label" for="motivation">Motivation</label>
                        <textarea id="motivation" name="motivation" class="form-control" placeholder="Enter motivation" rows="3" required></textarea>
                    </div>

                    <!-- Date -->
                    <div class="form-group mb-3">
                        <label class="form-label">Date</label>
                        <div class="input-group">
                            <input type="date" name="date" class="form-control" required />
                            <div class="input-group-append">
                                <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                            </div>
                        </div>
                    </div>

                    <!-- Start Time -->
                    <div class="form-group mb-3">
                        <label class="form-label">Start Time</label>
                        <div class="input-group">
                            <input type="time" name="start_time" class="form-control" min="09:00" max="18:00" required />
                            <div class="input-group-append">
                                <span class="input-group-text"><i class="far fa-clock"></i></span>
                            </div>
                        </div>
                    </div>

                    <!-- End Time -->
                    <div class="form-group mb-4">
                        <label class="form-label">End Time</label>
                        <div class="input-group">
                            <input type="time" name="end_time" class="form-control" min="09:00" max="18:00" required />
                            <div class="input-group-append">
                                <span class="input-group-text"><i class="far fa-clock"></i></span>
                            </div>
                        </div>
                    </div>

                    <!-- Buttons -->
                    <div class="d-flex justify-content-between">
                        <button type="button" class="btn btn-secondary rounded-pill px-4" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary rounded-pill px-4">Add</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Optional Custom Styles -->
<style>
    #modal_add_appointment .modal-header {
        border-bottom: none;
    }
    #modal_add_appointment .form-label {
        font-weight: 600;
    }
    #modal_add_appointment .form-control {
        border-radius: 0.5rem;
        padding: 0.625rem 0.75rem;
    }
    #modal_add_appointment .input-group-text {
        background-color: #f0f2f5;
        border-radius: 0.5rem;
    }
    #modal_add_appointment .btn-primary {
        background: linear-gradient(135deg, #2aa9fb, #37e1c3);
        border: none;
    }
    #modal_add_appointment .btn-secondary {
        background: #6c757d;
        border: none;
    }
</style>