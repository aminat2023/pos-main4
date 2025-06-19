@extends('layouts.app')

@section('content')
    <div class="container mt-5 d-flex justify-content-center">
        <div class="card shadow-sm" style="width: 100%; max-width: 500px;">
            
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">Add Incoming Product</h5>
            </div>

            <div class="card-body">
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif

                <form action="{{ route('incoming-products.add') }}" method="POST">
                    @csrf

                    <div class="mb-3">
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

                    <button type="submit" class="btn btn-success w-100">Add Incoming Batch</button>
                </form>
            </div>
        </div>
    </div>

    <script>
        function updateProductDetails(select) {
            const selectedOption = select.options[select.selectedIndex];
            document.getElementById('product_name').value = selectedOption.getAttribute('data-name');
            document.getElementById('selling_price').value = selectedOption.getAttribute('data-selling-price');
        }

        function setTodayDate() {
            const today = new Date().toISOString().split('T')[0];
            document.getElementById('batch_date').value = today;
        }

        window.onload = setTodayDate;
    </script>
@endsection