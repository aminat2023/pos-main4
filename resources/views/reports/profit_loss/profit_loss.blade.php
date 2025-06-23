@extends('layouts.app')

@section('content')
<div class="container mt-4" style="background-color: aliceblue">
    <h4 class="mb-4">📊 Profit & Loss Report</h4>

    <form method="GET" action="{{ route('profit_loss.index') }}" class="row mb-4">
        <div class="col-md-3">
            <label>From</label>
            <input type="date" name="from_date" value="{{ $from }}" class="form-control">
        </div>
        <div class="col-md-3">
            <label>To</label>
            <input type="date" name="to_date" value="{{ $to }}" class="form-control">
        </div>
        <div class="col-md-3 align-self-end">
            <button type="submit" class="btn btn-primary">Filter</button>
        </div>
    </form>

    <table class="table table-bordered table-striped">
        <thead class="thead-dark">
            <tr>
                <th>Date</th>
                <th>Description</th>
                <th>Type</th>
                <th class="text-right">Amount (₦)</th>
            </tr>
        </thead>
        <tbody>
            @php
                $totalProfit = 0;
                $totalExpense = 0;
            @endphp

            @forelse($report as $entry)
                <tr>
                    <td>{{ $entry['date'] }}</td>
                    <td>{{ $entry['description'] }}</td>
                    <td>
                        @if($entry['type'] == 'Credit')
                            <span class="text-success">Credit</span>
                            @php $totalProfit += $entry['amount']; @endphp
                        @else
                            <span class="text-danger">Debit</span>
                            @php $totalExpense += $entry['amount']; @endphp
                        @endif
                    </td>
                    <td class="text-right">
                        {{ number_format($entry['amount'], 2) }}
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="text-center">No records found for the selected period.</td>
                </tr>
            @endforelse
        </tbody>

        <tfoot>
            <tr>
                <th colspan="3">Total Profit (Credit)</th>
                <th class="text-success text-right">{{ number_format($totalProfit, 2) }}</th>
            </tr>
            <tr>
                <th colspan="3">Total Expenses (Debit)</th>
                <th class="text-danger text-right">{{ number_format($totalExpense, 2) }}</th>
            </tr>
            <tr>
                <th colspan="3">Net Profit / Loss</th>
                <th class="text-right {{ $totalProfit - $totalExpense >= 0 ? 'text-success' : 'text-danger' }}">
                    {{ number_format($totalProfit - $totalExpense, 2) }}
                </th>
            </tr>
        </tfoot>
    </table>
</div>
@endsection
