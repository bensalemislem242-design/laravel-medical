<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\User;
use App\Models\Hospital;
use App\Enums\UserRoles;
use Illuminate\Http\Request;
use App\Notifications\NewAppointmentNotification;

class AppointmentsController extends Controller
{
    // ======== LIST ========
    public function index()
    {
        $appointments = Appointment::with(['doctor', 'patient', 'hospital'])->get();
        $doctors = User::where('role', UserRoles::DOCTOR)->get();
        $patients = User::where('role', UserRoles::PATIENT)->get();
        $hospitals = Hospital::all();

        return view('appointments.index', compact('appointments', 'doctors', 'patients', 'hospitals'));
    }

    // ======== CREATE ========
    public function create()
    {
        $doctors = User::where('role', UserRoles::DOCTOR)->get();
        $patients = User::where('role', UserRoles::PATIENT)->get();
        $hospitals = Hospital::all();

        return view('appointments.create', compact('doctors', 'patients', 'hospitals'));
    }

    // ======== STORE (ADMIN) ========
    public function store(Request $request)
    {
        $request->validate([
            'motivation' => 'required|string',
            'date' => 'required|date',
            'start_time' => 'required',
            'end_time' => 'required',
            'doctor_id' => 'required|exists:users,id',
            'patient_id' => 'required|exists:users,id',
            'hospital_id' => 'required|exists:hospitals,id',
        ]);

        $appointment = Appointment::create([
            'doctor_id' => $request->doctor_id,
            'patient_id' => $request->patient_id,
            'hospital_id' => $request->hospital_id,
            'motivation' => $request->motivation,
            'date' => $request->date,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'user_id' => auth()->id(),
            'status' => 'pending',
        ]);

        // 🔔 Notification
        $this->notifyAdmins($appointment);

        return redirect()->route('appointments.index')
            ->with('success', 'Appointment created successfully!');
    }

    // ======== REQUEST (PATIENT / FLUTTER) ========
    public function requestAppointment(Request $request)
    {
        $request->validate([
            'hospital_id' => 'required|exists:hospitals,id',
            'motivation' => 'required|string',
            'date' => 'required|date',
            'start_time' => 'required',
            'end_time' => 'required',
        ]);

        $user = $request->user();

        $appointment = Appointment::create([
            'motivation' => $request->motivation,
            'hospital_id' => $request->hospital_id,
            'patient_id' => $user->id,
            'user_id' => $user->id,
            'status' => 'pending',
            'date' => $request->date,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
        ]);

        // 🔥 أهم حاجة: notification
        $this->notifyAdmins($appointment);

        return response()->json([
            'success' => true,
            'message' => 'Appointment request sent successfully'
        ]);
    }

    // ======== DELETE ========
    public function destroy(Appointment $appointment)
    {
        $appointment->delete();

        return redirect()->route('appointments.index')
            ->with('success', 'Appointment deleted successfully!');
    }

    // ======== 🔔 NOTIFY ADMINS (FIXED) ========
    private function notifyAdmins($appointment)
    {
        $admins = User::where('role', UserRoles::ADMIN)->get();

        foreach ($admins as $admin) {
            $admin->notify(new NewAppointmentNotification($appointment));
        }
    }

    // ======== CALENDAR ========
    public function calendar()
    {
        $appointments = Appointment::all();
        $events = [];

        foreach ($appointments as $appointment) {
            $events[] = [
                'title' => $appointment->motivation,
                'start' => $appointment->date . 'T' . $appointment->start_time,
                'end' => $appointment->date . 'T' . $appointment->end_time,
                'color' => 'red',
                'url' => route('appointments.byDate', $appointment->date),
            ];
        }

        return view('appointments.calendar', compact('events'));
    }

    // ======== FILTER BY DATE ========
    public function byDate($date)
    {
        $appointments = Appointment::where('date', $date)->get();
        return view('appointments.by-date', compact('appointments', 'date'));
    }

    // ======== EDIT ========
    public function edit(Appointment $appointment)
    {
        $doctors = User::where('role', UserRoles::DOCTOR)->get();
        $patients = User::where('role', UserRoles::PATIENT)->get();
        $hospitals = Hospital::all();

        return view('appointments.edit', compact('appointment', 'doctors', 'patients', 'hospitals'));
    }

    // ======== UPDATE ========
    public function update(Request $request, Appointment $appointment)
    {
        $request->validate([
            'motivation' => 'required|string',
            'date' => 'required|date',
            'start_time' => 'required',
            'end_time' => 'required',
            'doctor_id' => 'required|exists:users,id',
            'patient_id' => 'required|exists:users,id',
            'hospital_id' => 'required|exists:hospitals,id',
        ]);

        $appointment->update([
            'doctor_id' => $request->doctor_id,
            'patient_id' => $request->patient_id,
            'hospital_id' => $request->hospital_id,
            'motivation' => $request->motivation,
            'date' => $request->date,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
        ]);

        return redirect()->route('appointments.index')
            ->with('success', 'Appointment updated successfully!');
    }

    // ======== EDIT STATUS ========
    public function editStatus(Appointment $appointment)
    {
        return view('appointments.edit-status', compact('appointment'));
    }

    public function updateStatus(Request $request, $id)
    {
        $appointment = Appointment::findOrFail($id);

        $request->validate([
            'status' => 'required|string|in:pending,accepted,en_cours,refused',
            'date' => 'nullable|date',
            'time' => 'nullable|date_format:H:i',
        ]);

        $appointment->status = $request->status;
        $appointment->appointment_date = $request->date;

        if ($request->time) {
            $appointment->appointment_time = date('H:i', strtotime($request->time));
        }

        $appointment->save();

        return redirect()->route('appointments.index')
            ->with('success', 'Appointment updated successfully!');
    }
}
