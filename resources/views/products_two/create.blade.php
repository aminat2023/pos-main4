@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Add Product</h1>
    <form action="{{ route('products_two.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="product_name">Product Name</label>
            <input type="text" name="product_name" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="brand">Brand</label>
            <input type="text" name="brand" class="form-control">
        </div>
        <div class="form-group">
            <label for="description">Description</label>
            <textarea name="description" class="form-control" required></textarea>
        </div>
        <div class="form-group">
            <label for="alert_stock">Alert Stock</label>
            <input type="number" name="alert_stock" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="barcode">Barcode</label>
            <input type="text" name="barcode" class="form-control">
        </div>
        <div class="form-group">
            <label for="qrcode">QRCode</label>
            <input type="text" name="qrcode" class="form-control">
        </div>
        <div class="form-group">
            <label for="product_image">Product Image</label>
            <input type="file" name="product_image" class="form-control">
        </div>
        <button type="submit" class="btn btn-success">Save</button>
    </form>
</div>
@endsection