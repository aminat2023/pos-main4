<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CounterSalesDetail;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;

class ProfitReportController extends Controller
{
    public function index(Request $request)
    {
        $cashiers = User::where('is_admin', 0)->get();
        return view('reports.profit.index', compact('cashiers'));
    }

    public function print(Request $request)
    {
        $from = $request->from_date ?? now()->startOfMonth()->toDateString();
        $to = $request->to_date ?? now()->toDateString();
        $cashier = null;

        $report = $this->generateReport($from, $to, $request->cashier_id ?? null);

        if ($request->cashier_id) {
            $cashier = User::find($request->cashier_id);
        }

        return view('reports.profit.print_profit_report', [
            'profits' => $report,
            'from_date' => $from,
            'to_date' => $to,
            'cashier' => $cashier,
        ]);
    }

    public function exportPdf(Request $request)
    {
        $from = $request->input('from_date', now()->startOfMonth()->toDateString());
        $to = $request->input('to_date', now()->toDateString());
        $cashierId = $request->input('cashier_id');
    
        $report = $this->generateReport($from, $to, $cashierId);
    
        $cashier = $cashierId ? User::find($cashierId) : null;
    
        $pdf = Pdf::loadView('reports.profit.profit_report_pdf', [
            'profits' => $report,
            'from_date' => $from,
            'to_date' => $to,
            'cashier' => $cashier,
        ]);
    
        return $pdf->download('profit_report.pdf');
    }

    public function exportExcel(Request $request)
    {
        $from = $request->input('from_date', now()->startOfMonth()->toDateString());
        $to = $request->input('to_date', now()->toDateString());
        $cashierId = $request->input('cashier_id');

        return Excel::download(new \App\Exports\ProfitExport($from, $to, $cashierId), 'profit_report.xlsx');
    }

    /**
     * Generate profit report data
     *
     * @param string $from Starting date (Y-m-d)
     * @param string $to Ending date (Y-m-d)
     * @param int|null $cashierId Optional cashier user_id filter
     * @return array
     */
    private function generateReport(string $from, string $to, ?int $cashierId = null): array
    {
        $query = CounterSalesDetail::with('user')
            ->whereBetween('created_at', [$from . ' 00:00:00', $to . ' 23:59:59']);

        if ($cashierId) {
            $query->where('user_id', $cashierId);
        }

        $sales = $query->orderBy('created_at')->get();

        $profits = [];
        foreach ($sales as $sale) {
            $profit = $sale->profit ?? (($sale->selling_price - $sale->cost_price) * $sale->quantity);

            $profits[] = [
                'date' => $sale->created_at->format('Y-m-d'),
                'product' => $sale->product_name,
                'cashier' => $sale->user->name ?? 'N/A',
                'quantity' => $sale->quantity,
                'profit' => $profit,
            ];
        }

        return $profits;
    }
}
