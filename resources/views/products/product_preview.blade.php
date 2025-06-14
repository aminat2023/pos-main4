<div class="modal fade" id="productPreview{{ $product->id }}" tabindex="-1"
    aria-labelledby="editproductLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">{{ $product->product_name }}</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div>
                    <img src="{{ asset('products/images/' . $product->product_image) }}" alt="" width="280"
                        height="200" style="cursor: pointer; padding: 0 5% 5%">
                </div>
                <img src="{{ asset('products/barcodes/' . $product->barcode) }}" alt="Product Barcode"
                    width="280">
            </div>
        </div>
    </div>
</div>
