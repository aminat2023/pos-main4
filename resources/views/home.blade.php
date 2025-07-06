@extends('layouts.app')

@section('content')


    <div class="container-fluid">
        <div>
            <div>
                {{-- @php
                $logoPath = getPreference('business_logo');
            @endphp
            
            @if ($logoPath && file_exists(public_path('storage/' . $logoPath)))
                <img class="logo" src="{{ asset('storage/' . $logoPath) }}" alt="Logo">
            @else
                <img class="logo" src="{{ asset('images/default-logo.png') }}" alt="Default Logo">
            @endif --}}
                <div class="container2">
                    <div class="container2 text-center my-4">
                        <h1 class="business-name">{{ getPreference('business_name', 'My Business') }}</h1>
                    </div>
                    

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
                <a href="{{ route('daily_sales.show', ['date' => \Carbon\Carbon::today()->toDateString()]) }}"
                    style="text-decoration: none;">
                    <div class="carda card2">
                        <h2 class="card-title">Daily Sales</h2>
                        <p class="card-text">
                            <i style="font-size:20px" class="fa fa-chart-line" aria-hidden="true"></i>
                        </p>
                        <h1>{{ number_format($totalSalesToday, 1) }}</h1>
                    </div>
                </a>
                <div class="carda card3 {{ $lowStockCount > 0 ? 'low-stock-alert' : '' }}" data-toggle="modal"
                    data-target="#lowStockModal" style="cursor:pointer;">
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
    .container2 h1 {
        font-size: 4rem;
        font-weight: 900;
        color: #ffffff;
        text-align: center;

        /* 3D Text Effect with Shadows */
        text-shadow:
            1px 1px 0 #c4b2b2,
            2px 2px 0 #222,
            3px 3px 0 #444,
            4px 4px 0 #666;

        letter-spacing: 2px;
        text-transform: uppercase;
        margin-top: 20px;
    }

    .business-name {
    font-size: 4rem;
    font-weight: 900;
    text-align: center;
    text-transform: uppercase;
    letter-spacing: 2px;
    margin: 20px auto;
    max-width: 95%;
    padding: 20px 0;
    border-top: 4px solid #fff;
    border-bottom: 4px solid #fff;

    /* Gradient fill with background-clip */
    background: linear-gradient(45deg, #626464, #008B8B, #dbf0df);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;

    /* 3D shadow */
    text-shadow:
        1px 1px 1px #f1e8e8,
        2px 2px 1px #ebe4e4,
        3px 3px 1px #e2d6d6;

    transition: all 0.3s ease-in-out;
}

/* Glowing hover effect */
.business-name:hover {
    transform: scale(1.05);
    background: linear-gradient(90deg, #ff8a00, #e52e71, #007cf0);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    text-shadow: 2px 2px 4px rgba(0,0,0,0.4);
    letter-spacing: 3px;
}

/* Fade-in animation */
.fade-in {
    opacity: 0;
    animation: fadeInUp 0.5s ease-out forwards;
}

@keyframes fadeInUp {
    0% {
        opacity: 0;
        transform: translateY(20px);
    }
    100% {
        opacity: 1;
        transform: translateY(0);
    }
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
        color: rgb(228, 106, 167);

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

    .business-name {
        font-size: 4rem;
        font-weight: 900;
        color: #ffffff;
        text-align: center;
        text-transform: uppercase;
        letter-spacing: 2px;

        /* 3D effect */
        text-shadow:
            1px 1px 0 #000,
            2px 2px 0 #222,
            3px 3px 0 #444;

        /* Line above and below */
        padding: 20px 0;
        border-top: 4px solid #ffffff;
        border-bottom: 4px solid #ffffff;
        margin: 20px auto;
        max-width: 90%;
    }

  
    /* ========== GLOBAL LOW STOCK STYLING ========== */
    .low-stock-alert {
        background-color: #ff3333;
        border-left: 5px solid yellow;
        color: white;
    }

    /* ========== TABLET VIEW (≤ 768px) ========== */
    @media (max-width: 768px) {

        h1 {
            font-size: 3rem;
        }

        .card-container {
            flex-direction: column;
            align-items: stretch;
            margin: 10px;
        }

        .carda {
            width: 100%;
            height: 140px;
            margin: 10px 0;
            font-size: 0.9rem;
        }

        .card-title {
            font-size: 1.2em;
        }

        .card-text {
            font-size: 0.9em;
            padding: 0 5px;
        }

        .carda h1 {
            font-size: 1.3em;
        }

        .card1 {
            background-color: #30570c;
            border-left: 15px solid rgb(81, 223, 89);
            border-right: 15px solid rgb(81, 223, 89);
        }

        .card2 {
            background-color: #3f0a23;
            border-left: 15px solid rgb(228, 106, 167);
            border-right: 15px solid rgb(228, 106, 167);
            color: rgb(228, 106, 167);
        }

        .card3 {
            background-color: #112a2b;
            border-left: 15px solid rgb(30, 194, 145);
        }

        .low-stock-alert {
            border-left: 15px solid yellow;
            border-right: 15px solid yellow;
        }

       
            .business-name {
                font-size: 2.2rem;
                border-top: 2px solid #ffffff;
                border-bottom: 2px solid #ffffff;
                letter-spacing: 1px;
            }
        
    }

    /* ========== MOBILE VIEW (≤ 480px) ========== */
    @media (max-width: 480px) {
        .carda {
            height: 120px;
        }

        .card-title {
            font-size: 1em;
        }

        .carda h1 {
            font-size: 1.1em;
        }

        .marquee-text {
            font-size: 1.1rem;
        }

        .card1 {
            background-color: #30570c;
            border-left: 15px solid rgb(81, 223, 89);
            border-right: 15px solid rgb(81, 223, 89);
        }

        .card2 {
            background-color: #3f0a23;
            border-left: 15px solid rgb(228, 106, 167);
            border-right: 15px solid rgb(228, 106, 167);
            color: rgb(228, 106, 167);
        }

        .card3 {
            background-color: #112a2b;
            border-left: 25px solid rgb(30, 194, 145);
        }

        .low-stock-alert {
            border-left: 25px solid yellow;
            border-right: 25px solid yellow;
        }


        h1 span {
            font-size: 3rem;
            color: #941b1b;
            font-weight: 600;
        }
    }
</style>
