<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Income;

class IncomeController extends Controller
{
    public function index()
    {
        $incomes = Income::latest()->get();
        return view('admin.incomes.index', compact('incomes'));
    }

    public function create()
    {
        return view('admin.incomes.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'amount' => 'required|numeric',
            'income_date' => 'required|date',
        ]);

        Income::create($request->all());

        return redirect()->route('incomes.index')
            ->with('success', 'Income added successfully');
    }

    public function show(Income $income)
    {
        return view('admin.incomes.show', compact('income'));
    }

    public function edit(Income $income)
    {
        return view('admin.incomes.edit', compact('income'));
    }

    public function update(Request $request, Income $income)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'amount' => 'required|numeric',
            'income_date' => 'required|date',
        ]);

        $income->update($request->all());

        return redirect()->route('incomes.index')
            ->with('success', 'Income updated successfully');
    }

    public function destroy(Income $income)
    {
        $income->delete();

        return redirect()->route('incomes.index')
            ->with('success', 'Income deleted successfully');
    }
}
