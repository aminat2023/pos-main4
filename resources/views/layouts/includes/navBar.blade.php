<div class="container mt-2">
    <div class="navbar-container card p-2">
        <div class="d-flex flex-wrap justify-content-between align-items-center gap-1">

            <!-- Buttons -->
            <a href="#" data-toggle="modal" data-target="#staticBackdrop" class="btn btn-outline rounded-pill">
                <i class="fa fa-list"></i>
            </a>

            <a href="{{ route('users.index') }}" class="btn btn-outline rounded-pill">
                <i class="fa fa-user"></i> Users
            </a>

            <a href="{{ route('counter_sales.index') }}" class="btn btn-outline rounded-pill">
                <i class="fa fa-laptop"></i> Cashier
            </a>

            <a href="{{ route('products_two.index') }}" class="btn btn-outline rounded-pill">
                <i class="fa fa-box"></i> Products
            </a>

            <!-- Supplies Dropdown -->
            <div class="btn-group">
                <button type="button" class="btn btn-outline rounded-pill dropdown-toggle" data-toggle="dropdown"
                    aria-haspopup="true" aria-expanded="false">
                    <i class="fa fa-truck"></i> Supplies
                </button>
                <div class="dropdown-menu">
                    <a class="dropdown-item" href="{{ route('suppliers.create') }}"><i class="fa fa-plus"></i> Add New
                        Supplier</a>
                    <hr>
                    <a class="dropdown-item" href="{{ route('supplies.create') }}"><i class="fa fa-plus"></i> Register
                        Supplied Goods</a>
                    <hr>
                    <a class="dropdown-item" href="{{ route('supplies.index') }}"><i class="fa fa-list"></i> Goods
                        Supplied</a>
                </div>
            </div>

            <a href="{{ route('expenses.index') }}" class="btn btn-outline rounded-pill">
                <i class="fa fa-chart-line"></i> Expenses
            </a>

            <!-- Reports Dropdown -->
            <div class="btn-group">
                <button type="button" class="btn btn-outline rounded-pill dropdown-toggle" data-toggle="dropdown"
                    aria-haspopup="true" aria-expanded="false">
                    <i class="fa fa-file-alt"></i> Reports
                </button>
                <div class="dropdown-menu">
                    {{-- <a class="nav-link" href="{{ route('sales.reports') }}">Cashier Sales Report</a> --}}
                    <a class="dropdown-item" href="{{ route('sales.reports') }}" >
                        <i class="fa fa-chart-bar"></i> Sales Report</a>
                        <hr>
                    <a class="dropdown-item" href="{{ route('expense.report') }}">
                        <i class="fa fa-file-invoice-dollar"></i> Expense Report
                    </a>
                    <br>
                    <a class="dropdown-item" href="{{ route('profit_loss.index') }}">
                        <i class="fa fa-file-invoice-dollar"></i> Profit/Loss Report
                    </a>
                   
                        <a class="nav-link {{ request()->is('profit-report') ? 'active' : '' }}" href="{{ route('profit.report.index') }}">
                            📈 Profit Report
                        </a>
                   
                </div>
            </div>

            <a href="{{ route('incoming_stock.index') }}" class="btn btn-outline rounded-pill">
                <i class="fa fa-chart"></i> Incomings
            </a>


        </div>
    </div>
</div>

<!-- Responsive Styles -->
<style>
    .btn-outline {
        border: 2px solid #14a1a1;
        color: #008B8B;
        background-color: transparent;
        transition: background-color 0.3s ease, color 0.3s ease, transform 0.3s ease;
    }

    .btn-outline:hover {
        background-color: #008B8B;
        color: #ffffff;
        transform: scale(1.05);
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
    }

    .btn {
        padding: 5px 15px;
        margin: 4px;
        font-size: 14px;
    }

    @media (max-width: 768px) {
        .navbar-container {
            padding: 1rem;
        }

        .navbar-container .btn {
            width: 100%;
            text-align: left;
            justify-content: flex-start;
        }

        .btn-group {
            width: 100%;
        }

        .btn-group .dropdown-menu {
            width: 100%;
        }
    }
</style>
