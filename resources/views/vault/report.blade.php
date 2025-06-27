@extends('layouts.app')

@section('content')
<div class="container d-flex justify-content-center mt-3">
    <div class="card w-100" style="max-width: 700px; background: white; color: black;">
        <div class="card-body">

            <!-- Business Name -->
            <h3 class="text-center mb-4">{{ getPreference('business_name', 'My Business') }}</h3>

            <!-- Title -->
            <h4 class="mb-3">Vault Balance Report</h4>

            <!-- Export Buttons -->

            {{-- <div class="mb-3 d-flex gap-2">
                <a href="{{ route('vault.export.pdf', request()->all()) }}" class="btn btn-danger btn-sm">Export PDF</a>
                <a href="{{ route('vault.export.excel', request()->all()) }}" class="btn btn-success btn-sm">Export Excel</a>
                <button onclick="window.print()" class="btn btn-dark btn-sm">Print</button>
            </div> --}}

            <!-- Filter -->
            <form class="form-inline mb-3" method="GET" action="{{ route('vault.report') }}">
                <input type="date" name="from" class="form-control mr-2" value="{{ request('from') }}">
                <input type="date" name="to" class="form-control mr-2" value="{{ request('to') }}">
                <button type="submit" class="btn btn-primary">Filter</button>
            </form>

            <!-- Totals -->
            <div class="card mb-3">
                <div class="card-body">
                    <strong>Total In (Credit):</strong> ₦{{ number_format($totalIn, 2) }}<br>
                    <strong>Total Out (Debit):</strong> ₦{{ number_format(abs($totalOut), 2) }}<br>
                    <strong>Current Vault Balance:</strong> ₦{{ number_format($balance, 2) }}
                </div>
            </div>

            <!-- Table -->
            <table class="table table-bordered table-sm">
                <thead class="thead-dark">
                    <tr>
                        <th>#</th>
                        <th>Date</th>
                        <th>User</th>
                        <th>Reason</th>
                        <th>Debit</th>
                        <th>Credit</th>
                     
                       
                        
                    </tr>
                </thead>
                <tbody>
                    @forelse($transactions as $index => $tx)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $tx->created_at->format('Y-m-d H:i') }}</td>
                            <td>{{ $tx->user->name ?? 'N/A' }}</td>
                            <td>{{ $tx->reason }}</td>
                            <td>
                                @if($tx->debit)
                                    ₦{{ number_format($tx->debit, 2) }}
                                @endif
                            </td>
                            <td>
                                @if($tx->credit)
                                    ₦{{ number_format($tx->credit, 2) }}
                                @endif
                            </td>
                            
                            
                           
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6">No transactions found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
