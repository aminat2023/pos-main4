<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CounterSalesDetail;
use App\Models\User;
use Carbon\Carbon;

class ProfitReportController extends Controller
{
    public function index(Request $request)
    {
        $cashiers = User::where('is_admin', 0)->get();
        return view('reports.profit.index', compact('cashiers'));
    }

    public function print(Request $request)
    {
        $query = CounterSalesDetail::with('user');
    
        // Capture filters from the request
        $from = $request->from_date ?? now()->startOfMonth()->toDateString();
        $to = $request->to_date ?? now()->toDateString();
        $cashier = null;
    
        if ($request->filled('cashier_id')) {
            $query->where('user_id', $request->cashier_id);
            $cashier = User::find($request->cashier_id);
        }
    
        $query->whereBetween('created_at', [$from . ' 00:00:00', $to . ' 23:59:59']);
        $sales = $query->orderBy('created_at')->get();
    
        $profits = [];
        $totalProfit = 0;
    
        foreach ($sales as $sale) {
            $profit = $sale->profit ?? (($sale->selling_price - $sale->cost_price) * $sale->quantity);
            $profits[] = [
                'date' => $sale->created_at->format('Y-m-d'),
                'product' => $sale->product_name,
                'cashier' => $sale->user->name ?? 'N/A',
                'quantity' => $sale->quantity,
                'profit' => $profit,
            ];
            $totalProfit += $profit;
        }
    
        return view('reports.profit.print_profit_report', [
            'profits' => $profits,
            'from_date' => $from,
            'to_date' => $to,
            'cashier' => $cashier,
        ]);
    }
    
}
