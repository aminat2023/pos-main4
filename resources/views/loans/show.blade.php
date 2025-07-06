@extends('layouts.app')

@section('content')
<div class="container">
   <h4 class="mt-4">💰 Record Repayment</h4>

<form action="{{ route('loan_repayments.store') }}" method="POST">
    @csrf
    <input type="hidden" name="loan_id" value="{{ $loan->id }}">

    <div class="row">
        <div class="col-md-4">
            <label>Amount Paid</label>
            <input type="number" step="0.01" name="amount_paid" class="form-control" required>
        </div>
        <div class="col-md-4">
            <label>Payment Date</label>
            <input type="date" name="payment_date" class="form-control" required>
        </div>
        <div class="col-md-4">
            <label>Payment Method</label>
            <select name="payment_method" class="form-control" required>
                <option value="cash">Cash</option>
                <option value="transfer">Bank Transfer</option>
                <option value="POS">POS</option>
            </select>
        </div>
    </div>

    <div class="mt-2">
        <label>Note (optional)</label>
        <textarea name="note" class="form-control"></textarea>
    </div>

    <button class="btn btn-success mt-3">💾 Save Repayment</button>
</form>

</div>

<h5 class="mt-4">📄 Repayment History</h5>

<p>Total Repaid: ₦{{ number_format($totalRepaid, 2) }}</p>
<p>Balance Left: ₦{{ number_format($balance, 2) }}</p>

<table class="table table-bordered table-sm">
    <thead>
        <tr>
            <th>Date</th>
            <th>Amount</th>
            <th>Method</th>
            <th>Note</th>
        </tr>
    </thead>
    <tbody>
        @foreach($repayments as $r)
            <tr>
                <td>{{ $r->payment_date }}</td>
                <td>₦{{ number_format($r->amount_paid, 2) }}</td>
                <td>{{ ucfirst($r->payment_method) }}</td>
                <td>{{ $r->note }}</td>
            </tr>
        @endforeach
    </tbody>
</table>

@endsection
