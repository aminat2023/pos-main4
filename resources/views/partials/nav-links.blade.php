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

<div class="btn-group">
    <button class="btn btn-outline rounded-pill dropdown-toggle" data-toggle="dropdown">
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

<a href="{{ route('expenses.index') }}" class="btn btn-outline rounded-pill">
    <i class="fa fa-chart-line"></i> Expenses
</a>

<div class="btn-group">
    <button class="btn btn-outline rounded-pill dropdown-toggle" data-toggle="dropdown">
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
        <a class="dropdown-item {{ request()->is('profit-report') ? 'active' : '' }}" href="{{ route('profit.report.index') }}">
            <i class="fa fa-book"></i> Profit Report
        </a>
        <a class="dropdown-item" href="{{ route('incoming_stock.report.index') }}">
            <i class="fa fa-truck-loading"></i> Incoming Stock Report
        </a>
        <a class="dropdown-item" href="{{ route('vault.report') }}">
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

<a href="{{ route('incoming_stock.index') }}" class="btn btn-outline rounded-pill">
    <i class="fa fa-chart"></i> Incomings
</a>


