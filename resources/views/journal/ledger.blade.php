@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card border-0 shadow mb-4">
        <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Ledger Report</h5>
            <div>
                <a href="{{ route('journal.export.ledger', request()->query() + ['format' => 'excel']) }}" class="btn btn-sm btn-success me-2">
                    <i class="bi bi-file-earmark-excel"></i> Excel
                </a>
                <a href="{{ route('journal.export.ledger', request()->query() + ['format' => 'pdf']) }}" class="btn btn-sm btn-danger">
                    <i class="bi bi-file-earmark-pdf"></i> PDF
                </a>
            </div>
        </div>
        <div class="card-body">
            <form class="row g-3 mb-4" method="GET" action="{{ url()->current() }}">
                <div class="col-md-3">
                    <label class="form-label">From</label>
                    <input type="date" name="from" value="{{ request('from') }}" class="form-control">
                </div>
                <div class="col-md-3">
                    <label class="form-label">To</label>
                    <input type="date" name="to" value="{{ request('to') }}" class="form-control">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Account</label>
                    <select name="account" class="form-select">
                        <option value="">-- All --</option>
                        <option value="vault" {{ request('account') == 'vault' ? 'selected' : '' }}>Vault</option>
                        <option value="bank" {{ request('account') == 'bank' ? 'selected' : '' }}>Bank</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Bank</label>
                    <select name="bank_name" class="form-select">
                        <option value="">-- All Banks --</option>
                        @foreach($banks as $bank)
                            <option value="{{ $bank }}" {{ request('bank_name') == $bank ? 'selected' : '' }}>{{ $bank }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-12 d-flex justify-content-between">
                    <button class="btn btn-primary mt-2" type="submit"><i class="bi bi-filter"></i> Filter</button>
                    <a href="{{ route('journal.ledger') }}" class="btn btn-outline-secondary mt-2">Clear</a>
                </div>
            </form>

            <table class="table table-bordered table-striped table-hover">
                <thead class="table-light">
                    <tr>
                        <th>Date</th>
                        <th>Account</th>
                        <th>Bank</th>
                        <th>Description</th>
                        <th>Debit</th>
                        <th>Credit</th>
                        <th>Running Balance</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $balance = 0;
                        $totalDebit = 0;
                        $totalCredit = 0;
                    @endphp
                    @forelse($entries as $entry)
                        @php
                            $totalDebit += $entry->debit;
                            $totalCredit += $entry->credit;
                            $balance += $entry->credit - $entry->debit;
                        @endphp
                        <tr>
                            <td>{{ \Carbon\Carbon::parse($entry->date)->format('Y-m-d') }}</td>
                            <td>{{ ucfirst($entry->account) }}</td>
                            <td>{{ $entry->bank_name ?? '—' }}</td>
                            <td>{{ $entry->description }}</td>
                            <td>{{ number_format($entry->debit, 2) }}</td>
                            <td>{{ number_format($entry->credit, 2) }}</td>
                            <td class="{{ $balance >= 0 ? 'text-success' : 'text-danger' }}">
                                {{ number_format($balance, 2) }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center">No ledger entries found.</td>
                        </tr>
                    @endforelse
                </tbody>
                <tfoot class="table-light fw-bold">
                    <tr>
                        <td colspan="4">Total</td>
                        <td>{{ number_format($totalDebit, 2) }}</td>
                        <td>{{ number_format($totalCredit, 2) }}</td>
                        <td class="{{ ($totalCredit - $totalDebit) >= 0 ? 'text-success' : 'text-danger' }}">
                            {{ number_format($totalCredit - $totalDebit, 2) }}
                        </td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>
@endsection
