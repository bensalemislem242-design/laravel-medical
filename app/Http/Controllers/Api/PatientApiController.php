<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Patient;
use Illuminate\Support\Facades\Hash;
use App\Enums\UserRoles;
use Illuminate\Support\Facades\DB;

class PatientApiController extends Controller
{
    public function signup(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username',
            'phone' => 'required|string|max:20',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
            'noSSocial' => 'required|string|max:50|unique:patients,noSSocial',
            'dob' => 'required|date',
        ]);

        try {
            DB::beginTransaction();

            $user = User::create([
                'name' => $request->name,
                'lastname' => $request->lastname,
                'username' => $request->username,
                'phone' => $request->phone,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => UserRoles::PATIENT
            ]);

            $patient = Patient::create([
                'user_id' => $user->id,
                'name' => $request->name,
                'lastname' => $request->lastname,
                'username' => $request->username,
                'phone' => $request->phone,
                'email' => $request->email,
                'noSSocial' => $request->noSSocial,
                'dob' => $request->dob,
            ]);

            DB::commit();
            $user->load('patient');

            return response()->json([
                'success' => true,
                'message' => 'Patient registered successfully',
                'user' => $user,
                'patient' => $user->patient,
            ], 201);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Registration failed: ' . $e->getMessage()
            ], 500);
        }
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string|min:6',
        ]);

        try {
            $user = User::where('email', $request->email)
                        ->where('role', UserRoles::PATIENT)
                        ->first();

            if (!$user || !Hash::check($request->password, $user->password)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid credentials'
                ], 401);
            }

            $token = $user->createToken('auth_token')->plainTextToken;
            $user->load('patient');

            return response()->json([
                'success' => true,
                'message' => 'Patient logged in successfully',
                'user' => $user,
                'patient' => $user->patient,
                'access_token' => $token,
                'token_type' => 'Bearer'
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Login failed: ' . $e->getMessage()
            ], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $patient = Patient::findOrFail($id);
            $patient->delete();

            return response()->json([
                'success' => true,
                'message' => 'Patient and associated user deleted successfully'
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Deletion failed: ' . $e->getMessage()
            ], 500);
        }
    }

    public function destroyUser($id)
    {
        try {
            $user = User::findOrFail($id);
            
            if ($user->role !== UserRoles::PATIENT) {
                return response()->json([
                    'success' => false,
                    'message' => 'User is not a patient'
                ], 400);
            }
            
            $user->delete();

            return response()->json([
                'success' => true,
                'message' => 'User and associated patient deleted successfully'
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Deletion failed: ' . $e->getMessage()
            ], 500);
        }
    }

    public function destroyByEmail(Request $request)
    {
        $request->validate([
            'email' => 'required|email'
        ]);

        try {
            $user = User::where('email', $request->email)
                        ->where('role', UserRoles::PATIENT)
                        ->first();

            if (!$user) {
                return response()->json([
                    'success' => false,
                    'message' => 'Patient not found'
                ], 404);
            }
            
            $user->delete();

            return response()->json([
                'success' => true,
                'message' => 'Patient and associated user deleted successfully'
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Deletion failed: ' . $e->getMessage()
            ], 500);
        }
    }

    public function destroyAll()
    {
        try {
            DB::beginTransaction();
            
            $patients = Patient::all();
            $count = $patients->count();
            
            foreach ($patients as $patient) {
                $patient->delete();
            }
            
            DB::commit();
            
            return response()->json([
                'success' => true,
                'message' => "$count patients and their associated users deleted successfully"
            ], 200);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Deletion failed: ' . $e->getMessage()
            ], 500);
        }
    }

    public function profile(Request $request)
    {
        try {
            $user = $request->user();
            $user->load('patient');
            
            return response()->json([
                'success' => true,
                'data' => [
                    'user' => $user,
                    'patient' => $user->patient,
                ]
            ], 200);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch profile: ' . $e->getMessage()
            ], 500);
        }
    }

    public function updateProfile(Request $request)
    {
        try {
            $user = $request->user();
            $patient = $user->patient;
            
            $request->validate([
                'name' => 'sometimes|string|max:255',
                'lastname' => 'sometimes|string|max:255',
                'username' => 'sometimes|string|max:255|unique:users,username,' . $user->id,
                'phone' => 'sometimes|string|max:20',
                'email' => 'sometimes|email|unique:users,email,' . $user->id,
                'noSSocial' => 'sometimes|string|max:50|unique:patients,noSSocial,' . ($patient ? $patient->id : 'NULL'),
                'dob' => 'sometimes|date',
            ]);
            
            DB::beginTransaction();
            
            $userData = [];
            if ($request->has('name')) $userData['name'] = $request->name;
            if ($request->has('lastname')) $userData['lastname'] = $request->lastname;
            if ($request->has('username')) $userData['username'] = $request->username;
            if ($request->has('phone')) $userData['phone'] = $request->phone;
            if ($request->has('email')) $userData['email'] = $request->email;
            
            if (!empty($userData)) {
                $user->update($userData);
            }
            
            if ($patient) {
                $patientData = [];
                if ($request->has('name')) $patientData['name'] = $request->name;
                if ($request->has('lastname')) $patientData['lastname'] = $request->lastname;
                if ($request->has('username')) $patientData['username'] = $request->username;
                if ($request->has('phone')) $patientData['phone'] = $request->phone;
                if ($request->has('email')) $patientData['email'] = $request->email;
                if ($request->has('noSSocial')) $patientData['noSSocial'] = $request->noSSocial;
                if ($request->has('dob')) $patientData['dob'] = $request->dob;
                
                if (!empty($patientData)) {
                    $patient->update($patientData);
                }
            }
            
            DB::commit();
            
            $user->load('patient');
            
            return response()->json([
                'success' => true,
                'message' => 'Profile updated successfully',
                'data' => [
                    'user' => $user,
                    'patient' => $user->patient,
                ]
            ], 200);
            
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Update failed: ' . $e->getMessage()
            ], 500);
        }
    }

    public function uploadImage(Request $request)
    {
        try {
            $request->validate([
                'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);
            
            $user = $request->user();
            
            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $filename = time() . '_' . $user->id . '.' . $image->getClientOriginalExtension();
                $path = $image->storeAs('profile_images', $filename, 'public');
                
                if ($user->image && \Storage::disk('public')->exists($user->image)) {
                    \Storage::disk('public')->delete($user->image);
                }
                
                $user->image = $path;
                $user->save();
                
                return response()->json([
                    'success' => true,
                    'message' => 'Image uploaded successfully',
                    'data' => [
                        'image_url' => \Storage::url($path),
                        'image_path' => $path,
                    ]
                ], 200);
            }
            
            return response()->json([
                'success' => false,
                'message' => 'No image provided'
            ], 400);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Upload failed: ' . $e->getMessage()
            ], 500);
        }
    }
}