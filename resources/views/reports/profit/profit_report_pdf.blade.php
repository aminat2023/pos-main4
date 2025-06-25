<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Profit Report</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; }
        h2, h4 { text-align: center; margin: 4px 0; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #000; padding: 6px; text-align: left; }
        th { background-color: #f2f2f2; }
        .summary { margin-top: 10px; text-align: right; font-weight: bold; }
    </style>
</head>
<body>

    <h2>{{ getPreference('business_name', 'My Business') }}</h2>
    <h4>Profit Report</h4>
    <p style="text-align: center;">From {{ $from_date }} to {{ $to_date }}</p>

    @if(isset($cashier))
        <p><strong>Cashier:</strong> {{ $cashier->name }}</p>
    @endif

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
                <th colspan="5" style="text-align:right">Total</th>
                <th>₦{{ number_format($total, 2) }}</th>
            </tr>
        </tfoot>
    </table>

    <div class="summary">
        Printed on: {{ now()->format('Y-m-d H:i:s') }}
    </div>

</body>
</html>
