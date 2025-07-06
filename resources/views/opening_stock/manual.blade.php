@extends('layouts.app')

@section('content')
<div class="container">
    <h5>✍️ Manual Opening Stock Entry (Bulk Table Input)</h5>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form action="{{ route('opening_stock.manual.store') }}" method="POST">
        @csrf
        <div class="table-responsive" style="max-height: 600px; overflow: auto;">
            <table class="table table-bordered table-sm">
                <thead class="thead-dark">
                    <tr>
                        <th>#</th>
                        <th>Product Name</th>
                        <th>Section</th>
                        <th>Category</th>
                        <th>Cost Price</th>
                        <th>Selling Price</th>
                        <th>Quantity</th>
                    </tr>
                </thead>
                <tbody>
                    @for ($i = 0; $i < 100; $i++)
                        <tr>
                            <td>{{ $i + 1 }}</td>
                            <td><input type="text" name="stocks[{{ $i }}][product_name]" class="form-control" /></td>
                            <td><input type="text" name="stocks[{{ $i }}][section]" class="form-control" /></td>
                            <td><input type="text" name="stocks[{{ $i }}][category]" class="form-control" /></td>
                            <td><input type="number" step="0.01" name="stocks[{{ $i }}][cost_price]" class="form-control" /></td>
                            <td><input type="number" step="0.01" name="stocks[{{ $i }}][selling_price]" class="form-control" /></td>
                            <td><input type="number" name="stocks[{{ $i }}][quantity]" class="form-control" /></td>
                        </tr>
                    @endfor
                </tbody>
            </table>
        </div>
        <button type="submit" class="btn btn-success mt-3">💾 Save All</button>
    </form>
</div>
@endsection
