<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CounterSalesDetail;
use App\Models\Expense;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;

class ProfitLossController extends Controller
{
    public function index()
    {
        return view('reports.profit_loss.generate');
    }

    public function print(Request $request)
    {
        $from = $request->input('from_date', now()->startOfMonth()->toDateString());
        $to = $request->input('to_date', now()->toDateString());

        $report = self::generateReport($from, $to);

        return view('reports.profit_loss.report', compact('report', 'from', 'to'));
    }

    public function exportPdf(Request $request)
    {
        $from = $request->input('from_date', now()->startOfMonth()->toDateString());
        $to = $request->input('to_date', now()->toDateString());

        $report = self::generateReport($from, $to);

        $pdf = Pdf::loadView('reports.profit_loss.profit_loss_pdf', compact('report', 'from', 'to'));
        return $pdf->download('profit_loss_report.pdf');
    }

    public function exportExcel(Request $request)
    {
        $from = $request->input('from_date', now()->startOfMonth()->toDateString());
        $to = $request->input('to_date', now()->toDateString());

        return Excel::download(new \App\Exports\ProfitLossExport($from, $to), 'profit_loss_report.xlsx');
    }

    public static function generateReport($from, $to)
    {
        $sales = CounterSalesDetail::whereBetween('created_at', [$from, $to])->get();
        $expenses = Expense::whereBetween('created_at', [$from, $to])->get();

        $report = [];

        foreach ($sales as $sale) {
            $report[] = [
                'date' => $sale->created_at->format('Y-m-d'),
                'description' => $sale->product_name . ' (x' . $sale->quantity . ')',
                'type' => 'Credit',
                'amount' => $sale->profit ?? 0,
            ];
        }

        foreach ($expenses as $expense) {
            $report[] = [
                'date' => $expense->created_at->format('Y-m-d'),
                'description' => $expense->description,
                'type' => 'Debit',
                'amount' => $expense->amount,
            ];
        }

        usort($report, fn($a, $b) => strtotime($a['date']) <=> strtotime($b['date']));

        return $report;
    }

    
}
