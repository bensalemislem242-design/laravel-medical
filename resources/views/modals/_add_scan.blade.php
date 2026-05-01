<div class="modal fade" id="modal-scan" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Add Scan</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>

            <div class="modal-body">

                <form method="POST" action="{{ route('scans.store') }}" enctype="multipart/form-data">
                    @csrf

                    <input type="hidden" name="patient_id" value="{{ $patient->id }}">

                    <div class="form-group">
                        <label>Type</label>
                        <input type="text" name="type" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label>Scan file</label>
                        <input type="file" name="scan_path" class="form-control" required>
                    </div>

                    <button type="submit" class="btn btn-primary">
                        Save Scan
                    </button>

                </form>

            </div>

        </div>
    </div>
</div>
