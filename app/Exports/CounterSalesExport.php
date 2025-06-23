<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Facades\Excel;


class CounterSalesExport implements FromView
{
    protected $sales;

    public function __construct($sales)
    {
        $this->sales = $sales;
    }

    public function view(): View
    {
        return view('exports.counter_sales_excel', [
            'sales' => $this->sales
        ]);
    }
}
