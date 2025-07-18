<div class="container mt-2">
    <div class="navbar-container card p-3 shadow-sm">
        <!-- Navigation Bar (same across all screen sizes) -->
        <div class="d-flex flex-wrap justify-content-start align-items-center gap-2">
            <a href="#" data-toggle="modal" data-target="#staticBackdrop" class="btn btn-outline rounded-pill nav-btn">
                <i class="fa fa-list"></i>
            </a>
            <a href="{{ route('users.index') }}" class="btn btn-outline rounded-pill nav-btn">
                <i class="fa fa-user"></i> Users
            </a>
            <a href="{{ route('counter_sales.index') }}" class="btn btn-outline rounded-pill nav-btn">
                <i class="fa fa-laptop"></i> Cashier
            </a>
            <a href="{{ route('products_two.index') }}" class="btn btn-outline rounded-pill nav-btn">
                <i class="fa fa-box"></i> Products
            </a>

            <div class="btn-group">
                <button class="btn btn-outline rounded-pill dropdown-toggle nav-btn" data-toggle="dropdown">
                    <i class="fa fa-truck"></i> Supplies
                </button>
                <div class="dropdown-menu">
                    <a class="dropdown-item" href="{{ route('suppliers.create') }}">
                        <i class="fa fa-plus"></i> Add New Supplier
                    </a>
                    <a class="dropdown-item" href="{{ route('supplies.create') }}">
                        <i class="fa fa-plus"></i> Register Supplied Goods
                    </a>
                    <a class="dropdown-item" href="{{ route('supplies.index') }}">
                        <i class="fa fa-list"></i> Goods Supplied
                    </a>
                </div>
            </div>

            <a href="{{ route('expenses.index') }}" class="btn btn-outline rounded-pill nav-btn">
                <i class="fa fa-chart-line"></i> Expenses
            </a>

            <div class="btn-group">
                <button class="btn btn-outline rounded-pill dropdown-toggle nav-btn" data-toggle="dropdown">
                    <i class="fa fa-file-alt"></i> Reports
                </button>
                <div class="dropdown-menu">
                    <a class="dropdown-item" href="{{ route('sales.reports') }}">
                        <i class="fa fa-chart-bar"></i> Sales Report
                    </a>
                    <a class="dropdown-item" href="{{ route('expense.report') }}">
                        <i class="fa fa-file-invoice-dollar"></i> Expense Report
                    </a>
                    <a class="dropdown-item" href="{{ route('profit_loss.index') }}">
                        <i class="fa fa-balance-scale"></i> Profit/Loss Report
                    </a>
                    <a class="dropdown-item" href="{{ route('profit.report.index') }}">
                        <i class="fa fa-book"></i> Profit Report
                    </a>
                    <a class="dropdown-item" href="{{ route('incoming_stock.report.index') }}">
                        <i class="fa fa-truck-loading"></i> Incoming Stock Report
                    </a>
                    <a class="dropdown-item" href="{{ route('vault.report.form') }}">
                        <i class="fa-solid fa-money-bill"></i> Vault Report
                    </a>
                    
                    <a class="dropdown-item" href="{{ route('journal.report') }}">
                        <i class="fa fa-book"></i> Journal Report
                    </a>
                    <a class="dropdown-item" href="{{ route('journal.trial_balance') }}">
                        <i class="fa fa-balance-scale-left"></i> Trial Balance
                    </a>
                    <a class="dropdown-item" href="{{ route('journal.ledger') }}">
                        <i class="fa fa-book-open"></i> Ledger Report
                    </a>
                </div>
            </div>

            <a href="{{ route('incoming_stock.index') }}" class="btn btn-outline rounded-pill nav-btn">
                <i class="fa fa-chart"></i> Incomings
            </a>

            {{-- <li class="nav-item">
                <a class="nav-link" href="{{ route('loans.create') }}">Apply for Loan</a>
            </li> --}}
            

        </div>
    </div>
</div>
<style>
    
    

/* General button styling */
.nav-btn {
    margin: 3px;
    padding: 6px 12px;
    font-size: 14px;
    flex-shrink: 0;
}

/* Rounded outline buttons */
.btn-outline {
    border: 2px solid #14a1a1;
    color: #008B8B;
    background-color: transparent;
    transition: all 0.3s ease;
}

.btn-outline:hover {
    background-color: #008B8B;
    color: white;
    transform: scale(1.03);
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
}

/* Mobile & tablet optimization */
@media (max-width: 991.98px) {
    .nav-btn {
        padding: 2px 4px;
        font-size: 8px;
      
        
    }

    .dropdown-menu {
        font-size: 8px;
      
        
    }
    
}

</style>