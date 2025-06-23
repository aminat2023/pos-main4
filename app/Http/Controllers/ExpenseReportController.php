<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ExpensesExport;

class ExpenseReportController extends Controller
{
    public function index(Request $request)
    {
        $query = Expense::query();

        // Filter by date range
        if ($request->filled('from_date') && $request->filled('to_date')) {
            $query->whereBetween('date', [$request->from_date, $request->to_date]);
        }

        // Filter by category if selected
        if ($request->expense_type === 'specific' && $request->filled('category')) {
            $query->where('category', $request->category);
        }

        $expenses = $query->latest()->get();
        $total = $expenses->sum('amount');

        // Fetch unique categories for dropdown
        $categories = Expense::distinct()->pluck('category');

        return view('reports.expenses.index', compact('expenses', 'total', 'request', 'categories'));
    }

    public function print(Request $request)
    {
        $query = Expense::query();

        // Filter by date range
        if ($request->filled('from_date') && $request->filled('to_date')) {
            $query->whereBetween('date', [$request->from_date, $request->to_date]);
        }

        // Filter by category if selected
        if ($request->expense_type === 'specific' && $request->filled('category')) {
            $query->where('category', $request->category);
        }

        $expenses = $query->latest()->get();
        $total = $expenses->sum('amount');

        return view('reports.expenses.print', compact('expenses', 'total', 'request'));
    }

    public function export(Request $request)
    {
        $type = $request->type;

        // For PDF export
        if ($type === 'pdf') {
            $query = Expense::query();

            if ($request->filled('from_date') && $request->filled('to_date')) {
                $query->whereBetween('date', [$request->from_date, $request->to_date]);
            }

            if ($request->expense_type === 'specific' && $request->filled('category')) {
                $query->where('category', $request->category);
            }

            $expenses = $query->get();
            $total = $expenses->sum('amount');

            $pdf = PDF::loadView('reports.expenses.print', compact('expenses', 'total', 'request'));
            return $pdf->download('expense_report.pdf');
        }

        // For Excel export
        if ($type === 'excel') {
            return Excel::download(new ExpensesExport($request->from_date, $request->to_date, $request->category ?? null), 'expense_report.xlsx');
        }

        return back()->with('error', 'Invalid export type');
    }
}
