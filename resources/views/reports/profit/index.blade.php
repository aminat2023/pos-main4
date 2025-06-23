@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card mt-4 shadow-sm">
        <div class="card-header bg-dark text-white">
            <h5>📈 Profit Report</h5>
        </div>
        <div class="card-body">

            <form method="GET" action="{{ route('profit.report.print') }}" target="_blank" class="row">

                <div class="col-md-4">
                    <label>View Option</label>
                    <select name="view_option" class="form-control" onchange="toggleFilters(this.value)">
                        <option value="">Select View</option>
                        <option value="period" {{ request('view_option') == 'period' ? 'selected' : '' }}>Periodically</option>
                        <option value="monthly" {{ request('view_option') == 'monthly' ? 'selected' : '' }}>Monthly</option>
                        <option value="yearly" {{ request('view_option') == 'yearly' ? 'selected' : '' }}>Yearly</option>
                    </select>
                </div>

                <div class="col-md-3 d-none" id="date-range">
                    <label>From</label>
                    <input type="date" name="from_date" class="form-control" value="{{ request('from_date') }}">
                </div>

                <div class="col-md-3 d-none" id="to-range">
                    <label>To</label>
                    <input type="date" name="to_date" class="form-control" value="{{ request('to_date') }}">
                </div>

                <div class="col-md-2 d-flex align-items-end">
                    <button class="btn btn-primary w-100"><i class="fa fa-sync"></i> Generate</button>
                </div>
            </form>

            @if(!empty($profits))
                <div id="profitTableSection">
                    <table class="table table-bordered table-striped">
                        <thead class="thead-dark">
                            <tr>
                                <th>Date</th>
                                <th>Product</th>
                                <th>Cashier</th>
                                <th>Quantity</th>
                                <th>Profit (₦)</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($profits as $profit)
                                <tr>
                                    <td>{{ $profit['date'] }}</td>
                                    <td>{{ $profit['product'] }}</td>
                                    <td>{{ $profit['cashier'] }}</td>
                                    <td>{{ $profit['quantity'] }}</td>
                                    <td>{{ number_format($profit['profit'], 2) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th colspan="4" class="text-end">Total Profit</th>
                                <th>₦{{ number_format($totalProfit, 2) }}</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            @endif

        </div>
    </div>
</div>

<script>
    function toggleFilters(option) {
        const fromDate = document.getElementById('date-range');
        const toDate = document.getElementById('to-range');

        if (option === 'period') {
            fromDate.classList.remove('d-none');
            toDate.classList.remove('d-none');
        } else {
            fromDate.classList.add('d-none');
            toDate.classList.add('d-none');
        }
    }

    // Keep filters visible if already selected
    document.addEventListener('DOMContentLoaded', function () {
        toggleFilters("{{ request('view_option') }}");
    });
</script>
@endsection
