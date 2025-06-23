@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="card shadow-sm">
        <div class="card-header text-white" style="background-color: teal;">
            <h5 class="mb-0">Generate Profit & Loss Report</h5>
        </div>

        <div class="card-body">
            <form method="GET" action="{{ route('profit_loss.print') }}" target="_blank" class="row">

                <!-- View Option Radio Buttons -->
                <div class="form-group col-md-12">
                    <label><strong>View Option:</strong></label><br>

                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="view_option" value="periodic" id="periodicOption" checked onchange="toggleDateFields()">
                        <label class="form-check-label" for="periodicOption">Periodic</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="view_option" value="monthly" id="monthlyOption" onchange="toggleDateFields()">
                        <label class="form-check-label" for="monthlyOption">Monthly</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="view_option" value="yearly" id="yearlyOption" onchange="toggleDateFields()">
                        <label class="form-check-label" for="yearlyOption">Yearly</label>
                    </div>
                </div>

                <!-- Periodic Date Range -->
                <div class="form-group col-md-4" id="fromDateField">
                    <label for="from_date">From Date</label>
                    <input type="date" name="from_date" class="form-control" value="{{ now()->startOfMonth()->toDateString() }}">
                </div>

                <div class="form-group col-md-4" id="toDateField">
                    <label for="to_date">To Date</label>
                    <input type="date" name="to_date" class="form-control" value="{{ now()->toDateString() }}">
                </div>

                <!-- Monthly Option -->
                <div class="form-group col-md-4" id="monthField" style="display: none;">
                    <label for="month">Select Month</label>
                    <input type="month" name="month" class="form-control">
                </div>

                <!-- Yearly Option -->
                <div class="form-group col-md-4" id="yearField" style="display: none;">
                    <label for="year">Select Year</label>
                    <input type="number" name="year" class="form-control" min="2000" max="2100" value="{{ now()->year }}">
                </div>

                <div class="form-group col-md-2 d-flex align-items-end">
                    <button type="submit" class="btn btn-dark w-100" style="background-color: teal;">
                        <i class="fa fa-print"></i> Generate
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function toggleDateFields() {
        const option = document.querySelector('input[name="view_option"]:checked').value;

        document.getElementById('fromDateField').style.display = option === 'periodic' ? 'block' : 'none';
        document.getElementById('toDateField').style.display = option === 'periodic' ? 'block' : 'none';
        document.getElementById('monthField').style.display = option === 'monthly' ? 'block' : 'none';
        document.getElementById('yearField').style.display = option === 'yearly' ? 'block' : 'none';
    }

    document.addEventListener('DOMContentLoaded', toggleDateFields);
</script>
@endsection
