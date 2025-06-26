@extends('layouts.app')

@section('content')
<div class="container">
    <h4 class="mb-3">Vault Balance Report</h4>

    <form class="form-inline mb-3" method="GET" action="{{ route('vault.report') }}">
        <input type="date" name="from" class="form-control mr-2" value="{{ request('from') }}">
        <input type="date" name="to" class="form-control mr-2" value="{{ request('to') }}">
        <button type="submit" class="btn btn-dark">Filter</button>
    </form>

    <div class="card mb-3">
        <div class="card-body">
            <strong>Total In:</strong> ₦{{ number_format($totalIn, 2) }}<br>
            <strong>Total Out:</strong> ₦{{ number_format(abs($totalOut), 2) }}<br>
            <strong>Current Vault Balance:</strong> ₦{{ number_format($balance, 2) }}
        </div>
    </div>

    <table class="table table-bordered">
        <thead class="thead-dark">
            <tr>
                <th>#</th>
                <th>Type</th>
                <th>Amount</th>
                <th>Reason</th>
                <th>User</th>
                <th>Date</th>
            </tr>
        </thead>
        <tbody>
            @forelse($transactions as $index => $tx)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>
                        <span class="badge badge-{{ $tx->type == 'in' ? 'success' : 'danger' }}">
                            {{ ucfirst($tx->type) }}
                        </span>
                    </td>
                    <td>₦{{ number_format(abs($tx->amount), 2) }}</td>
                    <td>{{ $tx->reason }}</td>
                    <td>{{ $tx->user->name ?? 'N/A' }}</td>
                    <td>{{ $tx->created_at->format('Y-m-d H:i') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="6">No transactions found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
