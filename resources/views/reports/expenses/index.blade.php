@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="card shadow-sm">
        <div class="card-header text-white" style="background-color: teal;">
            <h5 class="mb-0">Generate Expense Report</h5>
        </div>

        <div class="card-body">
            <form method="GET" action="{{ route('expense.report.print') }}" target="_blank" class="row">
                
                <!-- Expense Filter -->
                <div class="form-group col-md-12">
                    <label>Expense Type</label><br>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="expense_type" id="all_expenses" value="all" checked>
                        <label class="form-check-label" for="all_expenses">All Expenses</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="expense_type" id="specific_expense" value="specific">
                        <label class="form-check-label" for="specific_expense">Specific Category</label>
                    </div>
                </div>

                <!-- Dropdown for Category -->
                <div class="form-group col-md-4" id="category_dropdown" style="display: none;">
                    <label for="category">Expense Category</label>
                    <select name="category" class="form-control">
                        <option value="">-- Select Category --</option>
                        @foreach($categories as $category)
                            <option value="{{ $category }}">{{ $category }}</option>
                        @endforeach
                    </select>
                </div>
                <!-- Date Range -->
                <div class="form-group col-md-3">
                    <label for="from_date">From Date</label>
                    <input type="date" name="from_date" class="form-control" required>
                </div>
                <div class="form-group col-md-3">
                    <label for="to_date">To Date</label>
                    <input type="date" name="to_date" class="form-control" required>
                </div>

                <!-- View Options -->
                <div class="form-group col-md-2">
                    <label for="view_option">View By</label>
                    <select name="view_option" class="form-control">
                        <option value="period">Periodic</option>
                        <option value="monthly">Monthly</option>
                        <option value="quarterly">Quarterly</option>
                    </select>
                </div>

                <!-- Submit Button -->
                <div class="form-group col-md-2 d-flex align-items-end">
                    <button type="submit" class="btn btn-dark w-100" style="background-color: teal;">
                        <i class="fa fa-print"></i> Generate
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Optional: Show/Hide Category Dropdown with JS -->

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const specificRadio = document.getElementById('specific_expense');
        const allRadio = document.getElementById('all_expenses');
        const dropdown = document.getElementById('category_dropdown');

        function toggleDropdown() {
            dropdown.style.display = specificRadio.checked ? 'block' : 'none';
        }

        specificRadio.addEventListener('change', toggleDropdown);
        allRadio.addEventListener('change', toggleDropdown);
    });
</script>

@endsection
