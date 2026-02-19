<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\User;
use Illuminate\Http\Request;

class AppointmentsController extends Controller
{
    // عرض كل المواعيد
    public function index() {
        $appointments = Appointment::all();
        return view('appointments.index', compact('appointments'));
    }

    // صفحة إنشاء موعد
    public function create() {
        $doctors = User::where('role', 1)->get(); // role 1 = doctor
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
        ]);

        Appointment::create($request->all());

        return redirect()->route('appointments.index')
                         ->with('success', 'Appointment created successfully!');
    }

    // صفحة تعديل الموعد
    public function edit(Appointment $appointment) {
        $doctors = User::where('role', 1)->get();
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
        ]);

        $appointment->update($request->all());

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
