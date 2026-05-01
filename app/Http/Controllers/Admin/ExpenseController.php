<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Expense;

class ExpenseController extends Controller
{
    public function index()
    {
        $expenses = Expense::orderBy('created_at', 'desc')->get();
        return view('admin.expenses.index', compact('expenses'));
    }

    public function create()
    {
        return view('admin.expenses.create');
    }

   public function store(Request $request)
{ $request->validate([
        'title' => 'required|string|max:255',
        'amount' => 'required|numeric',
        'expense_date' => 'required|date',
    ]);

    Expense::create([
    'title' => $request->title,
    'amount' => $request->amount,
    'expense_date' => $request->expense_date,
]);
    return redirect()->route('expenses.index')->with('success', 'Expense added successfully!');
}


    public function edit($id)
    {
        $expense = Expense::findOrFail($id);
        return view('admin.expenses.edit', compact('expense'));
    }

  public function update(Request $request, $id)
{
    $request->validate([
        'title' => 'required|string|max:255',
        'amount' => 'required|numeric',
        'expense_date' => 'required|date',
    ]);

    $expense = Expense::findOrFail($id);

    $expense->update([
        'title' => $request->title,
        'amount' => $request->amount,
        'expense_date' => $request->expense_date,
    ]);

    return redirect()->route('expenses.index')->with('success', 'Expense updated successfully.');
}

    public function destroy($id)
    {
        $expense = Expense::findOrFail($id);
        $expense->delete();

        return redirect()->route('expenses.index')->with('success', 'Expense deleted successfully.');
    }
}
