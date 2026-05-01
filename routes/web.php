<?php

use App\Http\Controllers\AppointmentsController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\OrientationLtrController;
use App\Http\Controllers\PatientsController;
use App\Http\Controllers\PrescriptionsController;
use App\Http\Controllers\ScansController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\ForgotPasswordController;
use App\Http\Controllers\ResetPasswordController;
use App\Http\Controllers\Admin\FinancialController;
use App\Http\Controllers\Admin\ExpenseController;
use App\Http\Controllers\Admin\IncomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DoctorsController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\Admin\HospitalController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NotificationController;
use App\Models\Notification;
use Illuminate\Notifications\DatabaseNotification;

// ---------------------------
// Guest routes
// ---------------------------
Route::get('/', fn() => view('auth.login'))->middleware('guest');
Route::match(['get','post'], '/login', [AuthController::class, 'login'])->name('login')->middleware('guest');
Route::get('/forgot-password', [ForgotPasswordController::class, 'create'])->name('password.request');
Route::post('/forgot-password', [ForgotPasswordController::class, 'store'])->name('password.email');
Route::get('/reset-password/{token}', [ResetPasswordController::class, 'create'])->name('password.reset');
Route::post('/reset-password', [ResetPasswordController::class, 'store'])->name('password.update');

// ---------------------------
// Authenticated routes
// ---------------------------
Route::middleware('auth')->group(function () {

    // Logout & profile
    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/dashboard', [App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/profile', [ProfileController::class, 'update'])->name('profile.update');

    // ---------------------------
    // Admin-only routes
    // ---------------------------
    Route::middleware('user-role:ADMIN')->group(function () {
        Route::resource('users', UsersController::class);
        Route::post('/users/find', [UsersController::class, 'findByQuery'])->name('users.findByQuery');

        Route::prefix('admin')->group(function () {
            Route::resource('expenses', ExpenseController::class);
            Route::resource('incomes', IncomeController::class);
            Route::get('financial', [FinancialController::class, 'index'])->name('financial.index');
            Route::get('financial/details', [FinancialController::class, 'details'])->name('financial.details');
            Route::resource('hospitals', HospitalController::class);
        });
    });

    // ---------------------------
    // Admin + Doctor routes
    // ---------------------------
    Route::middleware('user-role:DOCTOR|ADMIN')->group(function () {

        // Patients
        Route::resource('patients', PatientsController::class);
        Route::post('/patients/find', [PatientsController::class, 'findByQuery'])->name('patients.findByQuery');
        Route::delete('/patients/{patient}', [PatientsController::class, 'destroy'])->name('patients.destroy');

        // Doctors
        Route::resource('doctors', DoctorsController::class);

        // Scans
        Route::resource('scans', ScansController::class);
        Route::get('/scans/{id}/download', [ScansController::class, 'download'])->name('scans.download');

        // Orientation Letters
        Route::resource('orientationLtr', OrientationLtrController::class);

        // Prescriptions
        Route::resource('prescriptions', PrescriptionsController::class);
        Route::get('/prescriptions/{id}/print', [PrescriptionsController::class, 'print'])->name('prescriptions.print');

        // Appointments
        Route::resource('appointments', AppointmentsController::class)->except(['edit']);
Route::get('/appointments/{appointment}/edit-status', [AppointmentsController::class, 'editStatus'])->name('appointments.editStatus');
Route::post('/appointments/{id}/update-status', [AppointmentsController::class, 'updateStatus'])->name('appointments.updateStatus');

        Route::get('/appointments-calendar', [AppointmentsController::class, 'calendar'])->name('appointments.calendar');
        Route::get('/appointments-by-date/{date}', [AppointmentsController::class, 'byDate'])->name('appointments.byDate');
        Route::get('/appointments/{id}', [AppointmentsController::class, 'show'])->name('appointments.show');
        Route::middleware(['auth'])->group(function () {
    Route::resource('appointments', AppointmentsController::class);
});

    });

    // ---------------------------
    // Patient routes (request appointments)
    // ---------------------------
    Route::middleware('user-role:PATIENT')->group(function () {
        Route::post('/appointments/request', [AppointmentsController::class, 'requestAppointment'])->name('appointments.request');
    });

    // ---------------------------
    // Notifications
    // ---------------------------
// page notifications
Route::get('/notifications', function () {
    return view('notifications.index');
})->middleware('auth')->name('notifications.index');

// mark as read
Route::get('/notifications/read/{id}', function ($id) {
    $notification = DatabaseNotification::find($id);
    if ($notification) {
        $notification->markAsRead();
    }
    return back();
})->name('notifications.markAsRead');

// delete
Route::delete('/notifications/delete/{id}', function ($id) {
    $notification = DatabaseNotification::find($id);
    if ($notification) {
        $notification->delete();
    }
    return back();
})->name('notifications.delete');
    // ---------------------------
    // Invoice routes
    // ---------------------------
    Route::resource('invoices', InvoiceController::class);
    Route::get('/invoices-unpaid', [InvoiceController::class, 'unpaid'])->name('invoices.unpaid');
    Route::get('/invoices-paid', [InvoiceController::class, 'paid'])->name('invoices.paid');
    Route::get('/invoices/{invoice}/print', [InvoiceController::class, 'print'])->name('invoices.print');
    Route::get('/invoices-revenue-chart', [InvoiceController::class, 'revenueChart'])->name('invoices.revenue_chart');
    Route::get('/invoices-calendar', [InvoiceController::class, 'calendar'])->name('invoices.calendar');
    Route::get('/unpaid/{date}', [InvoiceController::class, 'unpaidByDate'])->name('invoices.unpaidByDate');
    Route::get('/dashboard-statistics', [InvoiceController::class, 'dashboard'])->name('dashboard.statistics');
    Route::get('/invoices-calendar/events', [InvoiceController::class, 'calendarEvents'])->name('invoices.calendarEvents');

    // ---------------------------
    // Admin + Doctor + Secretary routes (extra)
    // ---------------------------
    Route::middleware('user-role:DOCTOR|SECRETARY|ADMIN')->group(function () {
        // Additional routes if needed
    });
});
