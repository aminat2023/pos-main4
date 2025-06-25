@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="card shadow-sm">
        <div class="card-header text-white" style="background-color: teal;">
            <h5 class="mb-0">📦 Incoming Stock Report</h5>
        </div>

        <div class="card-body">
            <form method="GET" action="{{ route('incoming_stock.report.print') }}" class="row" target="_blank">


                <div class="form-group col-md-12">
                    <label><strong>View Option:</strong></label><br>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="view_type" value="period" id="periodicOption" checked onchange="toggleViewFields()">
                        <label class="form-check-label" for="periodicOption">Periodic</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="view_type" value="monthly" id="monthlyOption" onchange="toggleViewFields()">
                        <label class="form-check-label" for="monthlyOption">Monthly</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="view_type" value="yearly" id="yearlyOption" onchange="toggleViewFields()">
                        <label class="form-check-label" for="yearlyOption">Yearly</label>
                    </div>
                </div>

                <!-- Periodic Fields -->
                <div class="form-group col-md-4" id="fromDateField">
                    <label for="from_date">From Date</label>
                    <input type="date" name="from_date" class="form-control" value="{{ request('from_date', now()->startOfMonth()->toDateString()) }}">
                </div>

                <div class="form-group col-md-4" id="toDateField">
                    <label for="to_date">To Date</label>
                    <input type="date" name="to_date" class="form-control" value="{{ request('to_date', now()->toDateString()) }}">
                </div>

                <!-- Monthly Field -->
                <div class="form-group col-md-4" id="monthField" style="display: none;">
                    <label for="month">Select Month</label>
                    <input type="month" name="month" class="form-control" value="{{ request('month') }}">
                </div>

                <!-- Yearly Field -->
                <div class="form-group col-md-4" id="yearField" style="display: none;">
                    <label for="year">Select Year</label>
                    <input type="number" name="year" class="form-control" min="2000" max="2100" value="{{ request('year', now()->year) }}">
                </div>

                <div class="form-group col-md-2 d-flex align-items-end">
                    <button type="submit" class="btn btn-dark w-100" style="background-color: teal;">
                        <i class="fa fa-chart-bar"></i> Generate
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- @if($stocks->count())
        <div class="text-center mt-4">
            <p class="text-muted">Report generated. Click the button below to print.</p>
            <a href="{{ route('incoming_stock.report.print', request()->all()) }}" target="_blank" class="btn btn-secondary">
                🖨️ Print Report
            </a>
        </div>
    @endif --}}
</div>

<script>
    function toggleViewFields() {
        const selected = document.querySelector('input[name="view_type"]:checked').value;
        document.getElementById('fromDateField').style.display = selected === 'period' ? 'block' : 'none';
        document.getElementById('toDateField').style.display = selected === 'period' ? 'block' : 'none';
        document.getElementById('monthField').style.display = selected === 'monthly' ? 'block' : 'none';
        document.getElementById('yearField').style.display = selected === 'yearly' ? 'block' : 'none';
    }
    document.addEventListener('DOMContentLoaded', toggleViewFields);
</script>

@endsection
