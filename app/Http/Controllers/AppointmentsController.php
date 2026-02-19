<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\User;
use App\Models\Doctor;
use App\Enums\UserRoles; // pour les rôles
use Illuminate\Http\Request;

class AppointmentsController extends Controller
{
    // عرض كل المواعيد
    public function index() {
        $appointments = Appointment::with('doctor', 'patient', 'user')->get();
        return view('appointments.index', compact('appointments'));
    }

    // صفحة إنشاء موعد
    public function create() {
        $doctors = User::where('role', UserRoles::DOCTOR)->get();
        return view('appointments.create', compact('doctors'));
    }

    // حفظ الموعد الجديد
    public function store(Request $request) {
        $request->validate([
            'motivation' => 'required|string',
            'date' => 'required|date',
            'start_time' => 'required',
            'end_time' => 'required',
            'doctor_id' => 'required|exists:users,id',
            'patient_id' => 'required|exists:users,id', // ajouter patient
        ]);

        Appointment::create([
            'doctor_id' => $request->doctor_id,
            'patient_id' => $request->patient_id,
            'motivation' => $request->motivation,
            'date' => $request->date,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'user_id' => auth()->id(), // <- IMPORTANT, utilisateur connecté
        ]);

        return redirect()->route('appointments.index')
                         ->with('success', 'Appointment created successfully!');
    }

    // صفحة تعديل الموعد
    public function edit(Appointment $appointment) {
        $doctors = User::where('role', UserRoles::DOCTOR)->get();
        return view('appointments.edit', compact('appointment', 'doctors'));
    }

    // تحديث الموعد
    public function update(Request $request, Appointment $appointment) {
        $request->validate([
            'motivation' => 'required|string',
            'date' => 'required|date',
            'start_time' => 'required',
            'end_time' => 'required',
            'doctor_id' => 'required|exists:users,id',
            'patient_id' => 'required|exists:users,id', // ajouter patient
        ]);

        $appointment->update([
            'doctor_id' => $request->doctor_id,
            'patient_id' => $request->patient_id,
            'motivation' => $request->motivation,
            'date' => $request->date,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
        ]);

        return redirect()->route('appointments.index')
                         ->with('success', 'Appointment updated successfully!');
    }

    // حذف الموعد
    public function destroy(Appointment $appointment) {
        $appointment->delete();
        return redirect()->route('appointments.index')
                         ->with('success', 'Appointment deleted successfully!');
    }
}
