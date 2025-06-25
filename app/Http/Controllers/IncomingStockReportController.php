<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\IncomingStock;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\IncomingStockExport;

class IncomingStockReportController extends Controller
{
    public function index()
    {
        $stocks = IncomingStock::with('product')->latest()->paginate(20);
        return view('reports.incoming_stock.index', compact('stocks'));
    }

    

    public function print(Request $request)
    {
        $query = \App\Models\IncomingStock::with('product');
    
        $viewType = $request->view_type;
    
        if ($viewType === 'period') {
            $from = $request->input('from_date');
            $to = $request->input('to_date');
            if ($from && $to) {
                $query->whereBetween('created_at', [$from . ' 00:00:00', $to . ' 23:59:59']);
            }
        } elseif ($viewType === 'monthly') {
            $month = $request->input('month');
            if ($month) {
                $query->whereYear('created_at', \Carbon\Carbon::parse($month)->format('Y'))
                      ->whereMonth('created_at', \Carbon\Carbon::parse($month)->format('m'));
            }
        } elseif ($viewType === 'yearly') {
            $year = $request->input('year');
            if ($year) {
                $query->whereYear('created_at', $year);
            }
        }
    
        $stocks = $query->orderBy('created_at', 'desc')->get();
    
        return view('reports.incoming_stock.print', compact('stocks'));
    }




public function exportExcel(Request $request)
{
    return Excel::download(
        new IncomingStockExport(
            $request->view_type,
            $request->from_date,
            $request->to_date,
            $request->month,
            $request->year
        ),
        'incoming_stock_report.xlsx'
    );
}

public function exportPdf(Request $request)
{
    $query = \App\Models\IncomingStock::with('product');

    if ($request->view_type === 'period') {
        $query->whereBetween('created_at', [$request->from_date . ' 00:00:00', $request->to_date . ' 23:59:59']);
    } elseif ($request->view_type === 'monthly') {
        $query->whereYear('created_at', \Carbon\Carbon::parse($request->month)->format('Y'))
              ->whereMonth('created_at', \Carbon\Carbon::parse($request->month)->format('m'));
    } elseif ($request->view_type === 'yearly') {
        $query->whereYear('created_at', $request->year);
    }

    $stocks = $query->get();

    $pdf = Pdf::loadView('reports.incoming_stock.print', [
        'stocks' => $stocks
    ]);

    return $pdf->download('incoming_stock_report.pdf');
}

    
}
