@extends('layouts.app')

@section('content')
<div class="container mt-4 d-flex justify-content-center flex-column align-items-center">

    <!-- Show Button (Initially Hidden) -->
    <button id="showSupplierFormBtn" onclick="toggleSupplierCard()" class="btn btn-info mb-3" style="display: none;">
        Show Supplier Form
    </button>

    <!-- Supplier Form Card -->
    <div id="supplierCard" class="card shadow-sm position-relative animate__animated" style="width: 100%; max-width: 600px;">
        
        <!-- Close Button -->
        <button type="button" class="close position-absolute" style="top: 10px; right: 15px; z-index: 10;" onclick="toggleSupplierCard()">
            <span aria-hidden="true">&times;</span>
        </button>

        <!-- Card Header -->
        <div class="card-header" style="background-color: teal; color: white;">
            <h5 class="mb-0">Add New Supplier</h5>
        </div>

        <!-- Card Body -->
        <div class="card-body">
            {{-- Success Message --}}
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif

            <form action="{{ route('suppliers.store') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label for="name" class="form-label">Supplier Name</label>
                    <input type="text" name="name" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label for="phone" class="form-label">Phone</label>
                    <input type="text" name="phone" class="form-control">
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" name="email" class="form-control">
                </div>

                <div class="mb-3">
                    <label for="address" class="form-label">Address</label>
                    <textarea name="address" class="form-control" rows="2"></textarea>
                </div>

                <button type="submit" class="btn btn-success w-100">Save Supplier</button>
            </form>
        </div>
    </div>
</div>

<!-- Optional Fade CSS (Animate.css CDN) -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>

<!-- Script to Toggle Card -->
<script>
    function toggleSupplierCard() {
        const card = document.getElementById('supplierCard');
        const btn = document.getElementById('showSupplierFormBtn');

        if (card.style.display === 'none') {
            card.classList.remove('animate__fadeOut');
            card.classList.add('animate__fadeIn');
            card.style.display = 'block';
            btn.style.display = 'none';
        } else {
            card.classList.remove('animate__fadeIn');
            card.classList.add('animate__fadeOut');
            setTimeout(() => {
                card.style.display = 'none';
                btn.style.display = 'block';
            }, 500);
        }
    }
</script>
@endsection
