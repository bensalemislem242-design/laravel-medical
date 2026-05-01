<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Appointment;
use App\Models\Invoice;
use App\Enums\UserRoles;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    { 
        // ==============================
        // Badge Notification: Appointments New / Status Changed
        // ==============================
        $newAppointmentsCount = Appointment::where('is_new', true)->count();

        // ==============================
        // Users Stats
        // ==============================
        $doctors  = User::where('role', UserRoles::DOCTOR)->count();
        $patients = User::where('role', UserRoles::PATIENT)->count();

        // ==============================
        // Appointments Stats
        // ==============================
        $appointmentsTotal     = Appointment::count();
        $appointmentsConfirmed = Appointment::where('status', 'confirmed')->count();
        $appointmentsPending   = Appointment::where('status', 'pending')->count();
        $appointmentsCanceled  = Appointment::where('status', 'canceled')->count();

        $appointmentsConfirmedPercent = $appointmentsTotal 
            ? round(($appointmentsConfirmed / $appointmentsTotal) * 100, 2) : 0;

        $appointmentsPendingPercent = $appointmentsTotal 
            ? round(($appointmentsPending / $appointmentsTotal) * 100, 2) : 0;

        $appointmentsCanceledPercent = $appointmentsTotal 
            ? round(($appointmentsCanceled / $appointmentsTotal) * 100, 2) : 0;

        // ==============================
        // Invoices Stats
        // ==============================
        $totalInvoices = Invoice::count();
        $totalPaid     = Invoice::where('status', 'Paid')->sum('amount');
        $totalUnpaid   = Invoice::where('status', 'Unpaid')->sum('amount');

        $totalRevenue      = $totalPaid;
        $totalPaidCount    = Invoice::where('status', 'Paid')->count();
        $totalUnpaidCount  = Invoice::where('status', 'Unpaid')->count();

        // ==============================
        // Monthly Revenue (Paid Invoices)
        // ==============================
        $monthlyRevenue = [];
        for ($month = 1; $month <= 12; $month++) {
            $monthlyRevenue[] = Invoice::whereYear('created_at', Carbon::now()->year)
                ->whereMonth('created_at', $month)
                ->where('status', 'Paid')
                ->sum('amount');
        }

        // ==============================
        // Pass all variables to the view
        // ==============================
        return view('dashboard', compact(
            'newAppointmentsCount',   // Badge Notification
            'patients',
            'doctors',
            'appointmentsTotal',
            'appointmentsConfirmed',
            'appointmentsPending',
            'appointmentsCanceled',
            'appointmentsConfirmedPercent',
            'appointmentsPendingPercent',
            'appointmentsCanceledPercent',
            'totalInvoices',
            'totalRevenue',
            'totalPaid',
            'totalUnpaid',
            'totalPaidCount',
            'totalUnpaidCount',
            'monthlyRevenue'
        ));
    }
}
