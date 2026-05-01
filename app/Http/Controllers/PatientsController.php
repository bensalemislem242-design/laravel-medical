<?php

namespace App\Http\Controllers;

use App\Helpers\ModelHelpers;
use App\Http\Requests\PatientFormRequest;
use App\Models\Patient;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Enums\UserRoles;
use App\Models\User; 
use Illuminate\Support\Facades\Hash;

class PatientsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    { 
        $patients = Patient::orderBy('lastname')->get();
        return view('patients.index', ['patients' => $patients]);
    }

    /**
     * Search patients by query (name or lastname)
     */
    public function findByQuery(Request $request)
    {
        $result = Patient::select('id', DB::raw("CONCAT(patients.name,' ',patients.lastname) as text"))
            ->where('lastname', 'LIKE', '%' . $request->queryTerm . '%')
            ->orWhere('name', 'LIKE', '%' . $request->queryTerm . '%')
            ->get();

        return response()->json($result);
    }

    /**
     * Store a newly created patient and user
     */
   public function store(Request $request)
{
    $prescription = Prescription::create([
        'patient_id' => $request->patient_id,
        'medication' => $request->medication,
        'dosage' => $request->dosage,
        'instructions' => $request->instructions,
    ]);

    return response()->json([
        'success' => true,
        'data' => $prescription
    ]);
}

    /**
     * Display a specific patient along with related data
     */
    public function show(Patient $patient)
    {
        $doctor_id = Auth::user()->id;

        $appointments = $patient->appointments()->where('user_id', $doctor_id)->get();
        $orientationLtrs = $patient->orientationLtrs()->where('user_id', $doctor_id)->get();
        $prescriptions = $patient->prescriptions()->where('user_id', $doctor_id)->get();
        $scans = $patient->scans()->where('user_id', $doctor_id)->get();

        return view('patients.show', [
            'patient' => $patient,
            'appointments' => $appointments,
            'prescriptions' => $prescriptions,
            'scans' => $scans,
            'orientationLtrs' => $orientationLtrs,
        ]);
    }

    /**
     * Show the form for editing a patient
     */
    public function edit(Patient $patient)
    {
        return view('patients.edit', ['patient' => $patient]);
    }

    /**
     * Update a patient
     */
    public function update(Patient $patient, PatientFormRequest $request)
    {
        $validated = $request->validated();
        $patient->update($validated);

        return back()->with('success', 'Patient ' . $patient->name . ' updated!');
    }

    /**
     * Delete a patient and corresponding user
     */
    public function destroy(Patient $patient)
    {
        if ($patient->user) {
            $patient->user->delete();
        }

        $patient->delete();

        return redirect()->route('patients.index')
                         ->with('success', 'Patient and user deleted successfully.');
    }

    /**
     * 🔹 API: Get all patients (JSON) for Flutter
     */
    public function apiIndex()
    {
        $patients = Patient::orderBy('lastname')->get();
        return response()->json($patients);
    }

    /**
     * 🔹 API: Get single patient with relations (JSON) for Flutter
     */
    public function apiShow($id)
    {
        $patient = Patient::with(['appointments', 'orientationLtrs', 'prescriptions', 'scans'])->find($id);

        if (!$patient) {
            return response()->json(['message' => 'Patient not found'], 404);
        }

        return response()->json($patient);
    }
}
