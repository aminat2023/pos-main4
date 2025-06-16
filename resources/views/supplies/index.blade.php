@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">Supply Information</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <!-- Example table -->
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Supplier Name</th>
                <th>Product</th>
                <th>Quantity</th>
                <th>Amount</th>
                <th>Payment Mode</th>
                <th>Date</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($supplies as $supply)
            <tr>
                <td>{{ $supply->supplier->name ?? 'N/A' }}</td>
                <td>{{ $supply->product->product_name ?? 'N/A' }}</td>
                <td>{{ $supply->quantity }}</td>
                <td>{{ number_format($supply->amount, 2) }}</td>
                <td>{{ ucfirst($supply->payment_mode) }}</td>
                <td>{{ $supply->created_at->format('Y-m-d') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
