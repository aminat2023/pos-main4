<!-- Sidebar -->
<nav class="active" id="sidebar">
    <ul class="list-unstyled lead">
        <li class="active">
            <a href=""><i class="fa fa-home fa-lg"></i> Home</a>
        </li>
        <li>
            <a href="{{ route('orders.index') }}"><i class="fa fa-box fa-lg"></i> Orders</a>
        </li>
        <li>
            <a href="{{ route('product.index') }}"><i class="fa fa-truck fa-lg"></i> Products</a>
        </li>
        <li>
            <a href="{{ route('sections.index') }}"><i class="fa fa-truck fa-lg"></i> Sections</a>
        </li>
        <li>
            <a href="{{ route('categories.index') }}"><i class="fa fa-list-alt"></i> Categories</a>
        </li>
        <li>
            <a href="{{ route('sub_categories.index') }}"><i class="fa fa-list-alt"></i> Sub Categories</a>
        </li>

        <li>        <a href="{{ route('till.withdraw.create') }}"><i class="fa fa-list-alt"></i>Withdraw Till</a>
        </li>

        <li>
            <a href="{{ route('daily_sales.index') }}">
                <i class="fa fa-history"></i> History
            </a>
        </li>
        


        <!-- Settings Dropdown -->
        <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#settingsCollapse" role="button">
                <i class="fa fa-cog"></i> Set-up
            </a>
            <div class="collapse" id="settingsCollapse">
                <ul class="list-group list-group-flush">
                    <li><a class="list-group-item" href="#" data-toggle="modal" data-target="#addUser">Add New User</a></li>
                    <li><a class="list-group-item" href="{{ route('preferences.index') }}">System Preferences</a></li>
                    <li><a class="list-group-item" href="">Payment Methods</a></li>
                </ul>
            </div>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ request()->is('user-activity-logs') ? 'active' : '' }}" href="{{ route('user.activity.logs') }}">
                🕵️ Activity Logs
            </a>
        </li>
        
    </ul>
</nav>

<!-- Add User Modal -->
<div class="modal right fade" id="addUser" data-backdrop="static" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header bg-primary text-white">
                <h4 class="modal-title">Add User</h4>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span>&times;</span>
                </button>
            </div>

            <div class="modal-body">
                @if ($errors->any())
                    <div class="alert alert-danger mt-2">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('users.store') }}" method="post">
                    @csrf
                    <div class="form-group">
                        <label>Name</label>
                        <input type="text" name="name" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Email</label>
                        <input type="email" name="email" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Phone</label>
                        <input type="text" name="phone" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Password</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Confirm Password</label>
                        <input type="password" name="confirm_password" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Role</label>
                        <select name="is_admin" class="form-control">
                            <option value="1">Admin</option>
                            <option value="0">Cashier</option>
                        </select>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-primary btn-block">Save</button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>

<!-- CSS Styling -->
<style>
    #sidebar ul.lead {
        border-bottom: 1px solid #47748b;
        width: fit-content;
    }

    #sidebar ul li a {
        padding: 10px;
        font-size: 1.1rem;
        display: block;
        width: 30vh;
        color: #008B8B;
    }

    #sidebar ul li a:hover {
        color: #fff;
        background: #008B8B;
        text-decoration: none !important;
    }

    #sidebar ul li a i {
        margin-right: 10px;
    }

    #sidebar ul li.active > a,
    a[aria-expanded="true"] {
        color: #fff;
        background: #008B8B;
    }

    .dropdown-submenu {
        position: relative;
    }

    .dropdown-submenu .dropdown-menu {
        top: 0;
        left: 100%;
        margin-left: 0;
        margin-right: 0;
        display: none;
    }

    .dropdown-submenu:hover .dropdown-menu {
        display: block;
    }

    .dropdown-submenu > a::after {
        content: "▶";
        float: right;
        margin-top: 5px;
        margin-right: -10px;
        font-size: 0.7rem;
    }

    .modal.right .modal-dialog {
        position: fixed;
        margin: auto;
        width: 400px;
        height: 100%;
        right: 0;
        top: 0;
        bottom: 0;
    }

    .modal.right .modal-content {
        height: 100%;
        overflow-y: auto;
        border-radius: 0;
    }

    .modal.right.fade .modal-dialog {
        transform: translateX(100%);
        transition: transform 0.3s ease-out;
    }

    .modal.right.fade.show .modal-dialog {
        transform: translateX(0);
    }
</style>
