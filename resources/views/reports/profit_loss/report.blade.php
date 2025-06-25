<!DOCTYPE html>
<html>

<head>
    <title>Profit & Loss Report</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 13px;
            margin: 30px;
            background-color: #444;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        th,
        td {
            padding: 10px;
            border-bottom: 1px solid #ccc;
        }

        th {
            background-color:black;
            color: #fff;
        }

        .text-right {
            text-align: right;
        }

        .text-success {
            color: green;
        }

        .text-danger {
            color: red;
        }

        .summary {
            margin-top: 20px;
        }

        .report-wrapper {
            background-color: #ffffff;
            width: 90%;
            max-width: 900px;
            margin: auto;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        }

        .zoom-controls {
            text-align: center;
            margin-bottom: 15px;
        }

        .zoom-controls button {
            background-color: black;
            color: white;
            border: none;
            padding: 10px 16px;
            margin: 0 5px;
            font-size: 14px;
            border-radius: 4px;
            cursor: pointer;
        }

        .zoom-controls button:hover {
            background-color: #006f6f;
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

    <div id="reportArea" class="report-wrapper zoomable">
        <div class="header">
            <h2>{{ getPreference('business_name', 'My Business') }}</h2>
            <h3>📈 Profit & Loss Report</h3>
            <p>From: <strong>{{ $from }}</strong> To: <strong>{{ $to }}</strong></p>

          
            <div style="text-align:center; margin-top: 20px;">
                <button onclick="window.print()" style="background-color:#343a40; color:white; border:none; padding:10px 20px; margin:5px; border-radius:4px;">
                    🖨️ Print
                </button>
                <a href="{{ route('profit_loss.pdf', ['from_date' => request('from_date'), 'to_date' => request('to_date')]) }}"
                   style="background-color:#dc3545; color:white; text-decoration:none; padding:10px 20px; margin:5px; border-radius:4px;">
                   📄 Export PDF
                </a>
                <a href="{{ route('profit_loss.excel', ['from_date' => request('from_date'), 'to_date' => request('to_date')]) }}"
                   style="background-color:#28a745; color:white; text-decoration:none; padding:10px 20px; margin:5px; border-radius:4px;">
                   📊 Export Excel
                </a>
            </div>
            
    
            
        </div>

        <table>
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Description</th>
                    <th>Type</th>
                    <th class="text-right">Amount (₦)</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $totalProfit = 0;
                    $totalExpense = 0;
                @endphp

                @forelse($report as $entry)
                    <tr>
                        <td>{{ $entry['date'] }}</td>
                        <td>{{ $entry['description'] }}</td>
                        <td>
                            @if ($entry['type'] === 'Credit')
                                <span class="text-success">Credit</span>
                                @php $totalProfit += $entry['amount']; @endphp
                            @else
                                <span class="text-danger">Debit</span>
                                @php $totalExpense += $entry['amount']; @endphp
                            @endif
                        </td>
                        <td class="text-right">{{ number_format($entry['amount'], 2) }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center">No data for this period.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div class="summary">
            <hr>
            <table>
                <tr>
                    <td><strong>Total Credit</strong></td>
                    <td class="text-right text-success">{{ number_format($totalProfit, 2) }}</td>
                </tr>
                <tr>
                    <td><strong>Total Debit</strong></td>
                    <td class="text-right text-danger">{{ number_format($totalExpense, 2) }}</td>
                </tr>
                <tr>
                    <td><strong>Net Profit / Loss</strong></td>
                    <td class="text-right {{ $totalProfit - $totalExpense >= 0 ? 'text-success' : 'text-danger' }}">
                        {{ number_format($totalProfit - $totalExpense, 2) }}
                    </td>
                </tr>
            </table>
        </div>
    </div>

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
</body>

</html>
