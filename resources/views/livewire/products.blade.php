<div style="padding: 0 8%;">
    <!-- Display Success and Error Messages -->
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="col-lg-12">
        <div class="row">
            <div class="col-md-8">
                <div class="card mb-4">
                    <div class="card-header" style="background: #008B8B; color: white;">
                        <div class="d-flex justify-content-between align-items-center">
                            <h4 class="mb-0">Manage Products</h4>
                            <a href="#" class="btn btn-dark" data-toggle="modal" data-target="#addproduct">
                                <i class="fa fa-plus"></i> Add New Product
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        @include('products.table')
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card mb-4">
                    <div class="card-header" style="background: #008B8B; color: white;">
                        <h4 class="mb-0">PRODUCT DETAILS</h4>
                    </div>
                    <div class="card-body">
                        @include('products.product_detail')
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .alert {
        margin-bottom: 20px;
    }

    .card {
        box-shadow: 0 4px 8px rgba(0, 0, 0, 10);
        /* Box shadow effect */
        transition: box-shadow 0.3s ease;
        /* Smooth transition for hover effect */
        outline: none;
        /* Remove outline */
        border-radius: 8px;
    }

    .card-header {
        box-shadow: 0 4px 8px rgba(20, 20, 20, 0.9);
        /* Box shadow effect */
        transition: box-shadow 0.3s ease;
        /* Smooth transition for hover effect */
        outline: none;
        /* Remove outline */
        border-radius: 20px;
    }

    .card:hover {
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.9);
        /* Enhanced shadow on hover */
    }



    .btn-dark {
        background-color: #343a40;
        border-color: #343a40;
        transition: background-color 0.3s ease;
    }

    .btn-dark:hover {
        background-color: #23272b;
        border-color: #1d2124;
    }

    .pagination {
        justify-content: center;
    }

    /* Table styles */
    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
    }

    th,
    td {
        padding: 12px;
        text-align: left;
        border-bottom: 1px solid #ddd;
    }

    th {
        background-color: #f8f9fa;
        color: #343a40;
        font-weight: bold;
        text-align: center;
        /* Centered headers for better alignment */
    }

    td {
        text-align: center;
        /* Centered content in cells */
    }

    tr:hover {
        background-color: #f1f1f1;
        /* Light gray on hover */
    }

    /* Responsive adjustments */
    @media (max-width: 768px) {
        .btn-dark {
            width: 100%;
            margin-top: 10px;
        }

        .card {
            margin-bottom: 20px;
            /* Space between cards on mobile */
        }
    }
</style>
