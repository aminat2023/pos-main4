@extends('layouts.app')

@section('content')
    <div class="container mt-5">
        <div class="card shadow-sm">
            <div class="card-header text-white" style="background-color: teal;">
                <h5 class="mb-0">Generate Sales Report</h5>
            </div>

            <div class="card-body">
                <form method="GET" action="{{ route('sales.report.print') }}" target="_blank" class="row">

                    <!-- Cashier Options -->
                    <div class="form-group col-md-12">
                        <label><strong>Select Cashier Option:</strong></label><br>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="cashier_option" id="allCashiers"
                                value="all" checked onchange="toggleCashierDropdown()">
                            <label class="form-check-label" for="allCashiers">All Cashiers</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="cashier_option" id="specificCashier"
                                value="specific" onchange="toggleCashierDropdown()">
                            <label class="form-check-label" for="specificCashier">Specific Cashier</label>
                        </div>
                    </div>

                    <div class="form-group col-md-4" id="cashierDropdown" style="display: none;">
                        <label for="cashier_id">Cashier</label>
                        <select name="cashier_id" class="form-control">
                            <option value="">-- Select Cashier --</option>
                            @foreach ($cashiers as $cashier)
                                <option value="{{ $cashier->id }}">{{ $cashier->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- View Options -->
                    <div class="form-group col-md-12 mt-3">
                        <label><strong>View Option:</strong></label><br>

                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="view_option" id="periodic"
                                value="periodic" onchange="toggleDateInputs()">
                            <label class="form-check-label" for="periodic">Periodically</label>
                        </div>

                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="view_option" id="monthly" value="monthly"
                                checked onchange="toggleDateInputs()">
                            <label class="form-check-label" for="monthly">Monthly</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="view_option" id="quarterly"
                                value="quarterly" onchange="toggleDateInputs()">
                            <label class="form-check-label" for="quarterly">Quarterly</label>
                        </div>

                    </div>

                    <!-- Monthly Option -->
                    <div class="form-group col-md-3" id="monthlyOption">
                        <label for="month">Select Month</label>
                        <input type="month" name="month" class="form-control">
                    </div>

                    <!-- Quarterly Option -->
                    <div class="form-group col-md-3" id="quarterlyOption" style="display: none;">
                        <label for="quarter">Select Quarter</label>
                        <select name="quarter" class="form-control">
                            <option value="">-- Choose Quarter --</option>
                            <option value="Q1">Q1 (Jan - Mar)</option>
                            <option value="Q2">Q2 (Apr - Jun)</option>
                            <option value="Q3">Q3 (Jul - Sep)</option>
                            <option value="Q4">Q4 (Oct - Dec)</option>
                        </select>
                    </div>

                    <!-- Periodic Option -->
                    <div class="form-group col-md-3" id="fromDateOption" style="display: none;">
                        <label for="from_date">From Date</label>
                        <input type="date" name="from_date" class="form-control">
                    </div>

                    <div class="form-group col-md-3" id="toDateOption" style="display: none;">
                        <label for="to_date">To Date</label>
                        <input type="date" name="to_date" class="form-control">
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

    <script>
        function toggleCashierDropdown() {
            const specificChecked = document.getElementById('specificCashier').checked;
            document.getElementById('cashierDropdown').style.display = specificChecked ? 'block' : 'none';
        }

        function toggleDateInputs() {
            const viewOption = document.querySelector('input[name="view_option"]:checked').value;

            document.getElementById('monthlyOption').style.display = (viewOption === 'monthly') ? 'block' : 'none';
            document.getElementById('quarterlyOption').style.display = (viewOption === 'quarterly') ? 'block' : 'none';
            document.getElementById('fromDateOption').style.display = (viewOption === 'periodic') ? 'block' : 'none';
            document.getElementById('toDateOption').style.display = (viewOption === 'periodic') ? 'block' : 'none';
        }

        // Trigger on load
        document.addEventListener('DOMContentLoaded', function() {
            toggleCashierDropdown();
            toggleDateInputs();
        });
    </script>
@endsection
