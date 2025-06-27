@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div>
            <div>
                @php
                $logoPath = getPreference('business_logo');
            @endphp
            
            @if ($logoPath && file_exists(public_path('storage/' . $logoPath)))
                <img class="logo" src="{{ asset('storage/' . $logoPath) }}" alt="Logo">
            @else
                <img class="logo" src="{{ asset('images/default-logo.png') }}" alt="Default Logo">
            @endif
                <div class="container2">
                    <h1 class="card-header">
                        <span > <h1 class="marquee-text"> {{ getPreference('business_name', 'My Business') }}</h1>
                        </span>
                        
                    </h1>
                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        <!-- {{ __('You are logged in!') }} -->
                    </div>
                </div>
            </div>

            <div class="card-container">
                <div class="carda card1">
                    <h2 class="card-title">Card 1 Title</h2>
                    <p class="card-text">This is a beautiful description for Card 1. It provides valuable information.</p>
                </div>
                <a href="{{ route('daily_sales.show', ['date' => \Carbon\Carbon::today()->toDateString()]) }}" style="text-decoration: none;">
                    <div class="carda card2">
                        <h2 class="card-title">Daily Sales</h2>
                        <p class="card-text">
                            <i style="font-size:20px" class="fa fa-chart-line" aria-hidden="true"></i>
                        </p>
                        <h1>{{ number_format($totalSalesToday, 1) }}</h1>
                    </div>
                </a>
                <div  class="carda card3 {{ $lowStockCount > 0 ? 'low-stock-alert' : '' }}" data-toggle="modal" data-target="#lowStockModal" style="cursor:pointer;">
                    <h2 class="card-title">Low Stock</h2>
                    <p class="card-text">
                        <i style="color:yellow" class="fa fa-exclamation-triangle" aria-hidden="true"></i>
                    </p>
                    <h1>{{ $lowStockCount }}</h1>
                </div>
            </div>

        </div>
        <div class="modal fade" id="lowStockModal" tabindex="-1" aria-labelledby="lowStockModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
              <div class="modal-content">
                <div class="modal-header" style="background-color: #008B8B; color: white;">
                  <h5 class="modal-title" id="lowStockModalLabel">Low Stock Products</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">x</button>
                </div>
                <div class="modal-body">
                  @if ($lowStockProducts->count())
                      <table class="table table-bordered">
                          <thead>
                              <tr>
                                  <th>Product Name</th>
                                  <th>Product Code</th>
                                  <th>Total Stock</th>
                              </tr>
                          </thead>
                          <tbody>
                              @foreach ($lowStockProducts as $product)
                                  <tr>
                                      <td>{{ $product->product_name }}</td>
                                      <td>{{ $product->product_code }}</td>
                                      <td>{{ $product->total_stock }}</td>
                                  </tr>
                              @endforeach
                          </tbody>
                      </table>
                  @else
                      <p class="text-success">All products are sufficiently stocked.</p>
                  @endif
                </div>
              </div>
            </div>
          </div>
          
    </div>
@endsection
<style>
    .container2 {
        margin: 0;
        background: #008B8B;
        /* Set background color for the card */
        border: none;
        /* Ensure no border */
        width: 100%;
        font-size: 20rem;
    }

    .card-header {
        display: flex;
        /* Use flexbox to align items */
        justify-content: space-between;
        /* Space between title and icon */
        align-items: center;
        /* Center items vertically */
        background: #008B8B;
        /* Set background color for the header */
        padding: 10px;
        /* Add padding */
    }

    .card-title {
        font-size: 1.5em;
        /* Larger font size for titles */
        color: #ffffff;
        /* White text color */
        margin: 10px 0;
        /* Margin around title */
    }

    .icon {
        font-size: 2em;
        /* Icon size */
        color: #ffffff;
        /* Icon color */
    }

    .card-text {
        font-size: 1em;
        /* Standard font size for text */
        color: #ffffff;
        /* White text color */
        text-align: center;
        /* Center the text */
        padding: 0 10px;
        /* Padding for text */
    }

    .card-container {
        display: flex;
        /* Enable flexbox layout */
        justify-content: space-around;
        /* Space cards evenly */
        align-items: center;
        /* Center cards vertically */
        flex-wrap: wrap;
        /* Allow wrapping to the next line */
        margin: 20px;
        /* Margin around the container */
    }

    .card-body {
        background: linear-gradient(to bottom right, #008B8B, #1e4225, #004d4d);

        /* Set background color for the body */
    }

    .carda {
        border-radius: 10px;
        /* Rounded corners */
        width: 300px;
        /* Set card width */
        height: 200px;
        /* Set card height */
        display: flex;
        /* Flexbox for card content */
        flex-direction: column;
        /* Stack title and text vertically */
        justify-content: space-between;
        /* Space between header and text */
        margin: 15px;
        /* Space between cards */
        box-shadow: 0 8px 15px rgba(0, 0, 0, 0.6);
        /* Box shadow */
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        /* Smooth transition for effects */
        padding: 5px;
        text-align: center;
        /* border-block-start:   2px solid white; */
    }

    /* Different colors for each card */
    .card1 {
        background-color: #30570c;
        border-left: 5px solid rgb(81, 223, 89);
            /* Light red */
    }

    .card2 {
        background-color: #3f0a23;
        border-left: 5px solid rgb(228, 106, 167);
        color:  rgb(228, 106, 167);
        
    }

    .card3 {
        background-color: #112a2b;
        border-left: 5px solid rgb(30, 194, 145);
        
    }

    .carda:hover {
        transform: translateY(-5px);
        /* Move card up on hover */
        box-shadow: 0 12px 20px rgba(0, 0, 0, 0.3);
        /* Enhance shadow on hover */
    }

    .marquee-text {
        display: inline-block;
        /* Inline block for marquee effect */
        white-space: nowrap;
        /* Prevent text wrapping */
        animation: marquee 15s linear infinite;
        /* Animation for scrolling */
    }

    @keyframes marquee {
        0% {
            transform: translateX(100%);
        }

        /* Start off-screen right */
        100% {
            transform: translateX(-100%);
        }

        /* End off-screen left */
    }
    .low-stock-alert {
    background-color: #ff3333 !important;
    border-left: 5px solid yellow !important;
    color: white !important;
}
</style>
