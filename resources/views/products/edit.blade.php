@foreach($products as $product)
<div class="modal fade" id="editProduct{{ $product->id }}" tabindex="-1" role="dialog" aria-labelledby="editProductLabel{{ $product->id }}" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editProductLabel{{ $product->id }}">Edit Product</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('product.update', $product->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label for="product_name">Product Name</label>
                        <input type="text" name="product_name" id="product_name" class="form-control" value="{{ $product->product_name }}" required>
                    </div>
                    <div class="form-group">
                        <label for="brand">Brand</label>
                        <input type="text" name="brand" id="brand" class="form-control" value="{{ $product->brand }}" required>
                    </div>
                    <div class="form-group">
                        <label for="alert_stock">Alert Stock</label>
                        <input type="number" name="alert_stock" id="alert_stock" class="form-control" min="0" value="{{ $product->alert_stock }}" required>
                    </div>
                    <div class="form-group">
                        <label for="description">Description</label>
                        <textarea name="description" id="description" class="form-control" required>{{ $product->description }}</textarea>
                    </div>
                    <div class="form-group">
                        <label for="cost_price">Cost Price</label>
                        <input type="number" name="cost_price" id="cost_price" class="form-control" min="0" step="0.01" value="{{ $product->cost_price }}" required>
                    </div>
                    <div class="form-group">
                        <label for="selling_price">Selling Price</label>
                        <input type="number" name="selling_price" id="selling_price" class="form-control" min="0" step="0.01" value="{{ $product->selling_price }}" required>
                    </div>
                    <div class="form-group">
                        <label for="quantity">Quantity</label>
                        <input type="number" name="quantity" id="quantity" class="form-control" min="0" value="{{ $product->quantity }}" required>
                    </div>
                    <div class="form-group">
                        <label for="product_code">Product Code</label>
                        <input type="text" name="product_code" id="product_code" class="form-control" value="{{ $product->product_code }}" required>
                    </div>
                    <div class="form-group">
                        <label for="product_image">Product Image</label>
                        <input type="file" name="product_image" id="product_image" class="form-control" accept="image/*">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Update Product</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endforeach