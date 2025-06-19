@extends('layouts.app')

@section('content')
<div class="container mt-5 d-flex justify-content-center flex-column align-items-center">

    <!-- Toggle Button -->
    <button id="toggleCardBtn" onclick="toggleCard()" class="btn btn-info mb-3" style="display: none;">
        Show Incoming Stock Form
    </button>

    <div id="incomingStockCard" class="card shadow-sm position-relative fade-card"
         style="width: 100%; max-width: 600px;">
        
        <!-- Close Button -->
        <button type="button" class="close position-absolute"
                style="top: 10px; right: 15px; z-index: 10;"
                onclick="toggleCard()">
            <span aria-hidden="true">&times;</span>
        </button>

        <div class="card-header text-white" style="background-color: teal;">
            <h5 class="mb-0">Incoming Stock</h5>
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

            <form action="{{ route('incoming_stock.store') }}" method="POST">
                @csrf

                <div class="form-group mb-3">
                    <label for="product_code">Product</label>
                    <select id="product_code" name="product_code" class="form-control" required>
                        <option value="">Select a product</option>
                        @foreach($products as $product)
                            <option value="{{ $product->product_code }}">{{ $product->product_name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group mb-3">
                    <label for="quantity">Quantity</label>
                    <input type="number" name="quantity" class="form-control" required>
                </div>

                <div class="form-group mb-3">
                    <label for="cost_price">Cost Price</label>
                    <input type="number" step="0.01" name="cost_price" class="form-control" required>
                </div>

                <div class="form-group mb-4">
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

    
</script>
<style>
    .fade-card {
    transition: opacity 0.5s ease;
}

.fade-out {
    opacity: 0;
}

.fade-in {
    opacity: 1;
}

</style>
@endsection
