<?php


namespace App\Http\Controllers;

use App\Models\CounterCart;
use Illuminate\Http\Request;
use App\Models\CounterSalesDetail;
use App\Models\User;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf; // ✅ Correct import
class ReportController extends Controller
{
    public function counterSalesReport(Request $request)
    {
        $query = CounterSalesDetail::with(['cashier', 'product']);

        if ($request->filled('date')) {
            $query->whereDate('created_at', $request->date);
        }

        if ($request->filled('cashier_id')) {
            $query->where('cashier_id', $request->cashier_id);
        }

        if ($request->filled('payment_method')) {
            $query->where('payment_method', $request->payment_method);
        }

        $sales = $query->orderByDesc('created_at')->get();
        $cashiers = User::where('role', 'cashier')->get();
        $carts = CounterCart::with(['user', 'product'])->get();

        return view('reports.counter_sales_report', compact('sales', 'cashiers'));
    }

    public function export(Request $request)
    {
        $type = $request->type;

        $query = CounterSalesDetail::with(['cashier', 'product']);

        if ($request->filled('date')) {
            $query->whereDate('created_at', $request->date);
        }

        if ($request->filled('cashier_id')) {
            $query->where('user_id', $request->cashier_id);
        }

        if ($request->filled('payment_method')) {
            $query->where('payment_method', $request->payment_method);
        }

        $sales = $query->get();

        if ($type === 'pdf') {
            $pdf = PDF::loadView('exports.counter_sales_pdf', compact('sales'));
            return $pdf->download('counter_sales_report.pdf');
        } elseif ($type === 'excel') {
            return Excel::download(new \App\Exports\CounterSalesExport($sales), 'counter_sales_report.xlsx');
        }

        return back()->with('error', 'Invalid export type');
    }

    
}
