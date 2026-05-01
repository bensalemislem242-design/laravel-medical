<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Enums\UserRoles;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UsersController extends Controller
{
    // ================= USERS LIST =================
    public function index()
    {
        $users = User::all();
        return view('users.index', compact('users'));
    }

    // ================= CREATE FORM =================
    public function create()
    {
        return view('users.create');
    }

    // ================= STORE USER =================
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string',
            'lastname' => 'required|string',
            'username' => 'required|string|unique:users',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
            'role' => 'required|integer',
        ]);

        $data['password'] = Hash::make($data['password']);
        $data['role'] = (int) $data['role'];

        User::create($data);

        return redirect()->route('users.index')
            ->with('success', 'User created successfully');
    }

    // ================= EDIT =================
    public function edit(User $user)
    {
        return view('users.edit', compact('user'));
    }

    // ================= UPDATE =================
    public function update(Request $request, User $user)
    {
        $data = $request->validate([
            'name' => 'required|string',
            'lastname' => 'required|string',
            'username' => 'required|string|unique:users,username,' . $user->id,
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|min:6',
            'role' => 'required|integer',
        ]);

        if (!empty($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        } else {
            unset($data['password']);
        }

        $data['role'] = (int) $data['role'];

        $user->update($data);

        return redirect()->route('users.index')
            ->with('success', 'User updated successfully');
    }

    // ================= DELETE =================
    public function destroy(User $user)
    {
        $user->delete();

        return redirect()->route('users.index')
            ->with('success', 'User deleted successfully');
    }

    // ================= PATIENTS LIST =================
    public function patientsList()
    {
        $patients = User::where('role', UserRoles::PATIENT->value)->get();
        return view('users.patients', compact('patients'));
    }

    // ================= DOCTORS LIST =================
    public function doctorsList()
    {
        $doctors = User::where('role', UserRoles::DOCTOR->value)->get();
        return view('users.doctors', compact('doctors'));
    }
}
