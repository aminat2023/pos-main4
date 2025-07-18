@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card border-0 shadow">
        <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Trial Balance</h5>
            <div>
                <a href="{{ route('journal.export.trial', ['format' => 'excel']) }}" class="btn btn-sm btn-success me-2">
                    <i class="bi bi-file-earmark-excel"></i> Excel
                </a>
                <a href="{{ route('journal.export.trial', ['format' => 'pdf']) }}" class="btn btn-sm btn-danger">
                    <i class="bi bi-file-earmark-pdf"></i> PDF
                </a>
            </div>
        </div>
        <div class="card-body p-4">
            <table class="table table-bordered table-striped table-hover">
                <thead class="table-light">
                    <tr>
                        <th>Account</th>
                        <th>Bank</th>
                        <th>Total Debit</th>
                        <th>Total Credit</th>
                        <th>Balance</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $totalDebit = 0;
                        $totalCredit = 0;
                    @endphp

                    @forelse($entries as $entry)
                        @php
                            $totalDebit += $entry->total_debit;
                            $totalCredit += $entry->total_credit;
                        @endphp
                        <tr>
                            <td>{{ ucfirst($entry->account) }}</td>
                            <td>{{ $entry->bank_name ?? '—' }}</td>
                            <td>{{ number_format($entry->total_debit, 2) }}</td>
                            <td>{{ number_format($entry->total_credit, 2) }}</td>
                            <td class="{{ $entry->total_credit - $entry->total_debit >= 0 ? 'text-success' : 'text-danger' }}">
                                {{ number_format($entry->total_credit - $entry->total_debit, 2) }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center">No trial balance entries found.</td>
                        </tr>
                    @endforelse
                </tbody>
                <tfoot class="table-light fw-bold">
                    <tr>
                        <td colspan="2">Total</td>
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
