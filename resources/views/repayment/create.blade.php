@extends('layouts.app')

@section('content')
<div class="container">
    <h5>💳 Repayment for Account: <strong>{{ $loan->account_number }}</strong></h5>
    <p>Name: {{ $loan->full_name }}</p>
    <p>Loan Amount: ₦{{ number_format($loan->loan_amount, 2) }}</p>
    <p>Total Payable: ₦{{ number_format($loan->total_payable, 2) }}</p>

    <form action="{{ route('repayments.store', $loan->id) }}" method="POST">
        @csrf
        <div class="form-group">
            <label>Amount Paid:</label>
            <input type="number" name="amount_paid" step="0.01" class="form-control" required>
        </div>
        <div class="form-group mt-2">
            <label>Payment Date:</label>
            <input type="date" name="payment_date" class="form-control" value="{{ date('Y-m-d') }}" required>
        </div>
        <div class="form-group mt-2">
            <label>Payment Method:</label>
            <select name="payment_method" class="form-control">
                <option value="cash">Cash</option>
                <option value="bank">Bank</option>
                <option value="transfer">Transfer</option>
            </select>
        </div>
        <div class="form-group mt-2">
            <label>Note:</label>
            <textarea name="note" class="form-control" rows="2"></textarea>
        </div>
        <button type="submit" class="btn btn-success mt-3">💰 Save Repayment</button>
    </form>
</div>
@endsection
