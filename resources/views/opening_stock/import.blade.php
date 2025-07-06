@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card shadow-sm">
        <div class="card-body">
            <ul class="nav nav-tabs mb-3" id="stockTabs" role="tablist">
                <li class="nav-item" role="presentation">
                    <a class="nav-link active" id="import-tab" data-toggle="tab" href="#import" role="tab">📥 Import Excel</a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link" id="manual-tab" data-toggle="tab" href="#manual" role="tab">✍️ Manual Entry</a>
                </li>
            </ul>

            <div class="tab-content" id="stockTabsContent">
                <!-- Excel Import Tab -->
                <div class="tab-pane fade show active" id="import" role="tabpanel">
                    <form action="{{ route('opening_stock.import') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label>Select Excel File:</label>
                            <input type="file" name="stock_file" class="form-control" required>
                        </div>
                        <button type="submit" class="btn btn-primary">📤 Upload & Import</button>
                    </form>
                </div>

                <!-- Manual Entry Tab -->
                <div class="tab-pane fade" id="manual" role="tabpanel">
                    <form action="{{ route('opening_stock.manual.store') }}" method="POST">
                        @csrf
                        <div class="row mt-3">
                            <div class="col-md-6 mb-2">
                                <label>Product Name</label>
                                <input type="text" name="product_name" class="form-control" required>
                            </div>
                            <div class="col-md-6 mb-2">
                                <label>Section</label>
                                <input type="text" name="section" class="form-control" value="General">
                            </div>
                            <div class="col-md-6 mb-2">
                                <label>Category</label>
                                <input type="text" name="category" class="form-control" value="Uncategorized">
                            </div>
                            <div class="col-md-6 mb-2">
                                <label>Quantity</label>
                                <input type="number" name="quantity" class="form-control" required>
                            </div>
                            <div class="col-md-6 mb-2">
                                <label>Cost Price</label>
                                <input type="number" name="cost_price" class="form-control" required>
                            </div>
                            <div class="col-md-6 mb-2">
                                <label>Selling Price</label>
                                <input type="number" name="selling_price" class="form-control" required>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-success mt-2">💾 Save Stock</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
