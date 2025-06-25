@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="card">
        <div class="card-header text-white" style="background-color: teal;">
            Supplier Payment Invoice
        </div>
        <div class="card-body">
            <p><strong>Invoice No:</strong> {{ $payment->invoice_number }}</p>
            <p><strong>Supplier:</strong>{{ $payment->supply->supplier->name ?? 'Unknown Supplier' }}
            </p>
            <p><strong>Product:</strong> {{ $payment->product_name }}</p>
            <p><strong>Quantity:</strong> {{ $payment->quantity }}</p>
            <p><strong>Amount:</strong> ₦{{ number_format($payment->amount, 2) }}</p>
            <p><strong>Payment Mode:</strong> {{ ucfirst($payment->payment_mode) }}</p>
            <p><strong>Date:</strong> {{ $payment->created_at->format('Y-m-d') }}</p>
        </div>
    </div>
</div>
@endsection
