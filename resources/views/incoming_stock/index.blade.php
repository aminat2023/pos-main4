@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Incoming Stock</h2>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif
        <form action="{{ route('incoming_stock.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="product_code">Product</label>
                <select id="product_code" name="product_code" class="form-control" required>
                    <option value="">Select a product</option>
                    @foreach($products as $product)
                        <option value="{{ $product->product_code }}">{{ $product->product_name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="quantity">Quantity</label>
                <input type="number" name="quantity" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="cost_price">Cost Price</label>
                <input type="number" step="0.01" name="cost_price" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="selling_price">Selling Price</label>
                <input type="number" step="0.01" name="selling_price" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary">Add Incoming Stock</button>
        </form>
    </div>
@endsection