<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\Appointment;
use App\Http\Controllers\Controller;
use App\Enums\UserRoles;
use App\Notifications\NewAppointmentNotification;
use Illuminate\Support\Facades\Notification;

class AppointmentApiController extends Controller
{
    /**
     * Request a new appointment from patient
     */
    public function requestAppointment(Request $request)
    {
        try {
            // Validate the request
            $request->validate([
                'hospital_id' => 'required|integer|exists:hospitals,id',
                'motivation' => 'required|string|min:3|max:1000',
                'appointment_date' => 'required|date',
                'start_time' => 'required|string',
                'end_time' => 'required|string',
            ]);

            // Get authenticated user
            $user = $request->user();
            
            if (!$user) {
                return response()->json([
                    'success' => false,
                    'message' => 'User not authenticated'
                ], 401);
            }

            // Check if user has PATIENT role
            if ($user->role !== UserRoles::PATIENT) {
                return response()->json([
                    'success' => false,
                    'message' => 'Only patients can request appointments'
                ], 403);
            }

            // Create the appointment
            $appointment = Appointment::create([
                'hospital_id' => $request->hospital_id,
                'patient_id' => $user->id,
                'motivation' => $request->motivation,
                'status' => 'Pending',
                'is_new' => 1,
                'appointment_date' => $request->appointment_date,
                'start_time' => $request->start_time,
                'end_time' => $request->end_time,
                 'date' => $request->appointment_date, 
                 'user_id' => $user->id,//
                 

            ]);

            // Load relationships
            $appointment->load(['hospital', 'patient', 'doctor']);

            // Send notification to admins and doctors
            $adminsAndDoctors = \App\Models\User::whereIn('role', [
                UserRoles::ADMIN,
                UserRoles::DOCTOR
            ])->get();
            
            if ($adminsAndDoctors->count() > 0) {
                Notification::send($adminsAndDoctors, new NewAppointmentNotification($appointment));
            }

            return response()->json([
                'success' => true,
                'message' => 'Appointment request sent successfully',
                'data' => $appointment
            ], 201);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to request appointment: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get all appointments for the authenticated patient
     */
    public function getAppointments(Request $request)
    {
        try {
            $user = $request->user();
            
            if (!$user) {
                return response()->json([
                    'success' => false,
                    'message' => 'User not authenticated'
                ], 401);
            }

            $appointments = Appointment::where('patient_id', $user->id)
                ->with(['hospital', 'doctor'])
                ->orderBy('created_at', 'desc')
                ->get();

            return response()->json([
                'success' => true,
                'data' => $appointments,
                'count' => $appointments->count()
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to get appointments: ' . $e->getMessage()
            ], 500);
        }
    }

public function show($id)
{
    $appointment = Appointment::with(['doctor', 'hospital', 'patient'])
        ->find($id);

    if (!$appointment) {
        return response()->json([
            'success' => false,
            'message' => 'Appointment not found',
            'debug_id' => $id
        ], 404);
    }

    return response()->json([
        'success' => true,
        'data' => $appointment
    ]);
}



    /**
     * Get appointment by ID
     */
public function getResponses(Request $request)
{
    $user = $request->user();

    if (!$user) {
        return response()->json([
            'success' => false,
            'message' => 'Unauthenticated'
        ], 401);
    }

    $appointments = Appointment::where(function ($q) use ($user) {
            $q->where('patient_id', $user->id)
              ->orWhere('doctor_id', $user->id);
        })
        ->with([
            'doctor:id,name,email',
            'patient:id,name,email',
            'hospital:id,name'
        ])
        ->orderBy('created_at', 'desc')
        ->get();

    return response()->json([
        'success' => true,
        'data' => $appointments
    ]);
}





    /**
     * Cancel an appointment
     */
    public function cancelAppointment(Request $request, $id)
    {
        try {
            $user = $request->user();
            
            if (!$user) {
                return response()->json([
                    'success' => false,
                    'message' => 'User not authenticated'
                ], 401);
            }

            $appointment = Appointment::where('id', $id)
                ->where('patient_id', $user->id)
                ->first();

            if (!$appointment) {
                return response()->json([
                    'success' => false,
                    'message' => 'Appointment not found'
                ], 404);
            }

            if ($appointment->status !== 'Pending') {
                return response()->json([
                    'success' => false,
                    'message' => 'Only pending appointments can be cancelled'
                ], 400);
            }

            $appointment->update([
                'status' => 'Cancelled',
                'is_new' => 0
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Appointment cancelled successfully',
                'data' => $appointment
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to cancel appointment: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Create appointment with doctor limit check
     */
    public function createAppointment(Request $request)
    {
        $request->validate([
            'hospital_id' => 'required|exists:hospitals,id',
            'doctor_id' => 'required|exists:users,id',
            'motivation' => 'required|string|min:3|max:1000',
            'appointment_date' => 'required|date',
            'start_time' => 'required',
            'end_time' => 'required',
        ]);

        // Check doctor limit: max 20 appointments per day
        $doctorAppointmentsCount = Appointment::where('doctor_id', $request->doctor_id)
            ->where('appointment_date', $request->appointment_date)
            ->count();

        if ($doctorAppointmentsCount >= 20) {
            return response()->json([
                'success' => false,
                'message' => 'Doctor already has 20 appointments for this day!'
            ], 400);
        }

        $appointment = Appointment::create([
            'hospital_id' => $request->hospital_id,
            'doctor_id' => $request->doctor_id,
            'patient_id' => auth()->id(),
            'motivation' => $request->motivation,
            'appointment_date' => $request->appointment_date,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'status' => 'Pending',
        ]);

        // Load relationships
        $appointment->load(['doctor.specialty', 'hospital', 'patient']);

        return response()->json([
            'success' => true,
            'appointment' => $appointment
        ], 201);
    }
}
