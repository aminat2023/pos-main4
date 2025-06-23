<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Profit Report</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 13px; color: #000; }
        .container { width: 80%; margin: auto; }
        h2, h5 { text-align: center; margin: 5px 0; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #000; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        .summary { margin-top: 20px; text-align: right; font-weight: bold; }
        @media print {
            .no-print { display: none; }
        }
    </style>
</head>
<body>
    <div class="container">

        <h2>{{ getPreference('business_name', 'My Business') }}</h2>
        <h5>Profit Report</h5>

        <h5>
            {{ $from_date }} to {{ $to_date }}<br>
            @if ($cashier)
                Cashier: {{ $cashier->name }}
            @else
                All Cashiers
            @endif
        </h5>

        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Date</th>
                    <th>Product</th>
                    <th>Cashier</th>
                    <th>Qty</th>
                    <th>Profit (₦)</th>
                </tr>
            </thead>
            <tbody>
                @php $total = 0; @endphp
                @foreach($profits as $index => $profit)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $profit['date'] }}</td>
                        <td>{{ $profit['product'] }}</td>
                        <td>{{ $profit['cashier'] }}</td>
                        <td>{{ $profit['quantity'] }}</td>
                        <td>{{ number_format($profit['profit'], 2) }}</td>
                    </tr>
                    @php $total += $profit['profit']; @endphp
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <th colspan="5" style="text-align:right">TOTAL</th>
                    <th>₦{{ number_format($total, 2) }}</th>
                </tr>
            </tfoot>
        </table>

        <div class="summary">
            Printed by: {{ auth()->user()->name ?? 'System' }}<br>
            Printed on: {{ now()->format('Y-m-d H:i:s') }}
        </div>

        <div class="no-print" style="text-align: center; margin-top: 20px;">
            <button onclick="window.print()">🖨️ Print</button>
        </div>

    </div>
</body>
</html>
