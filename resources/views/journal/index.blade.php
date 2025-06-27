@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Create Journal Entry</h5>
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" id="toggleDouble" onchange="toggleDoubleForm()" {{ old('is_double_leg') ? 'checked' : '' }}>
                        <label class="form-check-label" for="toggleDouble">Double Entry</label>
                    </div>
                </div>

                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <form action="{{ route('journal.store') }}" method="POST" autocomplete="off">
                        @csrf
                        <input type="hidden" name="reference" value="{{ $reference }}">
                        <input type="hidden" name="is_double_leg" id="isDoubleLeg" value="{{ old('is_double_leg', 0) }}">

                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label class="form-label">Reference</label>
                                <input type="text" class="form-control" value="{{ $reference }}" readonly>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Date <span class="text-danger">*</span></label>
                                <input type="date" name="date" class="form-control" value="{{ old('date', date('Y-m-d')) }}" required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Amount <span class="text-danger">*</span></label>
                                <input type="number" name="amount" class="form-control" step="0.01" min="0.01" value="{{ old('amount') }}" required>
                            </div>
                        </div>

                        <!-- SINGLE ENTRY SECTION -->
                        <div id="singleLegSection">
                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <label class="form-label">Account <span class="text-danger">*</span></label>
                                    <select name="account" class="form-select" onchange="toggleBankDropdown(this, 'bankSelectSingle')" required>
                                        <option value="">-- Select --</option>
                                        <option value="cash"{{ old('account') == 'cash' ? ' selected' : '' }}>Cash</option>
                                        <option value="bank"{{ old('account') == 'bank' ? ' selected' : '' }}>Bank</option>
                                    </select>
                                </div>
                                <div class="col-md-4" id="bankSelectSingle" style="display: none;">
                                    <label class="form-label">Bank Name</label>
                                    <select name="bank_name" class="form-select">
                                        <option value="">-- Select Bank --</option>
                                        @foreach($banks as $bank)
                                            <option value="{{ $bank }}" {{ old('bank_name') == $bank ? 'selected' : '' }}>{{ $bank }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Type <span class="text-danger">*</span></label>
                                    <select name="type" class="form-select" required>
                                        <option value="">-- Select --</option>
                                        <option value="debit"{{ old('type') == 'debit' ? ' selected' : '' }}>Debit</option>
                                        <option value="credit"{{ old('type') == 'credit' ? ' selected' : '' }}>Credit</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- DOUBLE ENTRY SECTION -->
                        <div id="doubleLegSection" style="display: none;">
                            <h6 class="text-muted mb-3">First Entry</h6>
                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <label class="form-label">Account</label>
                                    <select name="entry1_account" class="form-select" onchange="toggleBankDropdown(this, 'bank1')" required>
                                        <option value="">-- Select --</option>
                                        <option value="cash"{{ old('entry1_account') == 'cash' ? ' selected' : '' }}>Cash</option>
                                        <option value="bank"{{ old('entry1_account') == 'bank' ? ' selected' : '' }}>Bank</option>
                                    </select>
                                </div>
                                <div class="col-md-4" id="bank1" style="display: none;">
                                    <label class="form-label">Bank Name</label>
                                    <select name="bank_name_entry1" class="form-select">
                                        <option value="">-- Select Bank --</option>
                                        @foreach($banks as $bank)
                                            <option value="{{ $bank }}" {{ old('bank_name_entry1') == $bank ? 'selected' : '' }}>{{ $bank }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Type</label>
                                    <select name="entry1_type" class="form-select" required>
                                        <option value="">-- Select --</option>
                                        <option value="debit"{{ old('entry1_type') == 'debit' ? ' selected' : '' }}>Debit</option>
                                        <option value="credit"{{ old('entry1_type') == 'credit' ? ' selected' : '' }}>Credit</option>
                                    </select>
                                </div>
                            </div>

                            <h6 class="text-muted mb-3">Second Entry</h6>
                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <label class="form-label">Account</label>
                                    <select name="entry2_account" class="form-select" onchange="toggleBankDropdown(this, 'bank2')" required>
                                        <option value="">-- Select --</option>
                                        <option value="cash"{{ old('entry2_account') == 'cash' ? ' selected' : '' }}>Cash</option>
                                        <option value="bank"{{ old('entry2_account') == 'bank' ? ' selected' : '' }}>Bank</option>
                                    </select>
                                </div>
                                <div class="col-md-4" id="bank2" style="display: none;">
                                    <label class="form-label">Bank Name</label>
                                    <select name="bank_name_entry2" class="form-select">
                                        <option value="">-- Select Bank --</option>
                                        @foreach($banks as $bank)
                                            <option value="{{ $bank }}" {{ old('bank_name_entry2') == $bank ? 'selected' : '' }}>{{ $bank }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Type</label>
                                    <select name="entry2_type" class="form-select" required>
                                        <option value="">-- Select --</option>
                                        <option value="debit"{{ old('entry2_type') == 'debit' ? ' selected' : '' }}>Debit</option>
                                        <option value="credit"{{ old('entry2_type') == 'credit' ? ' selected' : '' }}>Credit</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Description <span class="text-danger">*</span></label>
                            <input type="text" name="description" class="form-control" value="{{ old('description') }}" required>
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-success btn-lg">Save Entry</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- JS -->
<script>
    function toggleDoubleForm() {
        const isChecked = document.getElementById('toggleDouble').checked;
        document.getElementById('isDoubleLeg').value = isChecked ? 1 : 0;
        document.getElementById('singleLegSection').style.display = isChecked ? 'none' : 'block';
        document.getElementById('doubleLegSection').style.display = isChecked ? 'block' : 'none';

        // Dynamically update required attributes
        document.querySelectorAll('#singleLegSection select, #singleLegSection input').forEach(el => {
            el.required = !isChecked;
        });
        document.querySelectorAll('#doubleLegSection select, #doubleLegSection input').forEach(el => {
            el.required = isChecked;
        });
    }

    function toggleBankDropdown(selectElem, targetId) {
        const show = selectElem.value === 'bank';
        document.getElementById(targetId).style.display = show ? 'block' : 'none';
    }

    document.addEventListener('DOMContentLoaded', () => {
        toggleDoubleForm(); // Apply correct visibility on load

        // Pre-show any dropdowns for old input
        const accountFields = ['account', 'entry1_account', 'entry2_account'];
        accountFields.forEach(field => {
            const el = document.querySelector(`[name="${field}"]`);
            if (el) toggleBankDropdown(el, 'bank' + (field.includes('entry1') ? '1' : field.includes('entry2') ? '2' : 'SelectSingle'));
        });
    });
</script>
@endsection
