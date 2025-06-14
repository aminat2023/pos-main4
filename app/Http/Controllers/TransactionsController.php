<?php

namespace App\Http\Controllers;

use App\Models\Transactions as Transaction; // Alias the model as Transaction
use Illuminate\Http\Request;

class TransactionsController extends Controller
{
    public function index()
    {
        $transactions = Transaction::all(); // Use the alias here
        return view('transactions.index', compact('transactions'));
    }

    public function report()
    {
        $transactions = Transaction::orderBy('id')->take(100)->get();
        return view('transactions.report', compact('transactions'));
    }

    public function history()
    {
        $transactions = Transaction::all();
        return view('transactions.history', compact('transactions'));
       
    }

    public function create()
    {
        // Logic for creating a new transaction
    }

    public function store(Request $request)
    {
        // Logic for storing a new transaction
    }

    public function show(Transactions $transaction) // Use Transactions instead of transactions
    {
        // Logic for showing a specific transaction
    }

    public function edit(Transactions $transaction) // Use Transactions instead of transactions
    {
        // Logic for editing a specific transaction
    }

    public function update(Request $request, Transactions $transaction) // Use Transactions instead of transactions
    {
        // Logic for updating a specific transaction
    }

    public function destroy(Transactions $transaction) // Use Transactions instead of transactions
    {
        // Logic for deleting a specific transaction
    }
}