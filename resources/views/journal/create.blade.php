@extends('layouts.app')

@section('content')
<div class="container">
    <h4 class="mb-3">New Journal Entry</h4>

    <form action="{{ route('journal.store') }}" method="POST
        @csrf

        <div class="form-group">
            <label>Reference</label>
            <input type="text" name="reference" class="form-control">
        </div>

        <div class="form-group">
            <label>Account</label>
            <input type="text" name="account" class="form-control" required>
        </div>

        <div class="form-group">
            <label>Debit</label>
            <input type="number" name="debit" step="0.01" class="form-control">
        </div>

        <div class="form-group">
            <label>Credit</label>
            <input type="number" name="credit" step="0.01" class="form-control">
        </div>

        <div class="form-group">
            <label>Description</label>
            <textarea name="description" class="form-control"></textarea>
        </div>

        <div class="form-group">
            <label>Date</label>
            <input type="date" name="date" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-success">Post Entry</button>
    </form>
</div>
@endsection
