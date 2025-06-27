@php
    $banks = is_array($preferences['banks']) ? $preferences['banks'] : [];
@endphp

@extends('layouts.app')
@section('content')

<div class="container">
    <form action="{{ route('preferences.update') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="form-group">
            <label>Business Name</label>
            <input type="text" name="business_name" class="form-control" value="{{ $preferences['business_name'] }}">
        </div>

        <div class="form-group">
            <label>Business Logo</label>
            <input type="file" name="business_logo" class="form-control">
            @if (!empty($preferences['business_logo']))
                <img src="{{ asset('storage/' . $preferences['business_logo']) }}" alt="Logo" style="max-height: 60px; margin-top: 10px;">
            @endif
        </div>

        <div class="form-group">
            <label>Office Address</label>
            <input type="text" name="office_address" class="form-control" value="{{ $preferences['office_address'] ?? '' }}">
        </div>

        <div class="form-group">
            <label>Currency Symbol</label>
            <input type="text" name="currency_symbol" class="form-control" value="{{ $preferences['currency_symbol'] }}">
        </div>

        <div class="form-group">
            <label>Receipt Header</label>
            <input type="text" name="receipt_header" class="form-control" value="{{ $preferences['receipt_header'] ?? '' }}">
        </div>

        <div class="form-group">
            <label>Receipt Footer</label>
            <input type="text" name="receipt_footer" class="form-control" value="{{ $preferences['receipt_footer'] ?? '' }}">
        </div>

        <div class="form-group">
            <label>Default Language</label>
            <select name="default_language" class="form-control">
                <option value="English" {{ $preferences['default_language'] == 'English' ? 'selected' : '' }}>English</option>
                <option value="French" {{ $preferences['default_language'] == 'French' ? 'selected' : '' }}>French</option>
                <option value="Spanish" {{ $preferences['default_language'] == 'Spanish' ? 'selected' : '' }}>Spanish</option>
            </select>
        </div>

        <div class="form-group">
            <label>Dark Mode</label>
            <select name="dark_mode" class="form-control">
                <option value="0" {{ ($preferences['dark_mode'] ?? '0') == '0' ? 'selected' : '' }}>Light</option>
                <option value="1" {{ ($preferences['dark_mode'] ?? '0') == '1' ? 'selected' : '' }}>Dark</option>
            </select>
        </div>

        <div class="form-group">
            <label>Banks</label>
            <div id="banksContainer">
                @foreach ($banks as $bank)
                    <input type="text" name="banks[]" value="{{ $bank }}" class="form-control mb-2">
                @endforeach
                <input type="text" name="banks[]" class="form-control mb-2" placeholder="Add new bank">
            </div>
            <button type="button" class="btn btn-sm btn-secondary mt-2" onclick="addBankInput()">Add Another Bank</button>
        </div>

        <button type="submit" class="btn btn-primary">Save Preferences</button>
    </form>
</div>

<script>
    function addBankInput() {
        const container = document.getElementById('banksContainer');
        const input = document.createElement('input');
        input.type = 'text';
        input.name = 'banks[]';
        input.classList.add('form-control', 'mb-2');
        input.placeholder = 'Add new bank';
        container.appendChild(input);
    }
</script>
@endsection
