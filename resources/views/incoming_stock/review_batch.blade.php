@extends('layouts.app')

@section('content')
<div class="container">
    <h4 class="mb-3">🧾 Review Supplies & Add Selling Price Before Import</h4>

    @if($supplies->where('already_imported', false)->count() > 0)
        <form action="{{ route('incoming_stock.submit_batch') }}" method="POST">
            @csrf
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-sm">
                    <thead style="background-color: teal; color: white;">
                        <tr>
                            <th>Product</th>
                            <th>Quantity</th>
                            <th>Cost Price</th>
                            <th>Selling Price</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($supplies as $index => $supply)
                            @if(!$supply->already_imported)
                                <tr>
                                    <td>
                                        {{ $supply->product_name }}
                                        <input type="hidden" name="stocks[{{ $index }}][product_name]" value="{{ $supply->product_name }}">
                                    </td>
                                    <td>
                                        {{ $supply->quantity }}
                                        <input type="hidden" name="stocks[{{ $index }}][quantity]" value="{{ $supply->quantity }}">
                                    </td>
                                    <td>
                                        ₦{{ number_format($supply->unit_price, 2) }}
                                        <input type="hidden" name="stocks[{{ $index }}][cost_price]" value="{{ $supply->unit_price }}">
                                    </td>
                                    <td>
                                        @if($supply->already_imported)
                                            <input type="number" class="form-control" value="{{ $supply->unit_price + 50 }}" disabled>
                                            <input type="hidden" name="stocks[{{ $index }}][selling_price]" value="{{ $supply->unit_price + 50 }}">
                                        @else
                                            <input type="number" step="0.01" min="0" name="stocks[{{ $index }}][selling_price]"
                                                class="form-control" placeholder="Enter selling price" required>
                                        @endif
                                    </td>
                                    
                                </tr>
                            @endif
                        @endforeach
                    </tbody>
                </table>
            </div>

            <button type="submit" class="btn btn-success w-100 mt-3">✅ Import All to Stock</button>
        </form>
    @else
        {{-- <div class="alert alert-info text-center">
            ✅ All supplies have been imported.<br>
            <a href="{{ route('incoming_stock.import_from_supplies') }}" class="btn btn-outline-primary mt-2">
                🔄 Reload Supplies
            </a>
        </div> --}}
    @endif
</div>
@endsection
