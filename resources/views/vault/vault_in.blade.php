@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header bg-dark text-white">
            <h5>Vault Deposit (From Bank to Vault)</h5>
        </div>
        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <form action="{{ route('vault.store') }}" method="POST">
                @csrf
                <input type="hidden" name="type" value="in">

                <div class="form-group">
                    <label>Amount</label>
                    <input type="number" name="amount" class="form-control" required>
                </div>

                <div class="form-group">
                    <label>Select Bank</label>
                    @php
                    $banks = json_decode(getPreference('banks', '[]'), true);
                    if (!is_array($banks)) {
                        $banks = []; // Ensure $banks is an array
                    }
                @endphp
                
                <select name="bank_name" class="form-control" required>
                    <option value="">-- Select Bank --</option>
                    @foreach($banks as $bank)
                        <option value="{{ $bank }}">{{ $bank }}</option>
                    @endforeach
                </select>
                </div>

                <div class="form-group">
                    <label>Reason / Notes</label>
                    <textarea name="reason" class="form-control" rows="2"></textarea>
                </div>

                <button type="submit" class="btn btn-success">Deposit to Vault</button>
            </form>
        </div>
    </div>
</div>
@endsection
