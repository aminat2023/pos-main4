@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">Record Goods Supplied</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form method="POST" action="{{ route('supplies.store') }}">
        @csrf

        <div class="mb-3">
            <label for="supplier_id" class="form-label">Supplier</label>
            <select name="supplier_id" id="supplier_id" class="form-select" required>
                <option value="">Select Supplier</option>
                @foreach($suppliers as $supplier)
                    <option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="product_name" class="form-label">Product Name</label>
            <input type="text" name="product_name" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="quantity" class="form-label">Quantity</label>
            <input type="number" name="quantity" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="unit_price" class="form-label">Unit Price (₦)</label>
            <input type="number" step="0.01" name="unit_price" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-primary">Record Supply</button>
    </form>
</div>
@endsection
