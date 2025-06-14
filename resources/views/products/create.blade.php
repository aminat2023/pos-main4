

<!-- The Modal -->
<div class="modal fade" id="addProductModal" tabindex="-1" role="dialog" aria-labelledby="addProductModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addProductModalLabel">Add New Product</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('product.store') }}" method="POST" id="addProductForm" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="product_name">Product Name</label>
                        <input type="text" name="product_name" id="product_name" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="brand">Brand</label>
                        <input type="text" name="brand" id="brand" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="alert_stock">Alert Stock</label>
                        <input type="number" name="alert_stock" id="alert_stock" class="form-control" min="0" required>
                    </div>
                    <div class="form-group">
                        <label for="description">Description</label>
                        <textarea name="description" id="description" class="form-control" required></textarea>
                    </div>
                    <div class="form-group">
                        <label for="cost_price">Cost Price</label>
                        <input type="number" name="cost_price" id="cost_price" class="form-control" min="0" step="0.01" required>
                    </div>
                    <div class="form-group">
                        <label for="selling_price">Selling Price</label>
                        <input type="number" name="selling_price" id="selling_price" class="form-control" min="0" step="0.01" required>
                    </div>
                    <div class="form-group">
                        <label for="quantity">Quantity</label>
                        <input type="number" name="quantity" id="quantity" class="form-control" min="0" required>
                    </div>
                    <div class="form-group">
                        <label for="product_code">Product Code</label>
                        <input type="text" name="product_code" id="product_code" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="product_image">Product Image</label>
                        <input type="file" name="product_image" id="product_image" class="form-control" accept="image/*">
                    </div>
                    <button type="submit" class="btn btn-primary">Add Product</button>
                </form>
            </div>
        </div>
    </div>
</div>
<style>
    label{
        color:black;
    }
</style>