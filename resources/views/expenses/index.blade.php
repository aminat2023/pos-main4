@extends('layouts.app')

@section('content')
<div class="container" style="color: aliceblue">
    <h2 class="text-center">Expense Records</h2>

    <h4 class="text-danger">Total Expenses: ₦{{ number_format($totalExpenses, 2) }}</h4>

    <a href="{{ route('expenses.create') }}" class="btn btn-primary mb-3">Register Expense</a>

    <table class="table table-bordered table-striped" style="color: aliceblue">
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
@endsection
