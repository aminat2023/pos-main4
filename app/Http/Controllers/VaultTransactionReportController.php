<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\VaultTransaction;
use Carbon\Carbon;

class VaultTransactionReportController extends Controller
{
    public function index(Request $request)
    {
        $filterType = $request->input('filter_type');
        $report = [];

        // Handle filter
        if ($filterType === 'date') {
            $fromDate = $request->input('from_date');
            $toDate = $request->input('to_date');

            if ($fromDate && $toDate) {
                $transactions = VaultTransaction::whereDate('created_at', '>=', $fromDate)
                    ->whereDate('created_at', '<=', $toDate)
                    ->orderBy('created_at', 'asc')
                    ->get();
            } else {
                $transactions = collect(); // empty collection
            }
        } elseif ($filterType === 'month') {
            $month = $request->input('month'); // format: yyyy-mm

            if ($month) {
                $parsedMonth = Carbon::parse($month);
                $transactions = VaultTransaction::whereYear('created_at', $parsedMonth->year)
                    ->whereMonth('created_at', $parsedMonth->month)
                    ->orderBy('created_at', 'asc')
                    ->get();
            } else {
                $transactions = collect();
            }
        } elseif ($filterType === 'year') {
            $year = $request->input('year');

            if ($year) {
                $transactions = VaultTransaction::whereYear('created_at', $year)
                    ->orderBy('created_at', 'asc')
                    ->get();
            } else {
                $transactions = collect();
            }
        } else {
            $transactions = collect();
        }

        // Format report
        foreach ($transactions as $tx) {
            $amount = is_numeric($tx->amount) ? $tx->amount : 0;

            $report[] = [
                'date' => $tx->created_at->format('Y-m-d'),
                'description' => $tx->reason ?? 'N/A',
                'type' => $amount >= 0 ? 'Credit' : 'Debit',
                'amount' => abs($amount),
            ];
        }

        // Check if we should show "no transactions" message
        $noResults = ($filterType && count($report) === 0);

        return view('vault.report', compact('report', 'noResults'));
    }
}
