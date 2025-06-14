@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Add Incoming Products</h2>
    
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <form action="{{ route('products.addStock') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="product_id">Product ID</label>
            <input type="text" class="form-control" id="product_id" name="product_id" required onblur="fetchProductName()" onkeypress="checkEnter(event)">
        </div>
        <div class="form-group">
            <label for="product_name">Product Name</label>
            <input type="text" class="form-control" id="product_name" name="product_name" readonly>
        </div>
        <div class="form-group">
            <label for="quantity">Quantity</label>
            <input type="number" class="form-control" id="quantity" name="quantity" required>
        </div>
        <div class="form-group">
            <label for="cost_price">Cost Price</label>
            <input type="number" class="form-control" id="cost_price" name="cost_price" required>
        </div>
        <div class="form-group">
            <label for="selling_price">Selling Price</label>
            <input type="number" class="form-control" id="selling_price" name="selling_price" required>
        </div>
        <button type="submit" class="btn btn-primary">Add Stock</button>
    </form>
</div>

<script>
    function fetchProductName() {
        const productId = document.getElementById('product_id').value;
        if (productId) {
            fetch(`/products/${productId}`)
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        document.getElementById('product_name').value = data.product_name;
                    } else {
                        document.getElementById('product_name').value = '';
                        alert(data.message); // Alert the message if the product is not found
                    }
                })
                .catch(error => console.error('Error fetching product name:', error));
        } else {
            document.getElementById('product_name').value = '';
        }
    }

    function checkEnter(event) {
        if (event.key === 'Enter') {
            event.preventDefault(); // Prevent form submission
            fetchProductName(); // Call the fetchProductName function
        }
    }
</script>
@endsection
