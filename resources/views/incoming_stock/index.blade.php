@extends('layouts.app')

@section('content')
<div class="container d-flex justify-content-center align-items-center" style="min-height: 85vh;">
    <div class="card shadow-sm w-100" style="max-width: 700px;">

        <div class="card-header text-white py-2 px-3" style="background-color: teal;">
            <h6 class="mb-0 text-center">➕ Add Incoming Stock</h6>
        </div>

        <div class="card-body px-3 py-2">
            @if (session('success'))
                <div class="alert alert-success alert-sm py-1 px-2 mb-2">
                    {{ session('success') }}
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                </div>
            @endif

            <form action="{{ route('incoming_stock.store') }}" method="POST">
                @csrf

                <div class="form-group mb-2">
                    <label for="product_search" class="small mb-1">Search Product</label>
                    <input type="text" id="product_search" name="product_search" class="form-control form-control-sm" 
                        placeholder="Name or Code" list="productSuggestions" required>
                    <datalist id="productSuggestions">
                        @foreach($products as $product)
                            <option 
                                value="{{ $product->product_name }} ({{ $product->product_code }})"
                                data-code="{{ $product->product_code }}"
                                data-name="{{ $product->product_name }}"
                                data-cost="{{ $product->cost_price }}"
                                data-quantity="1"
                            >
                        @endforeach
                    </datalist>
                </div>

                <input type="hidden" id="product_code" name="product_code">

                <div class="form-group mb-2">
                    <label for="quantity" class="small mb-1">Quantity</label>
                    <input type="number" name="quantity" id="quantity" class="form-control form-control-sm" required>
                </div>

                <div class="form-group mb-2">
                    <label for="cost_price" class="small mb-1">Cost Price</label>
                    <input type="number" step="0.01" name="cost_price" id="cost_price" class="form-control form-control-sm" required>
                </div>

                <div class="form-group mb-3">
                    <label for="selling_price" class="small mb-1">Selling Price</label>
                    <input type="number" step="0.01" name="selling_price" id="selling_price" class="form-control form-control-sm" required>
                </div>

                <button type="submit" class="btn btn-sm w-100 text-white" style="background-color: teal;">
                    ➕ Save Stock
                </button>
            </form>

            <a href="{{ route('incoming_stock.review_batch') }}" class="btn btn-sm btn-primary mt-2 w-100">
                ✍️ Review Supplies
            </a>
        </div>
    </div>
</div>

<script>
document.getElementById('product_search').addEventListener('input', function(e) {
    const input = e.target.value;
    const datalist = document.getElementById('productSuggestions');
    const hiddenField = document.getElementById('product_code');

    const options = datalist.options;
    let matchFound = false;

    for (let i = 0; i < options.length; i++) {
        if (options[i].value === input) {
            const codeMatch = input.match(/\(([^)]+)\)/);
            hiddenField.value = codeMatch ? codeMatch[1] : '';

            document.getElementById('quantity').value = options[i].dataset.quantity || 1;
            document.getElementById('cost_price').value = options[i].dataset.cost || 0;
            document.getElementById('selling_price').value = parseFloat(options[i].dataset.cost || 0) + 50;

            matchFound = true;
            break;
        }
    }

    if (!matchFound) {
        hiddenField.value = '';
        document.getElementById('quantity').value = '';
        document.getElementById('cost_price').value = '';
        document.getElementById('selling_price').value = '';
    }
});
</script>
@endsection
