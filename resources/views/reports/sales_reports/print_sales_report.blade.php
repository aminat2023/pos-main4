<!DOCTYPE html>
<html>

<head>
    <title>Sales Report</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 20px;
            background-color: #444;
        }

        .report-wrapper {
            background-color: #ffffff;
            width: 60%;
            max-width: 1000px;
            margin: auto;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 5px rgb(7, 6, 6);
        }

        .btn-group {
            margin: 15px auto;
            text-align: center;
        }

        .btn-group a,
        .btn-group button {
            padding: 8px 18px;
            margin: 5px;
            background-color: #333;
            color: white;
            text-decoration: none;
            border: none;
            cursor: pointer;
            font-size: 14px;
            border-radius: 4px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 25px;
            font-size: 10px;
        }

        th,
        td {
            border: 1px solid #555;
            padding: 0.5px;
            text-align: left;
        }

        h1 {
            text-align: center;
            margin: 0;
        }

        h2,
        h5 {
            text-align: center;
            margin: 5px 0;
        }

        @media print {
            .btn-group {
                display: none;
            }

            body {
                background: white;
                margin: 0;
            }

            .report-wrapper {
                box-shadow: none;
                border: none;
                padding: 0;
            }
        }

        .zoom-controls {
            text-align: center;
            margin: 10px 0;
        }

        .zoom-controls button {
            background-color: #333;
            color: white;
            border: none;
            padding: 13px;
            margin: 0 5px;
            font-size: 10px;
            border-radius: 4px;
            cursor: pointer;
        }

        .zoomable {
            transition: transform 0.2s ease-in-out;
            transform-origin: top center;
        }
    </style>
</head>

<body>
    <div class="zoom-controls">
        <button onclick="zoomOut()">➖ Zoom Out</button>
        <button onclick="zoomIn()">➕ Zoom In</button>
        <button onclick="resetZoom()">🔄 Reset</button>
    </div>

    <div class="report-wrapper zoomable" id="reportArea">

        <!-- Business Name -->
        <h1>{{ getPreference('business_name', 'My Business') }}</h1>
        <h5>Sales Report</h5>

        <!-- Report Info -->
        <h5>
            {{ $request->from_date }} to {{ $request->to_date }}<br>
            @if ($cashier)
                Cashier: {{ $cashier->name }}
            @else
                All Cashiers
            @endif
        </h5>

        <!-- Buttons -->
        <div class="btn-group">
            <button onclick="window.print()">🖨️ Print</button>
            <a href="{{ route('sales.report.export', array_merge(request()->all(), ['type' => 'pdf'])) }}">📄 Export
                PDF</a>
            <a href="{{ route('sales.report.export', array_merge(request()->all(), ['type' => 'excel'])) }}">📊 Export
                Excel</a>
        </div>

        <!-- Report Table -->
        <!-- Report Table -->
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Invoice</th>
                    <th>Cashier</th>
                    <th>Product Name</th>
                    <th>Qty</th>
                    <th>Total ₦</th>
                    <th>Paid ₦</th>
                    <th>Balance ₦</th>
                    <th>Method</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $total = 0;
                    $paid = 0;
                    $balance = 0;
                @endphp
                @foreach ($sales as $index => $sale)
                    @php
                        $total += $sale->total_amount;
                        $paid += $sale->amount_paid;
                        $balance += $sale->balance;
                    @endphp
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $sale->invoice_no ?? '-' }}</td>
                        <td>{{ $sale->user->name ?? '-' }}</td>
                        <td>{{ $sale->product_name }}</td>
                        <td>{{ $sale->quantity }}</td>
                        <td>{{ number_format($sale->total_amount, 2) }}</td>
                        <td>{{ number_format($sale->amount_paid, 2) }}</td>
                        <td>{{ number_format($sale->balance, 2) }}</td>
                        <td>{{ $sale->method_of_payment }}</td>
                        <td>{{ \Carbon\Carbon::parse($sale->created_at)->format('Y-m-d') }}</td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <th colspan="5" style="text-align:right">TOTAL</th>
                    <th>₦{{ number_format($total, 2) }}</th>
                    <th>₦{{ number_format($paid, 2) }}</th>
                    <th>₦{{ number_format($balance, 2) }}</th>
                    <th colspan="2"></th>
                </tr>
            </tfoot>
        </table>

        <!-- Footer Section -->
        <div style="margin-top: 50px; font-size: 13px; text-align: center;">
            <p>Printed by: <strong>{{ auth()->user()->name ?? 'System' }}</strong></p>
            <p>Printed on: <strong>{{ now()->format('Y-m-d H:i:s') }}</strong></p>
            <br><br>
        </div>
        
    </div>
  
</body>
<script>
    let zoomLevel = 1;
    const report = document.getElementById('reportArea');

    function zoomIn() {
        zoomLevel += 0.1;
        updateZoom();
    }

    function zoomOut() {
        zoomLevel = Math.max(0.5, zoomLevel - 0.1);
        updateZoom();
    }

    function resetZoom() {
        zoomLevel = 1;
        updateZoom();
    }

    function updateZoom() {
        report.style.transform = `scale(${zoomLevel})`;
    }
</script>


</html>
