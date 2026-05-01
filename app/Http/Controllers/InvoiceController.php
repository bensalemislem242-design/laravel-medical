<?php

namespace App\Http\Controllers;
use Carbon\Carbon;
use App\Models\Invoice;
use App\Models\Patient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class InvoiceController extends Controller
{
   public function index()
{
   
    $invoices = Invoice::with('patient')->latest()->get();

    // Total Revenue (paid only)
    $totalRevenue = Invoice::where('status', 'paid')->sum('amount');

    // Monthly Revenue
    $monthlyRevenue = Invoice::where('status', 'paid')
        ->whereMonth('invoice_date', Carbon::now()->month)
        ->whereYear('invoice_date', Carbon::now()->year)
        ->sum('amount');

    // Unpaid Amount
    $unpaidAmount = Invoice::where('status', 'unpaid')->sum('amount');

    // Overdue count (unpaid & date < today)
    $overdueCount = Invoice::where('status', 'unpaid')
        ->whereDate('invoice_date', '<', Carbon::today())
        ->count();

    return view('invoices.index', compact(
        'invoices',
        'totalRevenue',
        'monthlyRevenue',
        'unpaidAmount',
        'overdueCount'
    ));
}
public function revenueChart()
{
    // نجيب غير الفواتير المدفوعة
    $invoices = Invoice::where('status', 'paid')->get();

    // نجمع revenue حسب الشهر
    $revenues = [];

    foreach ($invoices as $invoice) {
        $month = \Carbon\Carbon::parse($invoice->invoice_date)->format('F');

        if (!isset($revenues[$month])) {
            $revenues[$month] = 0;
        }

        $revenues[$month] += $invoice->total;
    }

    return view('invoices.revenue-chart', compact('revenues'));
}

public function dashboard()
{
    $year = date('Y');

    $invoices = Invoice::whereYear('invoice_date', $year)->get();

    $totalInvoices = $invoices->count();
    $totalRevenue = $invoices->sum('amount');

    $paid = $invoices->where('status', 'paid');
    $unpaid = $invoices->where('status', 'unpaid');

    $totalPaid = $paid->sum('amount');
    $totalUnpaid = $unpaid->sum('amount');

    $monthlyRevenue = [];

    for ($i = 1; $i <= 12; $i++) {
        $monthlyRevenue[] = Invoice::whereYear('invoice_date', $year)
            ->whereMonth('invoice_date', $i)
            ->where('status', 'paid')
            ->sum('amount');
    }

    return view('dashboard.statistics', compact(
        'totalInvoices',
        'totalRevenue',
        'totalPaid',
        'totalUnpaid',
        'monthlyRevenue'
    ));
}



public function calendar()
{
    $invoices = Invoice::where('status', 'unpaid')->get();

    return view('invoices.calendar', compact('invoices'));
}

// صفحة unpaid حسب التاريخ
public function unpaidByDate($date) {
    $invoices = Invoice::where('status', 'unpaid')
                        ->where('invoice_date', $date)
                        ->get();

    return view('invoices.unpaid', compact('invoices', 'date'));
}
public function calendarEvents()
{
    // جلب الفواتير غير المسددة فقط
    $invoices = Invoice::where('status', 'unpaid')->get();

    $events = [];

    foreach ($invoices as $invoice) {
        // اللون أحمر إذا فاتت تاريخ الفاتورة
        $color = $invoice->invoice_date < now() ? 'red' : 'orange';

        $events[] = [
            'title' => $invoice->title . ' - ' . $invoice->amount . 'TND',
            'start' => $invoice->invoice_date,
            'color' => $color,
            'url' => route('invoices.show', $invoice->id) // رابط مباشر للفاتورة
        ];
    }

    return response()->json($events);
}


    public function create()
    {
        $patients = Patient::all();
        return view('invoices.create', compact('patients'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'amount' => 'required|numeric',
            'invoice_date' => 'required|date',
            'status' => 'required|in:paid,unpaid',
            'patient_id' => 'nullable|exists:patients,id',
        ]);

        Invoice::create($request->all());

        return redirect()->route('invoices.index')->with('success', 'Invoice added successfully!');
    }

    public function show(Invoice $invoice)
    {
        return view('invoices.show', compact('invoice'));
    }

    public function edit(Invoice $invoice)
    {
        $patients = Patient::all();
        return view('invoices.edit', compact('invoice', 'patients'));
    }

    public function update(Request $request, Invoice $invoice)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'amount' => 'required|numeric',
            'invoice_date' => 'required|date',
            'status' => 'required|in:paid,unpaid',
            'patient_id' => 'nullable|exists:patients,id',
        ]);

        $invoice->update($request->all());

        return redirect()->route('invoices.index')->with('success', 'Invoice updated successfully!');
    }

    public function destroy(Invoice $invoice)
    {
        $invoice->delete();
        return redirect()->route('invoices.index')->with('success', 'Invoice deleted successfully!');
    }
    public function unpaid()
    {
        $invoices = Invoice::with('patient')
                        ->where('status', 'unpaid')
                        ->latest()
                        ->get();

        return view('invoices.unpaid', compact('invoices'));
    }
    public function paid()
{
    $invoices = \App\Models\Invoice::with('patient')
                    ->where('status', 'paid')
                    ->latest()
                    ->get();

    return view('invoices.paid', compact('invoices'));
}
public function print($id)
{
    $invoice = \App\Models\Invoice::with('patient')->findOrFail($id);

    return view('invoices.print', compact('invoice'));
}

    
}
