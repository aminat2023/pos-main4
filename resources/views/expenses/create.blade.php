@extends('layouts.app')

@section('content')
<div class="container d-flex justify-content-center">
    <div class="card shadow-sm" style="width: 100%; max-width: 500px;">
        <div class="card-header text-white text-center" style="background-color: teal;">
            <h4 class="mb-0">Register Expense</h4>
        </div>

        <div class="card-body">
            <form action="{{ route('expenses.store') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label for="description" class="form-label">Description</label>
                    <input type="text" name="description" id="description" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label for="amount" class="form-label">Amount (₦)</label>
                    <input type="number" name="amount" id="amount" class="form-control" min="0.01" step="0.01" required>
                </div>

                <div class="mb-3">
                    <label for="date" class="form-label">Date</label>
                    <input type="date" name="date" id="date" class="form-control" value="{{ date('Y-m-d') }}" required>
                </div>

                <div class="d-flex justify-content-between">
                    <a href="{{ route('expenses.index') }}" class="btn btn-secondary">Back</a>
                    <button type="submit" class="btn btn-success">Save Expense</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
