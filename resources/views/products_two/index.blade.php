@extends('layouts.app')

@section('content')
    <div class="container">
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

        <div class="col-lg-12">
            <div class="row">
                <!-- Product Management Section -->
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
                                        <th>Alert Stock</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($products as $key => $product)
                                        <tr>
                                            <td>{{ $product->product_name }}</td>
                                            <td>{{ $product->brand }}</td>
                                            <td>{{ $product->alert_stock }}</td>
                                            <td>
                                                <div class="btn-group">
                                                    <!-- View Details button -->
                                                    <button type="button" class="btn btn-primary btn-sm"
                                                        data-toggle="modal" data-target="#viewProduct{{ $product->id }}">
                                                        <i class="fa fa-eye"></i>
                                                    </button>
                                                    <!-- Edit button -->
                                                    <a href="#" class="btn btn-info btn-sm" data-toggle="modal"
                                                        data-target="#editProduct{{ $product->id }}">
                                                        <i class="fa fa-edit"></i>
                                                    </a>
                                                    <!-- Delete button -->
                                                    <button type="button" class="btn btn-danger btn-sm" data-toggle="modal"
                                                        data-target="#deleteProduct{{ $product->id }}">
                                                        <i class="fa fa-trash"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>

                                        <!-- View Product Details Modal -->
                                        <div class="modal fade" id="viewProduct{{ $product->id }}" tabindex="-1"
                                            role="dialog" aria-labelledby="viewProductLabel{{ $product->id }}"
                                            aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="viewProductLabel{{ $product->id }}">
                                                            Product Details</h5>
                                                        <button type="button" class="close" data-dismiss="modal"
                                                            aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <p><strong>Product Name:</strong> {{ $product->product_name }}</p>
                                                        <p><strong>Brand:</strong> {{ $product->brand }}</p>
                                                        <p><strong>Description:</strong> {{ $product->description }}</p>
                                                        <p><strong>Quantity:</strong> {{ $product->quantity }}</p>
                                                        <p><strong>Alert Stock:</strong> {{ $product->alert_stock }}</p>
                                                        <p><strong>Barcode:</strong> {{ $product->barcode }}</p>
                                                        <p><strong>QRCode:</strong> {{ $product->qrcode }}</p>
                                                        @if ($product->product_image)
                                                            <p><strong>Product Image:</strong></p>
                                                            <img src="{{ asset('products/images/' . $product->product_image) }}"
                                                                alt="Product Image" class="img-fluid">
                                                        @endif
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-dismiss="modal">Close</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Existing Edit and Delete modals go here -->
                                        <!-- Edit Product Modal -->
                                        <div class="modal fade" id="editProduct{{ $product->id }}" tabindex="-1"
                                            role="dialog" aria-labelledby="editProductLabel{{ $product->id }}"
                                            aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">

                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="editProductLabel{{ $product->id }}">
                                                            Edit Product</h5>
                                                        <button type="button" class="close" data-dismiss="modal"
                                                            aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <form action="{{ route('products_two.update', $product->id) }}"
                                                        method="POST" enctype="multipart/form-data">
                                                        @csrf
                                                        @method('PUT')
                                                        <div class="modal-body">
                                                            <div class="form-group">
                                                                <label for="section_id">Section</label>
                                                                <select name="section_id" class="form-control" required>
                                                                    @foreach ($sections as $section)
                                                                        <option value="{{ $section->id }}" {{ $section->section_name == $product->section_name ? 'selected' : '' }}>
                                                                            {{ $section->section_name }}
                                                                        </option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                            
                                                            <div class="form-group">
                                                                <label for="category_id">Category</label>
                                                                <select name="category_id" class="form-control" required>
                                                                    @foreach ($categories as $category)
                                                                        <option value="{{ $category->id }}" {{ $category->category_name == $product->category_name ? 'selected' : '' }}>
                                                                            {{ $category->category_name }}
                                                                        </option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                            
                                                            <div class="form-group">
                                                                <label for="product_name">Product Name</label>
                                                                <input type="text" name="product_name"
                                                                    class="form-control"
                                                                    value="{{ $product->product_name }}" required>
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="brand">Brand</label>
                                                                <input type="text" name="brand" class="form-control"
                                                                    value="{{ $product->brand }}">
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="description">Description</label>
                                                                <textarea name="description" class="form-control" required>{{ $product->description }}</textarea>
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="alert_stock">Alert Stock</label>
                                                                <input type="number" name="alert_stock"
                                                                    class="form-control"
                                                                    value="{{ $product->alert_stock }}" required>
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="barcode">Barcode</label>
                                                                <input type="text" name="barcode" class="form-control"
                                                                    value="{{ $product->barcode }}">
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="qrcode">QRCode</label>
                                                                <input type="text" name="qrcode" class="form-control"
                                                                    value="{{ $product->qrcode }}">
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="product_image">Product Image</label>
                                                                <input type="file" name="product_image"
                                                                    class="form-control">
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary"
                                                                data-dismiss="modal">Close</button>
                                                            <button type="submit" class="btn btn-primary">Save
                                                                changes</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Delete Product Modal -->
                                        <div class="modal fade" id="deleteProduct{{ $product->id }}" tabindex="-1"
                                            role="dialog" aria-labelledby="deleteProductLabel{{ $product->id }}"
                                            aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title"
                                                            id="deleteProductLabel{{ $product->id }}">Delete Product</h5>
                                                        <button type="button" class="close" data-dismiss="modal"
                                                            aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        Are you sure you want to delete this product?
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-dismiss="modal">Cancel</button>
                                                        <form action="{{ route('products_two.destroy', $product->id) }}"
                                                            method="POST">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-danger">Delete</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Product Details Section -->
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

       
        <!-- Add Product Modal -->
        <div class="modal fade" id="addProduct" tabindex="-1" role="dialog" aria-labelledby="addProductLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form action="{{ route('products_two.store') }}" method="POST" enctype="multipart/form-data"
                class="modal-content">
                @csrf
                <div class="modal-header" style="background-color: teal;color:white;text-align:center;">
                    <h5 class="modal-title" style="font-size: 2rem;">Add New Product</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <div class="form-group">
                        <label>Section</label>
                        <select name="section_id" class="form-control" required>
                            <option value="">-- Select Section --</option>
                            @foreach ($sections as $section)
                                <option value="{{ $section->id }}">{{ $section->section_name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Category</label>
                        <select name="category_id" class="form-control" required>
                            <option value="">-- Select Category --</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->category_name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Product Name</label>
                        <input type="text" name="product_name" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label>Brand</label>
                        <input type="text" name="brand" class="form-control">
                    </div>

                    <div class="form-group">
                        <label>Description</label>
                        <textarea name="description" class="form-control" required></textarea>
                    </div>

                    <div class="form-group">
                        <label>Alert Stock</label>
                        <input type="number" name="alert_stock" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label>Barcode</label>
                        <input type="text" name="barcode" class="form-control">
                    </div>

                    <div class="form-group">
                        <label>QRCode</label>
                        <input type="text" name="qrcode" class="form-control">
                    </div>

                    <div class="form-group">
                        <label>Product Image</label>
                        <input type="file" name="product_image" class="form-control">
                    </div>
                </div>

                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Close</button>
                    <button class="btn btn-primary" type="submit">Add Product</button>
                </div>
            </form>
        </div>
    </div>

    </div>
@endsection
