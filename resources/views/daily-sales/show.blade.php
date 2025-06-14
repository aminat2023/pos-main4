@extends('layouts.app')

@section('content')
<div class="sales-container">
    <div class="header-section">
        <h2>
            Sales for {{ \Carbon\Carbon::parse($date)->format('F d, Y') }}
        </h2>
        <h1>Total Sales: <span class="total-sales">₦{{ number_format($totalSalesToday, 2) }}</span></h1>
    </div>

    <table class="table table-bordered sales-table">
        <thead>
            <tr>
                <th>Transaction ID</th>
                <th>Date</th>
                <th>User ID</th>
                <th>Product</th>
                <th>Qty</th>
                <th>Price</th>
                <th>Paid</th>
                <th>Balance</th>
                <th>Method</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach($details as $detail)
                <tr>
                    <td>{{ $detail->id }}</td>
                    <td>{{ $detail->created_at->format('d/m/Y H:i') }}</td>
                    <td>{{ $detail->user_id }}</td>
                    <td>{{ $detail->product_name }}</td>
                    <td>{{ $detail->quantity }}</td>
                    <td>₦{{ number_format($detail->selling_price, 2) }}</td>
                    <td>₦{{ number_format($detail->amount_paid, 2) }}</td>
                    <td>₦{{ number_format($detail->balance, 2) }}</td>
                    <td>{{ $detail->method_of_payment }}</td>
                    <td>₦{{ number_format($detail->total_amount, 2) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="back-button">
        <a href="{{ route('daily_sales.index') }}" class="btn btn-back">← Back to History</a>
    </div>
</div>
@endsection

<style>
    .sales-container {
        margin: 40px auto;
        padding: 20px;
        background-color: #f7ffff;
        border-radius: 10px;
        box-shadow: 0 4px 10px rgba(0, 139, 139, 0.2);
    }

    .header-section {
        text-align: center;
        margin-bottom: 30px;
    }

    .header-section h2 {
        color: #008B8B;
        font-weight: bold;
        font-size: 1rem;
    }

    .header-section h1 {
        font-size: 1.5rem;
        color: #004d4d;
    }

    .total-sales {
        color: #008B8B;
        font-weight: bold;
    }

    .sales-table {
        width: 100%;
        background-color: #ffffff;
        border-radius: 10px;
        overflow: hidden;
        border: 2px solid #008B8B;
    }

    .sales-table th {
        background-color: #008B8B;
        color: white;
        text-align: center;
        font-size: 1rem;
        padding: 12px;
    }

    .sales-table td {
        text-align: center;
        padding: 10px;
        font-size: 0.95rem;
        vertical-align: middle;
        background-color: #e8f8f8;
    }

    .btn-back {
        display: inline-block;
        background-color: #008B8B;
        color: white;
        padding: 10px 20px;
        font-size: 1rem;
        border-radius: 5px;
        text-decoration: none;
        transition: background-color 0.3s ease;
    }

    .btn-back:hover {
        background-color: #006f6f;
        text-decoration: none;
    }

    .back-button {
        margin-top: 20px;
        text-align: center;
    }
</style>
