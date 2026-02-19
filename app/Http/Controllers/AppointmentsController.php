<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Doctor;
use App\Models\Patient;
use Illuminate\Http\Request;

class AppointmentsController extends Controller
{
    // عرض كل المواعيد
    public function index() {
        $appointments = Appointment::with('doctor', 'patient')->get();
        return view('appointments.index', compact('appointments'));
    }

    // صفحة إنشاء موعد
    public function create()
{
    $doctors = Doctor::all(); // نجيبوا جميع الأطباء

    return view('appointments.create', compact('doctors'));
}
    // تخزين الموعد في قاعدة البيانات
    public function store(Request $request)
{
    $request->validate([
        'motivation' => 'required',
        'date' => 'required',
        'start_time' => 'required',
        'end_time' => 'required',
        'doctor_id' => 'required'
    ]);

    Appointment::create($request->all());

    return redirect()->route('appointments.index')
           ->with('success', 'Appointment created successfully');
}


    // صفحة تعديل موعد
    public function edit(Appointment $appointment) {
        $doctors = Doctor::all();
        $patients = Patient::all();
        return view('appointments.edit', compact('appointment', 'doctors', 'patients'));
    }

    // تحديث موعد
    public function update(Request $request, Appointment $appointment) {
        $request->validate([
            'motivation' => 'required|string',
            'date' => 'required|date',
            'start_time' => 'required',
            'end_time' => 'required',
            'doctor_id' => 'required|exists:doctors,id',
            'patient_id' => 'required|exists:patients,id',
        ]);

        $appointment->update($request->all());

        return redirect()->route('appointments.index')
                         ->with('success', 'Appointment updated successfully!');
    }

    // حذف موعد
    public function destroy(Appointment $appointment) {
        $appointment->delete();
        return redirect()->route('appointments.index')
                         ->with('success', 'Appointment deleted successfully!');
    }
}
