@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header bg-dark text-white">
            <h5>Vault {{ request()->is('vault/in') ? 'Deposit (From Bank)' : 'Withdrawal (To Bank)' }}</h5>
        </div>
        <div class="card-body">

            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <form action="{{ route('vault.store') }}" method="POST">
                @csrf
                <input type="hidden" name="type" value="{{ request()->is('vault/in') ? 'in' : 'out' }}">

                <div class="form-group mb-3">
                    <label>Amount</label>
                    <input type="number" name="amount" class="form-control" min="1" step="0.01" required>
                </div>

                <div class="form-group mb-3">
                    <label>Reason / Notes</label>
                    <textarea name="reason" class="form-control" rows="2"></textarea>
                </div>

                @php
                    $banks = getPreference('banks', []);
                    if (!is_array($banks)) {
                        $banks = [];
                    }
                @endphp

                @if(request()->is('vault/in') || request()->is('vault/out'))
                    <div class="form-group mb-3">
                        <label>Select Bank</label>
                        <select name="bank_name" class="form-control" required>
                            <option value="">-- Select Bank --</option>
                            @foreach ($banks as $bank)
                                <option value="{{ $bank }}">{{ $bank }}</option>
                            @endforeach
                        </select>
                    </div>
                @endif

                <button type="submit" class="btn btn-success">
                    {{ request()->is('vault/in') ? 'Deposit to Vault' : 'Withdraw from Vault' }}
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
