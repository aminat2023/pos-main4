@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <!-- Sidebar Preferences Form -->
        <div class="col-md-3">
            <button id="toggleSidebar" class="btn btn-secondary mb-3">Toggle Preferences</button>

            <div id="preferencesSidebar" class="bg-light p-3 border rounded">
                <form id="preferencesForm" action="{{ route('preferences.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="form-group">
                        <label>Business Name</label>
                        <input type="text" name="business_name" id="business_name" value="{{ $preferences['business_name'] ?? '' }}" class="form-control" oninput="updatePreview()">
                    </div>

                    <div class="form-group">
                        <label>Business Logo</label>
                        <input type="file" name="business_logo" class="form-control" onchange="previewLogo(event)">
                    </div>

                    <div class="form-group">
                        <label>Office Address</label>
                        <input type="text" name="office_address" id="office_address" value="{{ $preferences['office_address'] ?? '' }}" class="form-control" oninput="updatePreview()">
                    </div>

                    <div class="form-group">
                        <label>Currency Symbol</label>
                        <input type="text" name="currency_symbol" id="currency_symbol" value="{{ $preferences['currency_symbol'] ?? '₦' }}" class="form-control" oninput="updatePreview()">
                    </div>

                    <div class="form-group">
                        <label>Receipt Header</label>
                        <input type="text" name="receipt_header" id="receipt_header" value="{{ $preferences['receipt_header'] ?? '' }}" class="form-control" oninput="updatePreview()">
                    </div>

                    <div class="form-group">
                        <label>Receipt Footer</label>
                        <input type="text" name="receipt_footer" id="receipt_footer" value="{{ $preferences['receipt_footer'] ?? '' }}" class="form-control" oninput="updatePreview()">
                    </div>

                    <div class="form-group">
                        <label>Dark Mode</label>
                        <select name="dark_mode" id="dark_mode" class="form-control" onchange="toggleDarkMode()">
                            <option value="0" {{ $preferences['dark_mode'] == '0' ? 'selected' : '' }}>Light</option>
                            <option value="1" {{ $preferences['dark_mode'] == '1' ? 'selected' : '' }}>Dark</option>
                        </select>
                    </div>

                    <button type="submit" class="btn btn-primary mt-3">Save Preferences</button>
                </form>
            </div>
        </div>

        <!-- Receipt Live Preview -->
        <div class="col-md-9">
            <h5>Live Receipt Preview</h5>
            <div id="invoice_pos">
                <div id="top">
                    <div class="logo" id="logoCircle">PM</div>
                    <h2 id="previewBusinessName">{{ $preferences['business_name'] ?? 'Business Name' }}</h2>
                    <p id="previewOfficeAddress">{{ $preferences['office_address'] ?? 'Business Address' }}</p>
                </div>

                <div id="legalcopy">
                    <p>
                        <strong id="previewReceiptHeader">{{ $preferences['receipt_header'] ?? 'Thanks for your purchase!' }}</strong><br>
                        <span id="previewReceiptFooter">{{ $preferences['receipt_footer'] ?? 'Come again!' }}</span>
                    </p>
                </div>

                <div class="serial-number">
                    Serial: <span class="serial">000001</span>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection


<script>
    function updatePreview() {
        document.getElementById('previewBusinessName').textContent = document.getElementById('business_name').value || 'Business Name';
        document.getElementById('previewCurrency').textContent = document.getElementById('currency_symbol').value || '₦';
        document.getElementById('previewReceiptHeader').textContent = document.getElementById('receipt_header').value || '';
        document.getElementById('previewReceiptFooter').textContent = document.getElementById('receipt_footer').value || '';
        document.getElementById('previewOfficeAddress').textContent = document.getElementById('office_address').value || 'No Address';
    }

    function previewLogo(event) {
        const reader = new FileReader();
        reader.onload = function () {
            const logo = document.getElementById('logoCircle');
            logo.style.backgroundImage = `url(${reader.result})`;
            logo.style.backgroundSize = 'cover';
            logo.textContent = '';
        };
        reader.readAsDataURL(event.target.files[0]);
    }

    function toggleDarkMode() {
        const isDark = document.getElementById('dark_mode').value === "1";
        document.body.classList.toggle('bg-dark', isDark);
        document.body.classList.toggle('text-white', isDark);
        document.getElementById('invoice_pos').classList.toggle('bg-dark', isDark);
        document.getElementById('invoice_pos').classList.toggle('text-white', isDark);
    }

    document.addEventListener('DOMContentLoaded', () => {
        document.getElementById('toggleSidebar').addEventListener('click', () => {
            document.getElementById('preferencesSidebar').classList.toggle('d-none');
        });

        toggleDarkMode();
    });
</script>


<style>
    .d-none { display: none; }

    @import url("https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap");

    body {
        font-family: "Roboto", sans-serif;
        background: #f4f4f4;
    }

    #invoice_pos {
        width: 58mm;
        background: #fff;
        padding: 12px;
        border-radius: 8px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
        margin: auto;
    }

    #top {
        text-align: center;
        margin-bottom: 10px;
    }

    .logo {
        font-weight: bold;
        font-size: 24px;
        color: #fff;
        background-color: #007bff;
        width: 50px;
        height: 50px;
        margin: 0 auto 5px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
    }

    h2 {
        margin: 4px 0;
        font-size: 14px;
        color: #222;
    }

    p {
        font-size: 10px;
        margin: 2px 0;
    }

    #legalcopy {
        text-align: center;
        margin-top: 10px;
        font-size: 10px;
        color: #666;
    }

    .serial-number {
        text-align: center;
        font-size: 9px;
        margin-top: 5px;
        color: #888;
    }

    .serial {
        font-weight: bold;
    }
</style>

