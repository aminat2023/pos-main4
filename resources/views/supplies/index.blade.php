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

        {{-- <div class="card-body">
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
                            <td>{{ $supply->product_name }}</td>
                            <td>{{ $supply->quantity }}</td>
                            <td>₦{{ number_format($supply->amount, 2) }}</td>
                            <td>{{ ucfirst($supply->payment_mode) }}</td>
                            <td>{{ $supply->created_at->format('Y-m-d') }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div> --}}

        <div class="card-body">
            @if(session('supply_created'))
    <div class="alert alert-success">
        Supply recorded. <a href="{{ route('supplier_payments.create', session('supply_created')) }}" class="btn btn-sm btn-success ml-2">Proceed to Payment</a>
    </div>
@endif

<table class="table table-striped">
    <thead>
        <tr>
            <th>Supplier</th>
            <th>Product</th>
            <th>Quantity</th>
            <th>Amount</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        @foreach($supplies as $supply)
        <tr>
            <td>{{ $supply->supplier->name ?? 'Anonymous' }}</td>
            <td>{{ $supply->product_name }}</td>
            <td>{{ $supply->quantity }}</td>
            <td>₦{{ number_format($supply->amount, 2) }}</td>
            <td>
                <a href="{{ route('supplier_payments.create', $supply->id) }}" class="btn btn-sm btn-primary">
                    Make Payment
                </a>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

        </div>
    </div>
</div>
@endsection
