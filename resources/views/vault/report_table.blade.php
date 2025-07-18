@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h4 class="text-primary">📄 Vault Report Table</h4>

    @if($transactions->isEmpty())
    <div class="alert alert-warning">No transactions found for the selected period.</div>
@else
    <table class="table table-bordered">
        <thead class="thead-dark">
            <tr>
                <th>#</th>
                <th>Date</th>
                <th>Type</th>
                <th>Amount (₦)</th>
                <th>Reason</th>
                <th>Recorded By</th>
            </tr>
        </thead>
        <tbody>
            @forelse($transactions as $index => $tx)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ \Carbon\Carbon::parse($tx->created_at)->format('Y-m-d H:i') }}</td>
                    <td>{{ ucfirst($tx->type) }}</td>
                    <td>{{ number_format($tx->amount, 2) }}</td>
                    <td>{{ $tx->reason ?? 'N/A' }}</td>
                    <td>{{ $tx->user->name ?? 'Unknown' }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center text-danger">No transactions found for this period.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
    
    @endif

    <a href="{{ route('vault.report.form') }}" class="btn btn-secondary mt-3">← Back to Filter</a>
</div>
@endsection
