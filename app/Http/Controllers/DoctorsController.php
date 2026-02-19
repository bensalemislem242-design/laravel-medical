<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use Illuminate\Http\Request;

class DoctorsController extends Controller
{
    public function index()
    {
        $doctors = Doctor::all();
        return view('doctors.index', compact('doctors'));
    }

    public function create()
    {
        return view('doctors.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'specialty' => 'required',
            'phone' => 'required',
            'email' => 'required|email',
        ]);

        Doctor::create($request->all());
        return redirect()->route('doctors.index')->with('success', 'Doctor added successfully!');
    }

    public function show(Doctor $doctor)
    {
        return view('doctors.show', compact('doctor'));
    }

    public function edit(Doctor $doctor)
    {
        return view('doctors.edit', compact('doctor'));
    }

    public function update(Request $request, Doctor $doctor)
    {
        $request->validate([
            'name' => 'required',
            'specialty' => 'required',
            'phone' => 'required',
            'email' => 'required|email',
        ]);

        $doctor->update($request->all());
        return redirect()->route('doctors.index')->with('success', 'Doctor updated successfully!');
    }

    public function destroy(Doctor $doctor)
    {
        $doctor->delete();
        return redirect()->route('doctors.index')->with('success', 'Doctor deleted successfully!');
    }
}
