@extends('layouts.app')

@section('content')
<div class="container">
    <!-- Page Header -->
    <div class="row mb-4">
        <div class="col" style="background-color: #008B8B;">
            <h1 class="text-center" style="color: #fff;">Product Barcodes</h1>
        </div>
    </div>

    <!-- Display Success Message -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <!-- Product Cards -->
    <div class="row">
        @foreach ($products as $product)
        <div class="col-md-4 mb-4"> <!-- Adjust grid size if needed -->
            <div class="card">
                <div class="card-body text-center">
                    <div>
                        <img src="{{ asset('products/barcodes/' . $product->barcode) }}" alt="Barcode">
                    </div>
                    <p><strong>{{ $product->product_code }}</strong></p> <!-- Display Product Code below the barcode -->
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>

<style>
    .card {
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); /* Optional for a nicer appearance */
        min-height: 250px; /* Set a minimum height to make the card taller */
    }
    .card-body {
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
    }
    h1 {
        font-size: 36px;
        font-weight: bold;
        margin-bottom: 30px;
    }
    p {
        font-size: 28px;
        /* font-weight: bold; */
        margin-top: 50px;

    }
</style>

@endsection
