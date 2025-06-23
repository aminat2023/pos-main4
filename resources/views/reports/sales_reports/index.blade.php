@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">Cashier Sales Report</h2>

    <table class="table table-bordered table-striped">
        <thead class="thead-dark">
            <tr>
                <th>Cashier Name</th>
                <th>Cashier ID</th>
                <th>Total Transactions</th>
                <th>Total Sales (₦)</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($salesByCashier as $report)
                <tr>
                    <td>{{ $report->user->name ?? 'Unknown' }}</td>
                    <td>{{ $report->user_id }}</td>
                    <td>{{ $report->transaction_count }}</td>
                    <td>{{ number_format($report->total_sales, 2) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
