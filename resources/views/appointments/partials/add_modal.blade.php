<!-- resources/views/appointments/partials/add_modal.blade.php -->
<div class="modal fade" id="modal_add_appointment" tabindex="-1" role="dialog" aria-labelledby="modalAddLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <form action="{{ route('appointments.store') }}" method="POST">
        @csrf
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add Appointment</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="doctor_id">Doctor</label>
                    <select name="doctor_id" class="form-control" required>
                        <option value="">Select Doctor</option>
                        @foreach($doctors as $doctor)
                            <option value="{{ $doctor->id }}">{{ $doctor->name }} - {{ $doctor->specialty->name ?? 'No Specialty' }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="hospital_id">Hospital</label>
                    <select name="hospital_id" class="form-control" required>
                        <option value="">Select Hospital</option>
                        @foreach($hospitals as $hospital)
                            <option value="{{ $hospital->id }}">{{ $hospital->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="date">Date</label>
                    <input type="date" name="date" class="form-control" required>
                </div>

                <div class="form-group">
                    <label for="start_time">Start Time</label>
                    <input type="time" name="start_time" class="form-control" required>
                </div>

                <div class="form-group">
                    <label for="end_time">End Time</label>
                    <input type="time" name="end_time" class="form-control" required>
                </div>

                <div class="form-group">
                    <label for="motivation">Motivation</label>
                    <textarea name="motivation" class="form-control" rows="2" required></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-success">Save</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
            </div>
        </div>
    </form>
  </div>
</div>
