<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Expense;

class ExpenseController extends Controller
{
    public function index()
    {
        $expenses = Expense::latest()->get();
        $totalExpenses = $expenses->sum('amount'); // Will be negative
        return view('expenses.index', compact('expenses', 'totalExpenses'));
    }

    public function create()
    {
        return view('expenses.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'description' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0.01',
            'date' => 'required|date',
        ]);

        Expense::create($request->all());

        return redirect()->route('expenses.index')->with('success', 'Expense recorded successfully.');
    }
}
