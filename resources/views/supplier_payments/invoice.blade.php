@extends('layouts.app')

@section('content')
<div class="container my-4" id="invoice-area">
    <div class="card border-0 shadow-sm">
        <div class="card-body p-4">

            {{-- Business Branding --}}
            <div class="text-center mb-4">
                <h2 class="mb-0">YOUR BUSINESS NAME</h2>
                <p class="mb-0 small text-muted">123 Business St, City | Phone: 08012345678 | email@example.com</p>
                <hr>
            </div>

            {{-- Invoice Header --}}
            <div class="row mb-3">
                <div class="col-md-6">
                    <h5 class="mb-1">Supplier Invoice</h5>
                    <p class="mb-1"><strong>Invoice No:</strong> {{ $payment->invoice_number }}</p>
                    <p class="mb-1"><strong>Date:</strong> {{ $payment->created_at->format('Y-m-d') }}</p>
                    <p class="mb-1"><strong>Supplier:</strong> {{ $payment->supply->supplier->name ?? 'Anonymous' }}</p>
                    <p class="mb-1"><strong>Payment Method:</strong> {{ ucfirst($payment->payment_mode) }}</p>
                </div>
                <div class="col-md-6 text-end">
                   
                </div>
            </div>

            {{-- Item Table --}}
            <table class="table table-bordered">
                <thead class="table-light">
                    <tr>
                        <th>Product</th>
                        <th>Qty</th>
                        <th>Total Amount</th>
                        <th>Paid</th>
                        <th>Balance</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>{{ $payment->product_name }}</td>
                        <td>{{ $payment->quantity }}</td>
                        <td>₦{{ number_format($payment->amount, 2) }}</td>
                        <td>₦{{ number_format($payment->amount_paid, 2) }}</td>
                        <td>₦{{ number_format($payment->balance, 2) }}</td>
                    </tr>
                </tbody>
            </table>

            {{-- Footer --}}
            <div class="text-center mt-4">
                <p class="mb-0"><strong>Thank you for doing business with us.</strong></p>
                <small class="text-muted">This invoice was generated on {{ now()->format('Y-m-d H:i') }}</small>
            </div>

            {{-- Print Button --}}
            <div class="text-end mt-3">
                <button onclick="printInvoice()" class="btn btn-dark">🖨️ Print Invoice</button>
            </div>
        </div>
    </div>
</div>

<script>
    function printInvoice() {
        let content = document.getElementById('invoice-area').innerHTML;
        let original = document.body.innerHTML;
        document.body.innerHTML = content;
        window.print();
        document.body.innerHTML = original;
        location.reload();
    }
</script>
@endsection
