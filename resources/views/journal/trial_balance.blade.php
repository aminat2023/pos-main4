@extends('layouts.app')

@section('content')
<div class="container">
    <h5 class="mb-3">🧾 Trial Balance</h5>

    <table class="table table-bordered table-sm" style="color: rgb(25, 151, 67);">
        <thead class="bg-light">
            <tr>
                <th>Account</th>
                <th>Bank</th>
                <th>Total Debit (₦)</th>
                <th>Total Credit (₦)</th>
                <th>Balance</th>
            </tr>
        </thead>
        <tbody>
            @php
                $sum_debit = 0;
                $sum_credit = 0;
            @endphp

            @foreach($entries as $entry)
                @php
                    $sum_debit += $entry->total_debit;
                    $sum_credit += $entry->total_credit;
                    $balance = $entry->total_debit - $entry->total_credit;
                @endphp
                <tr>
                    <td>{{ ucfirst($entry->account) }}</td>
                    <td>{{ $entry->bank_name ?? '-' }}</td>
                    <td>{{ number_format($entry->total_debit, 2) }}</td>
                    <td>{{ number_format($entry->total_credit, 2) }}</td>
                    <td>{{ number_format($balance, 2) }}</td>
                </tr>
            @endforeach

            <tr class="fw-bold bg-light">
                <td colspan="2">Total</td>
                <td>{{ number_format($sum_debit, 2) }}</td>
                <td>{{ number_format($sum_credit, 2) }}</td>
                <td>{{ number_format($sum_debit - $sum_credit, 2) }}</td>
            </tr>
        </tbody>
    </table>
</div>
@endsection
