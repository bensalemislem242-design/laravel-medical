<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\Notification;
use App\Models\Scan;

use App\Http\Controllers\Api\DoctorApiController;
use App\Http\Controllers\Api\PatientApiController;
use App\Http\Controllers\Api\PasswordResetController;
use App\Http\Controllers\Admin\HospitalController;
use App\Http\Controllers\Api\AppointmentApiController;
use App\Http\Controllers\DoctorsController;
use App\Http\Controllers\Api\PatientController;
use App\Http\Controllers\PrescriptionsController;
use App\Http\Controllers\Api\PrescriptionController;
use App\Http\Controllers\Api\NotificationApiController;

/*
|--------------------------------------------------------------------------
| PUBLIC ROUTES
|--------------------------------------------------------------------------
*/

// DOCTOR AUTH
Route::post('/doctor/signup', [DoctorApiController::class, 'signup']);
Route::post('/doctor/login', [DoctorApiController::class, 'login']);

// PATIENT AUTH
Route::post('/patient/signup', [PatientApiController::class, 'signup']);
Route::post('/patient/login', [PatientApiController::class, 'login']);

// DOCTORS
Route::get('/doctors', [DoctorsController::class, 'apiIndex']);

// SPECIALTIES
Route::get('/specialties', [DoctorsController::class, 'getSpecialties']);

// FILTER DOCTORS
Route::get('/doctors/filter', [DoctorsController::class, 'filterDoctors']);

// PATIENTS
Route::get('/patients', [PatientController::class, 'index']);
Route::get('/patients/{id}', [PatientController::class, 'show']);

// HOSPITALS
Route::get('/hospitals', [HospitalController::class, 'getHospitals']);

// PASSWORD RESET
Route::prefix('forgot-password')->group(function () {
    Route::post('/send-otp', [PasswordResetController::class, 'sendOtp']);
    Route::post('/verify-otp', [PasswordResetController::class, 'verifyOtp']);
    Route::post('/reset', [PasswordResetController::class, 'resetPassword']);
    Route::post('/resend-otp', [PasswordResetController::class, 'resendOtp']);
});
Route::get('/scans/{patient_id}', function ($patient_id) {
    return Scan::where('patient_id', $patient_id)->get()->map(function ($scan) {
        return [
            'id' => $scan->id,
            'type' => $scan->type,
            'url' => config('app.url') . '/storage/' . $scan->scan_path, // ✅ الصحيح
            'date' => $scan->created_at,
        ];
    });
});

// TEST
Route::get('/test', function () {
    return response()->json([
        'success' => true,
        'message' => 'API is working!',
        'timestamp' => now()
    ]);
});


/*
|--------------------------------------------------------------------------
| PROTECTED ROUTES
|--------------------------------------------------------------------------
*/

Route::middleware('auth:sanctum')->group(function () {

    // USER
    Route::get('/user', function (Request $request) {
        return response()->json([
            'success' => true,
            'user' => $request->user(),
            'role' => $request->user()->role,
        ]);
    });

    // PROFILE
    Route::get('/patient/profile', [PatientApiController::class, 'profile']);
    Route::put('/patient/profile', [PatientApiController::class, 'updateProfile']);

    // APPOINTMENTS
    Route::post('/appointments/request', [AppointmentApiController::class, 'requestAppointment']);
    Route::get('/appointments', [AppointmentApiController::class, 'getAppointments']);
    Route::get('/appointments/responses', [AppointmentApiController::class, 'getResponses']);
    Route::get('/appointments/{id}', [AppointmentApiController::class, 'show']);

    Route::post('/appointments/create', [AppointmentApiController::class, 'createAppointment']);
    Route::patch('/appointments/{id}/cancel', [AppointmentApiController::class, 'cancelAppointment']);

    // RESPONSES
    Route::get('/appointments/responses', [AppointmentApiController::class, 'getResponses']);

    // NOTIFICATIONS
    Route::get('/notifications', [NotificationApiController::class, 'index']);
    Route::get('/notifications/{id}', [NotificationApiController::class, 'show']);

    Route::post('/notifications/{id}/read', function ($id) {
        $notification = Notification::findOrFail($id);
        $notification->is_read = true;
        $notification->save();

        return response()->json([
            'success' => true,
            'message' => 'Notification marked as read',
        ]);
    });

    // LOGOUT
    Route::post('/logout', function (Request $request) {
        $request->user()->currentAccessToken()->delete();
        return response()->json([
            'success' => true,
            'message' => 'Logged out successfully'
        ]);
    });
});
