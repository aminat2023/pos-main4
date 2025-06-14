@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Edit Product</h1>
    <form action="{{ route('products_two.update', $product->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="product_name">Product Name</label>
            <input type="text" name="product_name" class="form-control" value="{{ $product->product_name }}" required>
        </div>
        <div class="form-group">
            <label for="brand">Brand</label>
            <input type="text" name="brand" class="form-control" value="{{ $product->brand }}">
        </div>
        <div class="form-group">
            <label for="description">Description</label>
            <textarea name="description" class="form-control" required>{{ $product->description }}</textarea>
        </div>
        <div class="form-group">
            <label for="alert_stock">Alert Stock</label>
            <input type="number" name="alert_stock" class="form-control" value="{{ $product->alert_stock }}" required>
        </div>
        <div class="form-group">
            <label for="barcode">Barcode</label>
            <input type="text" name="barcode" class="form-control" value="{{ $product->barcode }}">
        </div>
        <div class="form-group">
            <label for="qrcode">QRCode</label>
            <input type="text" name="qrcode" class="form-control" value="{{ $product->qrcode }}">
        </div>
        <div class="form-group">
            <label for="product_image">Product Image</label>
            <input type="file" name="product_image" class="form-control">
        </div>
        <button type="submit" class="btn btn-success">Update</button>
    </form>
</div>
@endsection