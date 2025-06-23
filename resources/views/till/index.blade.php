@extends('layouts.app')

@section('content')
<div class="container">
    <h3 class="mb-4">Till Withdrawals History</h3>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>Cashier</th>
                <th>Admin</th>
                <th>Destination</th>
                <th>Denominations</th>
                <th>Total Amount</th>
                <th>Notes</th>
                <th>Date</th>
            </tr>
        </thead>
        <tbody>
            @forelse($withdrawals as $withdrawal)
                <tr>
                    <td>{{ $withdrawal->cashier->name ?? 'N/A' }}</td>
                    <td>{{ $withdrawal->admin->name ?? 'N/A' }}</td>
                    <td>{{ ucfirst($withdrawal->destination) }}</td>
                    <td>
                        @foreach ($withdrawal->denominations as $note => $count)
                            ₦{{ $note }} x {{ $count }}<br>
                        @endforeach
                    </td>
                    <td>₦{{ number_format($withdrawal->total_amount, 2) }}</td>
                    <td>{{ $withdrawal->notes }}</td>
                    <td>{{ $withdrawal->created_at->format('Y-m-d H:i') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="text-center">No withdrawals found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
