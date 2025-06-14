<!-- resources/views/products/show.blade.php -->
@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Product Details</h1>
        <div class="card">
            <div class="card-header">
                {{ $product->product_name }}
            </div>
            <div class="card-body">
                <h5 class="card-title">Brand: {{ $product->brand }}</h5>
                <p class="card-text">Description: {{ $product->description }}</p>
                <p class="card-text">Cost Price: {{ number_format($product->cost_price, 2) }}</p>
                <p class="card-text">Selling Price: {{ number_format($product->selling_price, 2) }}</p>
                <p class="card-text">Quantity: {{ $product->quantity }}</p>
                <p class="card-text">
                    Alert Stock: 
                    @if($product->quantity < 10)
                        <strong style="color: red;">Low Stock</strong>
                    @else
                        In Stock
                    @endif
                </p>
                {{-- <a href="{{ route('products.edit', $product->id) }}" class="btn btn-warning">Edit</a> --}}
                <a href="{{ route('products.index') }}" class="btn btn-secondary">Back to Products</a>
            </div>
        </div>
    </div>
@endsection
