<div class="row">
    @forelse ($products_details as $product)
        <div class="col-md-12">
            <div class="form-group">
                <label for="">PROD ID</label>
                <img data-toggle="modal" data-target="#productPreview{{ $product->id }}"
                    src="{{ asset('products/images/' . $product->product_image) }}" alt="" width="100"
                    style="cursor: pointer; padding: 0 5% 5%" height="100%">

                <input type="text" class="form-control" value="{{ $product->id }}" readonly>
            </div>
        </div>

        <div class="col-md-12">
            <div class="form-group">
                <label for="">PROD NAME</label>
                <input type="text" class="form-control" value="{{ $product->product_name }}" readonly>
            </div>
        </div>

        <div class="col-md-12">
            <div class="form-group">
                <label for="">PROD CODE</label>
                <input type="text" class="form-control" value="{{ $product->product_code }}" readonly>

            </div>
        </div>

        <div class="col-md-12">
            <div class="form-group">
                <label for="">PROD PRICE</label>
                <input type="text" class="form-control" value="{{ $product->price }}" readonly>

            </div>
        </div>
        <div class="col-md-12">
            <div class="form-group">
                <label for="">PROD QTY</label>
                <input type="text" class="form-control" value="{{ $product->quantity }}" readonly>

            </div>
        </div>

        <div class="col-md-12">
            <div class="form-group">
                <label for="">STOCK</label>
                <input type="text" class="form-control" value="{{ $product->alert_stock }}" readonly>

            </div>
        </div>

        <div class="col-md-12">
            <div class="form-group">
                <label for="">PROD DESC</label>
                <textarea class="form-control" cols="10" rows="4" readonly>{{ $product->description }}</textarea>

            </div>
        </div>

        <div class="col-md-12">
            <div class="form-group" style="text-align: center !important; padding-left: 8%">
                {{-- <label for="">PROD IMAGE</label> --}}
                <span style="text-align: center">
                    <img src="{{ asset('products/barcodes/' . $product->barcode) }}" alt="Product Barcode"
                        width="90" height="60">
                    <h5>{{ $product->product_code }}</h5>
                </span>
            </div>
        </div>
        @include('products.product_preview')
    @empty
    @endforelse
</div>

<style>
    input:read-only {
        background: #fff !important;
        
    }

    textarea:read-only {
        background: #fff !important;
    }

    
</style>
