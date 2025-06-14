@extends('layouts.app')

@section('content')
    <div class="container">
        <!-- Display Success Message -->
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

        {{-- @livewire('products') --}}

        <div class="col-lg-12">
            <div class="row">
                <div class="col-md-9">
                    <div class="card">
                        <div class="card-header">
                            <h4 style="float:left">Product Management</h4>
                            <a href="#" style="float:right" class="btn btn-dark" data-toggle="modal"
                                data-target="#addProduct">
                                <i class="fa fa-plus"></i> Add new product
                            </a>
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered table-left">
                                <thead>
                                    <tr>
                                        <th>Product Name</th>
                                        <th>Brand</th>
                                        <th>Cost Price</th>
                                        <th>Selling Price</th>
                                        <th>Quantity</th>
                                        <th>Alert stock</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($products as $key => $product)
                                        <tr>
                                            <td>{{ $product->product_name }}</td>
                                            <td>{{ $product->brand }}</td>
                                            <td>{{ number_format($product->cost_price, 2) }}</td>
                                            <td>{{ number_format($product->selling_price, 2) }}</td>
                                            <td>{{ $product->quantity }}</td>
                                            <td>{{ $product->alert_stock }}</td>
                                            <td>
                                                <div class="btn-group">
                                                    {{-- <a href="#" class="btn btn-info btn-sm" data-toggle="modal"
                                                        data-target="#editProduct{{ $product->id }}">
                                                        <i class="fa fa-edit"></i>
                                                    </a> --}}
                                                    <button type="button" class="btn btn-sm btn-danger" data-toggle="modal"
                                                        data-target="#deleteProduct{{ $product->product_code }}">
                                                        <i class="fa fa-trash"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                {{-- PRODUCT DETAILS --}}
                <div class="col-md-3">
                    <div class="card">
                        <div class="card-header">
                            <h5>Product Details</h5>
                        </div>
                        <div class="card-body">
                            <!-- Search form goes here -->
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- MODAL FOR EDITING PRODUCT -->
    @include('products.edit')


    <!-- MODAL OF ADDING NEW PRODUCT -->
    <div class="modal right fade" id="addProduct" data-backdrop="static" data-keyboard="false" tabindex="-1"
        aria-labelledby="addProduct" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header" style="background-color: #008B8B; box-shadow: 0 4px 8px rgba(20, 20, 20, 0.9);">
                    <h4 class="modal-title">Add New Product</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('product.store') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="product_name">Product Name</label>
                            <input type="text" name="product_name" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label for="brand">Brand</label>
                            <input type="text" name="brand" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label for="alert_stock">Alert Stock</label>
                            <input type="number" name="alert_stock" class="form-control" required min="0">
                        </div>

                        <div class="form-group">
                            <label for="description">Description</label>
                            <textarea name="description" class="form-control" required></textarea>
                        </div>

                        <div class="form-group">
                            <label for="cost_price">Cost Price</label>
                            <input type="number" name="cost_price" class="form-control" step="0.01" required>
                        </div>

                        <div class="form-group">
                            <label for="selling_price">Selling Price</label>
                            <input type="number" name="selling_price" class="form-control" step="0.01" required>
                        </div>

                        <div class="form-group">
                            <label for="quantity">Quantity</label>
                            <input type="number" name="quantity" class="form-control" required min="0">
                        </div>

                        <div class="form-group">
                            <label for="product_code">Product Code</label>
                            <input type="text" name="product_code" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label for="product_image">Upload Image</label>
                            <input type="file" id="product_image" name="product_image" accept="image/*">
                        </div>

                        <!-- New Batch Date Field -->
                        
                        <div class="form-group">
                            <label for="batch_date">Batch Date</label>
                            <input type="date" name="batch_date" class="form-control" required readonly>
                        </div>


                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary btn-block">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


    {{-- DELETE MODAL --}}
    {{-- @foreach ($products as $product)
        <div class="modal fade" id="deleteProduct{{ $product->product_code}}" tabindex="-1" role="dialog"
            aria-labelledby="deleteProductLabel{{ $product->product_code}}" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content" style="color: #008B8B">
                    <div class="modal-header" style="background-color: #008B8B; color: white;">
                        <h5 class="modal-title" id="deleteProductLabel{{ $product->product_code }}">Confirm Delete</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <b>Are you sure you want to delete <strong>{{ $product->product_name }}</strong>? This action
                            cannot be undone.</b>
                    </div>
                    <div class="modal-footer">
                        <form action="{{ route('product.destroy', $product->product_code) }}" method="POST"
                            style="display:inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Delete</button>
                        </form>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    </div>
                </div>
            </div>
        </div>
    @endforeach --}}
    @foreach ($products as $product)

    <!-- Modal -->
    <div class="modal fade" id="deleteProduct{{ $product->product_code }}" tabindex="-1" role="dialog"
        aria-labelledby="deleteProductLabel{{ $product->product_code }}" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content" style="color: #008B8B">
                <div class="modal-header" style="background-color: #008B8B; color: white;">
                    <h5 class="modal-title" id="deleteProductLabel{{ $product->product_code }}">Confirm Delete</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <b>Are you sure you want to delete <strong>{{ $product->product_name }}</strong>? This action
                        cannot be undone.</b>
                </div>
                <div class="modal-footer">
                    <form id="delete-form-{{ $product->product_code }}" action="{{ route('product.destroy', $product->product_code) }}" method="POST" style="display:inline-block;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </form>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                </div>
            </div>
        </div>
    </div>
@endforeach



    <style>
        .modal.right .modal-dialog {
            top: 0;
            right: 0;
            margin-right: 19vh;
        }

        .modal.fade:not(.in).right .modal-dialog {
            -webkit-transform: translate3d(25%, 0, 0);
            transform: translate3d(25%, 0, 0);
        }

        .card {
            box-shadow: 0 4px 8px rgba(0, 0, 0, 10);
            transition: box-shadow 0.3s ease;
            outline: none;
            border-radius: 5px;
        }

        .card-header {
            box-shadow: 0 4px 8px rgba(20, 20, 20, 0.9);
            transition: box-shadow 0.3s ease;
            outline: none;
            border-radius: 20px;
            background-color: #008B8B;
        }

        label {
            color: #000;
        }

        .card:hover {
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.9);
        }
    </style>

<script>
    function confirmDelete(productId) {
        swal({
            title: "Are you sure?",
            text: "Once deleted, you will not be able to recover this product!",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        }).then((willDelete) => {
            if (willDelete) {
                // Submit the form to delete the product
                document.getElementById('delete-form-' + productId).submit();
            }
        });
    }
</script>
@endsection
