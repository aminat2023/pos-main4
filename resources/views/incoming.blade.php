@extends('layouts.app')

@section('content')
    <div class="container mt-4">
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        <h2 class="mb-4">Add Incoming Product</h2>
        <form action="{{ route('incoming-products.add') }}" method="POST" class="mb-4">
            @csrf

            <div class="form-group">
                <label for="product_code" class="form-label">Select Product:</label>
                <select name="product_code" class="form-select" id="product_code" required onchange="updateProductDetails(this)">
                    <option value="">-- Select a Product --</option>
                    @foreach ($products as $product)
                        <option value="{{ $product->product_code }}" data-name="{{ $product->product_name }}" data-selling-price="{{ $product->selling_price }}">
                            {{ $product->product_name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Hidden input to store the product name -->
            <input type="hidden" name="product_name" id="product_name" required>

            <div class="mb-3">
                <label for="quantity" class="form-label">Quantity:</label>
                <input type="number" name="quantity" class="form-control" required min="1">
            </div>

            <div class="mb-3">
                <label for="cost_price" class="form-label">Cost Price:</label>
                <input type="number" name="cost_price" class="form-control" step="0.01" required>
            </div>

            <div class="mb-3">
                <label for="selling_price" class="form-label">Selling Price:</label>
                <input type="text" name="selling_price" class="form-control" id="selling_price" readonly>
            </div>

            <div class="mb-3">
                <label for="batch_date" class="form-label">Batch Date:</label>
                <input type="date" name="batch_date" class="form-control" id="batch_date" required>
            </div>

            <button type="submit" class="btn btn-primary">Add Incoming Batch</button>
        </form>
    </div>

    <script>
        // Function to update product details
        function updateProductDetails(select) {
            const selectedOption = select.options[select.selectedIndex];
            document.getElementById('product_name').value = selectedOption.getAttribute('data-name');
            document.getElementById('selling_price').value = selectedOption.getAttribute('data-selling-price');
        }

        // Function to set today's date as the batch date
        function setTodayDate() {
            const today = new Date().toISOString().split('T')[0]; // Get current date in YYYY-MM-DD format
            document.getElementById('batch_date').value = today;
        }

        // Set the batch date when the page loads
        window.onload = setTodayDate;
    </script>
@endsection
