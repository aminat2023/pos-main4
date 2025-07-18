@extends('layouts.app')

@section('content')
<style>
    .btn-check:checked + .btn-outline-teal {
        background-color: teal;
        color: white;
        border-color: teal;
    }

  

</style>

<div class="container mt-4">
    <div class="card shadow rounded">
        <div class="card-header text-white" style="background-color: teal;">
            <h5 class="mb-0"><i class="fa-solid fa-money-bill"></i> Vault Transaction Report</h5>
        </div>

        <div class="card-body bg-white">
            <form method="GET" action="{{ route('vault.report.table') }}" id="filterForm">
                <div class="mb-3">
                    <label class="form-label d-block">📊 Choose Filter</label>
                    <div class="btn-group" role="group" aria-label="Filter options">
                        <input type="radio" class="btn-check" name="filter_type" id="date" value="date" required>
                        <label class="btn btn-outline-teal" for="date">By Date Range</label>

                        <input type="radio" class="btn-check" name="filter_type" id="month" value="month">
                        <label class="btn btn-outline-teal" for="month">By Month</label>

                        <input type="radio" class="btn-check" name="filter_type" id="year" value="year">
                        <label class="btn btn-outline-teal" for="year">By Year</label>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4 filter-date d-none">
                        <label class="form-label">From Date</label>
                        <input type="date" name="from_date" class="form-control rounded-pill" onchange="submitForm()">
                    </div>

                    <div class="col-md-4 filter-date d-none">
                        <label class="form-label">To Date</label>
                        <input type="date" name="to_date" class="form-control rounded-pill" onchange="submitForm()">
                    </div>

                    <div class="col-md-4 filter-month d-none mt-3">
                        <label class="form-label">Select Month</label>
                        <input type="month" name="month" class="form-control rounded-pill" onchange="submitForm()">
                    </div>

                    <div class="col-md-4 filter-year d-none mt-3">
                        <label class="form-label">Year</label>
                        <input type="number" name="year" class="form-control rounded-pill" placeholder="e.g., 2025" onchange="submitForm()">
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    const dateFields = document.querySelectorAll('.filter-date');
    const monthField = document.querySelector('.filter-month');
    const yearField = document.querySelector('.filter-year');
    const filterForm = document.getElementById('filterForm');

    document.querySelectorAll('input[name="filter_type"]').forEach(radio => {
        radio.addEventListener('change', () => {
            dateFields.forEach(el => el.classList.add('d-none'));
            monthField.classList.add('d-none');
            yearField.classList.add('d-none');

            if (radio.value === 'date') {
                dateFields.forEach(el => el.classList.remove('d-none'));
            } else if (radio.value === 'month') {
                monthField.classList.remove('d-none');
            } else if (radio.value === 'year') {
                yearField.classList.remove('d-none');
            }
        });
    });

    function submitForm() {
        filterForm.submit();
    }
</script>
@endsection
