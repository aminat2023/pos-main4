@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header  text-white d-flex justify-content-between align-items-center" style="background-color: teal">
            <h4 class="mb-0">Supply Information</h4>
            <button type="button" class="close text-white" onclick="this.closest('.card').remove();" aria-label="Close" style="font-size: 1.5rem;">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>

        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead class="thead-light">
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
                            <td>₦{{ number_format($supply->amount, 2) }}</td>
                            <td>{{ ucfirst($supply->payment_mode) }}</td>
                            <td>{{ $supply->created_at->format('Y-m-d') }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
