<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CounterSalesDetail;
use App\Models\User;

class SalesReportController extends Controller
{
    // Show sales report with filtering
    public function index(Request $request)
    {
        $cashiers = User::where('is_admin', 0)->get();
        $query = CounterSalesDetail::with('user');

        // Filter by cashier
        if ($request->filled('cashier_id')) {
            $query->where('user_id', $request->cashier_id);
        }

        // Filter by date range
        if ($request->filled('from_date') && $request->filled('to_date')) {
            $query->whereBetween('created_at', [
                $request->from_date . ' 00:00:00',
                $request->to_date . ' 23:59:59'
            ]);
        }

        // Latest first
        $sales = $query->orderBy('created_at', 'desc')->get();

        return view('reports.sales_reports.sales_by_cashier', compact('sales', 'cashiers'));
    }

    // Print version of the sales report
    public function print(Request $request)
    {
        $query = CounterSalesDetail::with('user');

        if ($request->filled('cashier_id')) {
            $query->where('user_id', $request->cashier_id);
        }

        if ($request->filled('from_date') && $request->filled('to_date')) {
            $query->whereBetween('created_at', [
                $request->from_date . ' 00:00:00',
                $request->to_date . ' 23:59:59'
            ]);
        }

        // Newest first for printing
        $sales = $query->orderBy('created_at', 'desc')->get();
        $cashier = $request->filled('cashier_id') ? User::find($request->cashier_id) : null;

        return view('reports.sales_reports.print_sales_report', compact('sales', 'cashier', 'request'));
    }
}
