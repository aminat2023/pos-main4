<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Profit Report</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 13px;
            color: #000;
            background-color: #444;
            margin: 0;
            padding: 20px;
        }

        .container {
            max-width: 700px;
            margin: 0 auto;
            background: #fff;
            padding: 20px 30px;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        h2,
        h5 {
            text-align: center;
            margin: 5px 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        .summary {
            margin-top: 20px;
            text-align: right;
            font-weight: bold;
        }

        .btn-group {
            text-align: center;
            margin-bottom: 15px;
        }

        .btn {
            display: inline-block;
            padding: 8px 14px;
            margin: 0 5px;
            font-size: 14px;
            font-weight: 600;
            text-decoration: none;
            color: #fff;
            border-radius: 4px;
            cursor: pointer;
            user-select: none;
            transition: background-color 0.3s ease;
        }

        .btn-pdf {
            background-color: #d9534f;
            /* Bootstrap danger red */
        }

        .btn-pdf:hover {
            background-color: #c9302c;
        }

        .btn-excel {
            background-color: #5cb85c;
            /* Bootstrap success green */
        }

        .btn-excel:hover {
            background-color: #4cae4c;
        }

        .btn-print {
            background-color: #343a40;
            /* Bootstrap dark */
            color: #fff;
        }

        .btn-print:hover {
            background-color: #23272b;
        }

        @media print {

            .no-print,
            .btn-group {
                display: none;
            }

            body {
                background: #fff;
                padding: 0;
            }

            .container {
                box-shadow: none;
                border-radius: 0;
            }
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

        <!-- Export Buttons -->
        <div class="btn-group no-print">
            <a href="{{ route('profit.exportPdf', ['from_date' => $from_date, 'to_date' => $to_date, 'cashier_id' => $cashier->id ?? null]) }}"
                class="btn btn-pdf" target="_blank">
                Export PDF
            </a>
            <a href="{{ route('profit.exportExcel', ['from_date' => $from_date, 'to_date' => $to_date, 'cashier_id' => $cashier->id ?? null]) }}"
                class="btn btn-excel">
                Export Excel
            </a>
            <a href="javascript:void(0);" onclick="window.print()" class="btn btn-print">
                🖨️ Print
            </a>
        </div>
        
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
                @foreach ($profits as $index => $profit)
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
