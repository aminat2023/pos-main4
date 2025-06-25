<?php

namespace App\Exports;

use App\Models\IncomingStock;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class IncomingStockExport implements FromView
{
    protected $viewType;
    protected $fromDate;
    protected $toDate;
    protected $month;
    protected $year;

    public function __construct($viewType, $fromDate = null, $toDate = null, $month = null, $year = null)
    {
        $this->viewType = $viewType;
        $this->fromDate = $fromDate;
        $this->toDate = $toDate;
        $this->month = $month;
        $this->year = $year;
    }

    public function view(): View
    {
        $query = IncomingStock::with('product');

        if ($this->viewType === 'period') {
            $query->whereBetween('created_at', [$this->fromDate . ' 00:00:00', $this->toDate . ' 23:59:59']);
        } elseif ($this->viewType === 'monthly') {
            $query->whereYear('created_at', \Carbon\Carbon::parse($this->month)->format('Y'))
                  ->whereMonth('created_at', \Carbon\Carbon::parse($this->month)->format('m'));
        } elseif ($this->viewType === 'yearly') {
            $query->whereYear('created_at', $this->year);
        }

        $stocks = $query->get();

        return view('reports.incoming_stock.export_excel', [
            'stocks' => $stocks
        ]);
    }
}
