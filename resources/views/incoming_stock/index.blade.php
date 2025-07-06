@extends('layouts.app')

@section('content')
<div class="container d-flex justify-content-center align-items-center" style="min-height: 90vh;">
    <div class="card shadow-sm w-100" style="max-width: 800px; background-color: white; border: 1px solid teal;">

        <div class="card-header text-white py-2 px-3" style="background-color: teal;">
            <h6 class="mb-0 text-center">📦 Incoming Stock Overview</h6>
        </div>

        <div class="card-body px-3 py-4">

            @if (session('success'))
                <div class="alert alert-success alert-sm py-1 px-2 mb-3 text-center">
                    {{ session('success') }}
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                </div>
            @endif

            <div class="text-center mb-4">
                <p class="text-muted mb-2">Quick Stats</p>
                <div class="row text-center">
                    <div class="col-4">
                        <div class="border rounded p-2">
                            <div class="font-weight-bold" style="color: teal;">{{ $totalProducts ?? 0 }}</div>
                            <small class="text-muted">Products</small>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="border rounded p-2">
                            <div class="font-weight-bold" style="color: teal;">{{ $totalQuantity ?? 0 }}</div>
                            <small class="text-muted">Total Stock</small>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="border rounded p-2">
                            <div class="font-weight-bold" style="color: teal;">{{ $totalPending ?? 0 }}</div>
                            <small class="text-muted">Pending Review</small>
                        </div>
                    </div>
                </div>
            </div>

            <a href="{{ route('incoming_stock.review_batch') }}" class="btn btn-sm w-100 text-white mb-4" style="background-color: teal;">
                ✍️ Review Supplies
            </a>

            <h6 class="mb-3" style="color: teal;">🕒 Recent Incoming Stocks</h6>

            <div class="table-responsive">
                <table class="table table-sm table-bordered">
                    <thead class="text-white" style="background-color: teal;">
                        <tr>
                            <th>#</th>
                            <th>Product</th>
                            <th>Qty</th>
                            <th>Cost</th>
                            <th>Selling</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($recentStocks as $stock)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $stock->product->product_name ?? 'N/A' }}</td>
                                <td>{{ $stock->quantity }}</td>
                                <td>{{ number_format($stock->cost_price, 2) }}</td>
                                <td>{{ number_format($stock->selling_price, 2) }}</td>
                                <td>{{ $stock->created_at->format('d M, Y') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted">No recent stock entries</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</div>
@endsection
