@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Create Journal Entry (Version 2)</h3>

    <form method="POST" action="#">
        @csrf
        <div class="mb-3">
            <label>Reference</label>
            <input type="text" class="form-control" value="{{ $reference }}" readonly>
        </div>

        <div class="mb-3">
            <label>Account Type</label>
            <select name="account" class="form-control">
                <option value="">-- Select --</option>
                <option value="cash">Cash</option>
                <option value="bank">Bank</option>
            </select>
        </div>

        <div class="mb-3">
            <label>Bank Name</label>
            <select name="bank_name" class="form-control">
                <option value="">-- Select Bank --</option>
                @foreach($banks as $bank)
                    <option value="{{ $bank }}">{{ $bank }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label>Description</label>
            <input type="text" class="form-control" name="description">
        </div>

        <button type="submit" class="btn btn-primary">Save</button>
    </form>
</div>
@endsection
