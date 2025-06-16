<div class="navbar">
    <!-- Buttons -->
    <a href="#" data-toggle="modal" data-target="#staticBackdrop" class="btn btn-outline rounded-pill"><i
            class="fa fa-list"></i></a>
    <a href="{{ route('users.index') }}" class="btn btn-outline rounded-pill"><i class="fa fa-user"></i> Users</a>
    <a href="{{ route('counter_sales.index') }}" class="btn btn-outline rounded-pill"><i class="fa fa-laptop"></i>
        Cashier</a>
    {{-- <a href="{{route('products.barcode')}}" class="btn btn-outline rounded-pill"><i class="fa fa-barcode"></i> Barcode</a> --}}
    <a href="{{ route('products_two.index') }}" class="btn btn-outline rounded-pill"><i class="fa fa-box"></i>
        Products</a>
        <div class="btn-group">
            <button type="button" class="btn btn-outline rounded-pill dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fa fa-truck"></i> Supplies
            </button>
            <div class="dropdown-menu">
                <a class="dropdown-item" href="{{ route('suppliers.create') }}"><i class="fa fa-list"></i> Supplier  Information</a>
                <a class="dropdown-item" href="{{ route('supplies.create') }}"><i class="fa fa-plus"></i> Add New Supply</a>
                <a class="dropdown-item" href="{{ route('supplies.index') }}"><i class="fa fa-list"></i> Goods Supplied</a>
                
            </div>
        </div>
    <a href="{{ route('expenses.index') }}" class="btn btn-outline rounded-pill"><i class="fa fa-chart-line"
            aria-hidden="true"></i>Expenses</a>
            <div class="btn-group">
                <button type="button" class="btn btn-outline rounded-pill dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fa fa-truck"></i> Reports
                </button>
                <div class="dropdown-menu">
                    <a class="dropdown-item" href="{{ route('supplies.create') }}"><i class="fa fa-plus"></i> Purchases Report</a>
                    <a class="dropdown-item" href="{{ route('supplies.index') }}"><i class="fa fa-list"></i> Sales Report</a>
                    {{-- <a class="dropdown-item" href="{{ route('suppliers.create') }}"><i class="fa fa-list"></i> Supplier  Information</a> --}}
                </div>
            </div>
    <a href="{{ route('incoming_stock.index') }}"class="btn btn-outline rounded-pill"><i class="fa fa-chart"></i>
        Incomings</a>
    <a href="{{ route('daily_sales.index') }}" class="btn btn-outline rounded-pill"><i class="history"></i> History</a>

    {{-- <a href="" class="btn btn-outline rounded-pill"><i
        class="fa fa-money-bill"></i>Suppliers</a> --}}


</div>


<!-- Styles -->
<style>
    .navbar {
        margin: 0%;
        padding: 0;
        width: 100%;


    }

    /* .btn-outline {
        border-color:#dfebce;
        color:#dfebce;
    } */

    .btn-outline {
        border: 2px solid #14a1a1;
        /* Define border color */
        color: #008B8B;
        /* Initial text color */
        background-color: transparent;
        /* Initial background */
        transition: background-color 0.3s ease, color 0.3s ease, transform 0.3s ease;
        /* Smooth transition */
    }

    .btn-outline:hover {
        background-color: #008B8B;
        /* Background color on hover */
        color: #f0e8e8;
        /* Text color on hover */
        transform: scale(1.2);
        /* Slightly enlarge the button */
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3);
        /* Add shadow for a polished effect */
    }


    /* Ensure all buttons have uniform padding, margin, and font-size */
    .btn {
        padding: 10px 15px;
        /* Adjust padding for uniformity */
        margin: 3px;
        /* Adjust margin for spacing */
        font-size: 14px;
        /* Set a base font size */
    }
</style>
