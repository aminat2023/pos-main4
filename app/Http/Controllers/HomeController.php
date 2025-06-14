<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CounterSalesDetail;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $today = now()->toDateString();
    
        $totalSalesToday = CounterSalesDetail::whereDate('created_at', $today)
                            ->sum('total_amount');
    
        // Get low stock products from ProductTwo
        $lowStockProducts = \App\Models\IncomingStock::where('total_stock', '<', 10)->get();
        $lowStockCount = $lowStockProducts->count();
    
        return view('home', compact('totalSalesToday', 'lowStockCount', 'lowStockProducts'));
    }
    
}
