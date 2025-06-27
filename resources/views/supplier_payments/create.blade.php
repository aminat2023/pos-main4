@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="card shadow">
        <div class="card-header bg-primary text-white">
            <h4>Make Payment for Supplied Goods</h4>
        </div>
        <div class="card-body">

            {{-- Success/Error Messages --}}
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            {{-- Payment Form --}}
            <form method="POST" action="{{ route('supplier_payments.store') }}">
                @csrf
                <input type="hidden" name="supply_id" value="{{ $supply->id }}">

                <div class="mb-3">
                    <label class="form-label">Supplier</label>
                    <input type="text" class="form-control" value="{{ $supply->supplier->name ?? 'Anonymous' }}" disabled>
                </div>

                <div class="mb-3">
                    <label class="form-label">Product Name</label>
                    <input type="text" class="form-control" value="{{ $supply->product_name }}" disabled>
                </div>

                <div class="mb-3">
                    <label class="form-label">Quantity</label>
                    <input type="number" class="form-control" value="{{ $supply->quantity }}" disabled>
                </div>

                <div class="mb-3">
                    <label class="form-label">Total Amount (₦)</label>
                    <input type="text" class="form-control" value="₦{{ number_format($supply->amount, 2) }}" disabled>
                </div>

                <div class="mb-3">
                    <label class="form-label">Amount Already Paid (₦)</label>
                    <input type="text" class="form-control text-success" value="₦{{ number_format($supply->amount_paid, 2) }}" disabled>
                </div>

                <div class="mb-3">
                    <label class="form-label">Remaining Balance (₦)</label>
                    <input type="text" class="form-control text-danger fw-bold" value="₦{{ number_format($supply->balance, 2) }}" disabled>
                </div>

                <div class="mb-3">
                    <label class="form-label">Amount to Pay Now (₦)</label>
                    <input 
                        type="number" 
                        name="amount_paid" 
                        class="form-control" 
                        step="0.01" 
                        min="0.01"
                        max="{{ $supply->balance }}" 
                        placeholder="Max: ₦{{ number_format($supply->balance, 2) }}" 
                        required
                    >
                </div>

                <div class="mb-3">
                    <label class="form-label">Payment Mode</label>
                    <select name="payment_mode" class="form-control" required>
                        <option value="">Select Payment Mode</option>
                        <option value="cash">
                            Cash (Vault - ₦{{ number_format($vaultBalance, 2) }})
                        </option>
                        @foreach($bankBalances as $bank => $balance)
                            <option value="{{ $bank }}">
                                Bank: {{ $bank }} - ₦{{ number_format($balance, 2) }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <button type="submit" class="btn btn-success w-100">
                    Submit Payment
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
