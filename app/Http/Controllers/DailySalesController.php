<?php

namespace App\Http\Controllers;

use App\Models\CounterSalesDetail;
use Illuminate\Http\Request;

class DailySalesController extends Controller
{
    public function index()
    {
        $sales = CounterSalesDetail::selectRaw('DATE(created_at) as date')
            ->groupBy('date')
            ->orderByDesc('date')
            ->get();

        return view('daily-sales.index', compact('sales'));
    }

    public function show($date)
    {
        $details = CounterSalesDetail::whereDate('created_at', $date)->get();

        // Calculate total sales for the selected date
        $totalSalesToday = $details->sum('total_amount');

        return view('daily-sales.show', compact('details', 'date', 'totalSalesToday'));
    }
}

