@extends('layouts.app')

@section('content')
<div class="container min-vh-100 d-flex justify-content-center align-items-center">
    <button id="toggleCardBtn" onclick="toggleCard()" class="btn btn-info mb-3" style="display: none;">
        Show Incoming Stock Form
    </button>

    <div id="incomingStockCard" class="card shadow-sm position-relative fade-card"
         style="width: 100%; max-width: 600px; height: auto; overflow: visible;">
        
        <button type="button" class="close position-absolute"
                style="top: 10px; right: 15px; z-index: 10;"
                onclick="toggleCard()">
            <span aria-hidden="true">&times;</span>
        </button>

        <div class="card-header text-white" style="background-color: teal;">
            <h5 class="mb-0">Incoming Stock</h5>
        </div>

        <div class="card-body p-3">
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show mb-2" role="alert">
                    {{ session('success') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif

            <form action="{{ route('incoming_stock.store') }}" method="POST">
                @csrf

                <!-- Search input with suggestions -->
                <div class="form-group mb-2">
                    <label for="product_search">Search Product</label>
                    <input type="text" id="product_search" name="product_search" class="form-control" 
                           placeholder="Type product name or code" list="productSuggestions">
                    <datalist id="productSuggestions">
                        @foreach($products as $product)
                            <option value="{{ $product->product_name }} ({{ $product->product_code }})">
                        @endforeach
                    </datalist>
                </div>

                <!-- Hidden field for actual product code -->
                <input type="hidden" id="product_code" name="product_code">

                <div class="form-group mb-2">
                    <label for="quantity">Quantity</label>
                    <input type="number" name="quantity" class="form-control" required>
                </div>

                <div class="form-group mb-2">
                    <label for="cost_price">Cost Price</label>
                    <input type="number" step="0.01" name="cost_price" class="form-control" required>
                </div>

                <div class="form-group mb-3">
                    <label for="selling_price">Selling Price</label>
                    <input type="number" step="0.01" name="selling_price" class="form-control" required>
                </div>

                <button style="background-color: teal; color: white" type="submit" class="btn w-100">
                    Add Incoming Stock
                </button>
            </form>
        </div>
    </div>
</div>

<script>
function toggleCard() {
    const card = document.getElementById('incomingStockCard');
    const btn = document.getElementById('toggleCardBtn');

    if (card.style.display === 'none' || card.classList.contains('fade-out')) {
        card.style.display = 'block';
        setTimeout(() => {
            card.classList.remove('fade-out');
            card.classList.add('fade-in');
        }, 10);
        btn.style.display = 'none';
    } else {
        card.classList.remove('fade-in');
        card.classList.add('fade-out');
        setTimeout(() => {
            card.style.display = 'none';
            btn.style.display = 'inline-block';
        }, 500);
    }
}

// Product selection handling
document.getElementById('product_search').addEventListener('input', function(e) {
    const input = e.target.value;
    const hiddenField = document.getElementById('product_code');
    
    // Extract product code from selected value (format: "Product Name (CODE)")
    const match = input.match(/\(([^)]+)\)/);
    
    if (match && match[1]) {
        hiddenField.value = match[1];
    } else {
        hiddenField.value = '';
    }
});
</script>

<style>
/* ... existing styles ... */
</style>
@endsection
