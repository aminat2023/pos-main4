@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="text-center">Register Expense</h2>

    <form action="{{ route('expenses.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label>Description</label>
            <input type="text" name="description" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Amount (₦)</label>
            <input type="number" name="amount" class="form-control" min="0.01" step="0.01" required>
        </div>
        <div class="mb-3">
            <label>Date</label>
            <input type="date" name="date" class="form-control" value="{{ date('Y-m-d') }}" required>
        </div>
        <button type="submit" class="btn btn-success">Save Expense</button>
        <a href="{{ route('expenses.index') }}" class="btn btn-secondary">Back</a>
    </form>
</div>
@endsection
