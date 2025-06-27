@extends('layouts.app')

@section('content')
<div class="container">
    <h5 class="mb-3">📘 Ledger Report</h5>

    <form method="GET" class="row g-2 mb-4">
        <div class="col-md-2">
            <label>From</label>
            <input type="date" name="from" class="form-control" value="{{ request('from') }}">
        </div>
        <div class="col-md-2">
            <label>To</label>
            <input type="date" name="to" class="form-control" value="{{ request('to') }}">
        </div>
        <div class="col-md-2">
            <label>Account</label>
            <select name="account" class="form-control">
                <option value="">-- All --</option>
                <option value="cash" {{ request('account') == 'cash' ? 'selected' : '' }}>Cash</option>
                <option value="bank" {{ request('account') == 'bank' ? 'selected' : '' }}>Bank</option>
            </select>
        </div>
        <div class="col-md-3">
            <label>Bank</label>
            <select name="bank_name" class="form-control">
                <option value="">-- All Banks --</option>
                @foreach($banks as $bank)
                    <option value="{{ $bank }}" {{ request('bank_name') == $bank ? 'selected' : '' }}>{{ $bank }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-2 align-self-end">
            <button class="btn btn-primary w-100">Filter</button>
        </div>
    </form>

    <table class="table table-bordered table-sm">
        <thead class="bg-light">
            <tr>
                <th>Date</th>
                <th>Ref</th>
                <th>Description</th>
                <th>Debit (₦)</th>
                <th>Credit (₦)</th>
                <th>Balance (₦)</th>
            </tr>
        </thead>
        <tbody>
            @php
                $balance = 0;
            @endphp

            @forelse($entries as $entry)
                @php
                    $balance += $entry->debit ?? 0;
                    $balance -= $entry->credit ?? 0;
                @endphp
                <tr>
                    <td>{{ $entry->date }}</td>
                    <td>{{ $entry->reference }}</td>
                    <td>{{ $entry->description }}</td>
                    <td>{{ number_format($entry->debit, 2) }}</td>
                    <td>{{ number_format($entry->credit, 2) }}</td>
                    <td>{{ number_format($balance, 2) }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center">No records found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
