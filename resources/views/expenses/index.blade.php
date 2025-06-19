@extends('layouts.app')

@section('content')
<div class="container" style="color: aliceblue">
    <div class="card bg-dark text-white">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h4 class="mb-0">Expense Records</h4>
            <button type="button" class="close text-white" onclick="this.closest('.card').remove();" aria-label="Close" style="font-size: 1.5rem;">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>

        <div class="card-body">
            <h5>Total Expenses: ₦{{ number_format($totalExpenses, 2) }}</h5>

            <a href="{{ route('expenses.create') }}" class="btn btn-primary mb-3">Register Expense</a>

            <div class="table-responsive">
                <table class="table table-bordered table-striped text-white">
                    <thead>
                        <tr>
                            <th>Description</th>
                            <th>Date</th>
                            <th>Amount (₦)</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($expenses as $expense)
                            <tr>
                                <td>{{ $expense->description }}</td>
                                <td>{{ $expense->date }}</td>
                                <td class="text-danger">{{ number_format($expense->amount, 2) }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="text-center">No expenses found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
