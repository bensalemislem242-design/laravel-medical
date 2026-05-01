<?php

namespace App\Http\Controllers;
use App\Enums\UserRoles;

use App\Models\User;
use Illuminate\Http\Request;

class DoctorsController extends Controller
{
    public function index()
    {
        $doctors = User::where('role', 'DOCTOR')->get();
        return view('doctors.index', compact('doctors'));
    }
    public function getSpecialities()
{
    $specialities = User::where('role', UserRoles::DOCTOR)
        ->select('specialty')
        ->distinct()
        ->pluck('specialty');

    return response()->json($specialities);
}

public function apiIndex()
{
    $doctors = User::where('role', 'DOCTOR')->get();

    $formattedDoctors = $doctors->map(function ($doctor) {
        return [
            'id' => $doctor->id,
           'name' => $doctor->username . ' - ' . $doctor->name,

            'speciality' => $doctor->specialty,
            'email' => $doctor->email,
            'phone' => $doctor->phone, // 🔥 جديد
        ];
    });

    return response()->json($formattedDoctors);
}




    public function create()
    {
        return view('doctors.create');
    }

    public function store(Request $request)
    {
       $request->validate([
    'name' => 'required',
    'lastname' => 'required',
    'username' => 'required|unique:users,username',
    'specialty' => 'required',
    'phone' => 'required',
    'email' => 'required|email|unique:users,email',
]);



    User::create([
    'name' => $request->name,
    'lastname' => $request->lastname,
    'username' => $request->username,
    'specialty' => $request->specialty,
    'phone' => $request->phone,
    'email' => $request->email,
    'role' => UserRoles::DOCTOR,
    'password' => bcrypt('password123'),
]);


        return redirect()->route('doctors.index')->with('success', 'Doctor added successfully!');
    }

    public function show(User $doctor)
    {
        return view('doctors.show', compact('doctor'));
    }

    public function edit(User $doctor)
    {
        return view('doctors.edit', compact('doctor'));
    }

    public function update(Request $request, User $doctor)
{
    $request->validate([
    'name' => 'required',
    'lastname' => 'required',
    'username' => 'required|unique:users,username',
    'specialty' => 'required',
    'phone' => 'required',
    'email' => 'required|email|unique:users,email',
]);



    $doctor->update($request->only('name', 'specialty', 'phone', 'email'));

    return redirect()->route('doctors.index')->with('success', 'Doctor updated successfully!');
}
public function filterDoctors(Request $request)
{
    $hospitalId = $request->hospital_id;
    $specialty = $request->specialty;

    $query = User::where('role', UserRoles::DOCTOR);

    if ($hospitalId) {
        $query->where('hospital_id', $hospitalId);
    }

    if ($specialty && $specialty != "") {
        $query->where('specialty', $specialty);
    }

    $doctors = $query->get();

    return response()->json([
        'data' => $doctors->map(function ($doctor) {
            return [
                'id' => $doctor->id,
                'name' => $doctor->name,
                'specialty' => $doctor->specialty,
            ];
        })
    ]);
}

    public function destroy(User $doctor)
    {
        $doctor->delete();
        return redirect()->route('doctors.index')->with('success', 'Doctor deleted successfully!');
    }
}
