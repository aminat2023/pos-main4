@extends('layouts.app')

@section('content')
<div class="container d-flex justify-content-center mt-4">
    <div class="card shadow-sm w-100" style="max-width: 900px;">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <h6 class="mb-0">Create Journal Entry</h6>
            <button class="btn btn-sm btn-light" type="button" onclick="toggleForm()">Toggle Form</button>
        </div>
        

        <div class="card-body p-4 collapse show" id="journalFormContainer">           
            
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <form action="{{ route('journal.store') }}" method="POST">
                @csrf

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label>Reference</label>
                        <input type="text" class="form-control" value="{{ $reference }}" readonly>
                        <input type="hidden" name="reference" value="{{ $reference }}">
                    </div>

                    <div class="col-md-6">
                        <label>Account</label>
                        <select name="account" class="form-control @error('account') is-invalid @enderror" onchange="toggleBank()" required>
                            <option value="">-- Select --</option>
                            <option value="cash">Cash</option>
                            <option value="bank">Bank</option>
                        </select>
                        @error('account')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row mb-3" id="bank_name_div" style="display: none;">
                    <div class="col-md-12">
                        <label>Bank Name</label>
                        <select name="bank_name" class="form-control @error('bank_name') is-invalid @enderror">
                            <option value="">-- Select Bank --</option>
                            @foreach(json_decode(getPreference('banks', '[]'), true) as $bank)
                                <option value="{{ $bank }}">{{ $bank }}</option>
                            @endforeach
                        </select>
                        @error('bank_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label>Type</label>
                        <select name="type" class="form-control @error('type') is-invalid @enderror" required>
                            <option value="">-- Select Type --</option>
                            <option value="debit">Debit</option>
                            <option value="credit">Credit</option>
                        </select>
                        @error('type')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label>Amount</label>
                        <input type="number" name="amount" step="0.01" class="form-control @error('amount') is-invalid @enderror" required>
                        @error('amount')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="mb-3">
                    <label>Description</label>
                    <textarea name="description" class="form-control @error('description') is-invalid @enderror" rows="2" required></textarea>
                    @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label>Date</label>
                    <input type="date" name="date" class="form-control @error('date') is-invalid @enderror" required>
                    @error('date')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn btn-success w-100">Save Entry</button>
            </form>
        </div>
    </div>
</div>

<script>
   

    function toggleForm() {
        const formContainer = document.getElementById('journalFormContainer');
        formContainer.classList.toggle('show');
    }

    function toggleBank() {
        const account = document.querySelector('select[name="account"]').value;
        document.getElementById('bank_name_div').style.display = account === 'bank' ? 'block' : 'none';
    }
</script>
@endsection
