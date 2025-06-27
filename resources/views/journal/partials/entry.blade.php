@php
    $idSuffix = $prefix ?: 'single';
    $accountField = $prefix . 'account';
    $typeField = $prefix . 'type';
    $bankField = $prefix . 'bank_name';
    $bankDivId = 'bank_' . $idSuffix;
@endphp

<div class="row mb-3">
    <div class="col-md-4">
        <label class="form-label">Account <span class="text-danger">*</span></label>
        <select name="{{ $accountField }}" class="form-select" onchange="toggleBankDropdown(this, '{{ $bankDivId }}')" required>
            <option value="">-- Select --</option>
            <option value="cash" {{ $oldAccount == 'cash' ? 'selected' : '' }}>Cash</option>
            <option value="bank" {{ $oldAccount == 'bank' ? 'selected' : '' }}>Bank</option>
        </select>
    </div>
    <div class="col-md-4" id="{{ $bankDivId }}" style="display: {{ $oldAccount === 'bank' ? 'block' : 'none' }}">
        <label class="form-label">Bank Name</label>
        <select name="{{ $bankField }}" class="form-select">
            <option value="">-- Select Bank --</option>
            @foreach($banks as $bank)
                <option value="{{ $bank }}" {{ $oldBank == $bank ? 'selected' : '' }}>{{ $bank }}</option>
            @endforeach
        </select>
    </div>
    <div class="col-md-4">
        <label class="form-label">Type <span class="text-danger">*</span></label>
        <select name="{{ $typeField }}" class="form-select" required>
            <option value="">-- Select --</option>
            <option value="debit" {{ $oldType == 'debit' ? 'selected' : '' }}>Debit</option>
            <option value="credit" {{ $oldType == 'credit' ? 'selected' : '' }}>Credit</option>
        </select>
    </div>
</div>
