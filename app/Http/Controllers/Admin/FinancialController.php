<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Income;
use App\Models\Expense;
use Carbon\Carbon;

class FinancialController extends Controller
{
    public function index(Request $request)
    {
        // الشهر المحدد أو الشهر الحالي
        $month = $request->month ?? date('Y-m');

        $start = Carbon::parse($month . '-01')->startOfMonth();
        $end = Carbon::parse($month . '-01')->endOfMonth();

        $daysInMonth = $start->daysInMonth;
        $labels = [];
        $incomesData = [];
        $expensesData = [];

        for ($i = 1; $i <= $daysInMonth; $i++) {
            $date = $start->copy()->day($i)->toDateString();
            $labels[] = $i;

            // مجموع الدخل لليوم
            $income = Income::whereDate('income_date', $date)->sum('amount');
            $incomesData[] = (float) $income;

            // مجموع المصاريف لليوم
            $expense = Expense::whereDate('expense_date', $date)->sum('amount');
            $expensesData[] = (float) $expense;
        }

        // حساب الأرباح لكل يوم
        $profitData = [];
        foreach($incomesData as $key => $income) {
            $profitData[$key] = $income - $expensesData[$key];
        }

        return view('admin.financial.index', compact(
            'labels', 'incomesData', 'expensesData', 'profitData', 'month'
        ));
    }
}
