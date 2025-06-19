@extends('layouts.app')

@section('content')
<div class="container d-flex justify-content-center flex-column align-items-center">

    <!-- Show Button (appears after card is hidden) -->
    <button id="showSupplyFormBtn" onclick="toggleSupplyCard()" class="btn btn-info mb-3" style="display: none;">
        Show Supply Form
    </button>

    <!-- Supply Form Card -->
    <div id="supplyCard" class="card shadow-sm position-relative fade-card" style="width: 100%; max-width: 600px;">
        
        <!-- Close Button -->
        <button type="button" class="close position-absolute" 
                style="top: 10px; right: 15px; z-index: 10;"
                onclick="toggleSupplyCard()">
            <span aria-hidden="true">&times;</span>
        </button>

        <div class="card-header text-white text-center" style="background-color: teal;">
            <h4 class="mb-0">Record Goods Supplied</h4>
        </div>

        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                </div>
            @endif

            <form method="POST" action="{{ route('supplies.store') }}">
                @csrf

                <div class="mb-3">
                    <label for="supplier_id" class="form-label">Supplier</label>
                    <select name="supplier_id" id="supplier_id" class="form-select form-control" required>
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

                <div class="d-flex justify-content-end">
                    <button type="submit" class="btn" style="background-color: teal; color:white;">Record Supply</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('script')
<script>
    function toggleSupplyCard() {
        const card = document.getElementById('supplyCard');
        const btn = document.getElementById('showSupplyFormBtn');

        // If card is visible, fade it out
        if (card.style.display !== "none") {
            card.classList.add('fade-out');
            setTimeout(() => {
                card.style.display = "none";
                btn.style.display = "inline-block";
            }, 500);
        } else {
            // Show card with fade in
            card.style.display = "block";
            card.classList.remove('fade-out');
            card.classList.add('fade-in');
            btn.style.display = "none";
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
