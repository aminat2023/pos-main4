<!DOCTYPE html>
<html>
<head>
    <title>Expense Report</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 30px;
            background-color: #444;
        }

        .report-wrapper {
            background-color: #ffffff;
            width: 60%;
            max-width: 1000px;
            margin: auto;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 5px  rgb(7, 6, 6);
          
        }

        h2, h4, h5 {
            text-align: center;
            margin: 5px 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 25px;
            font-size: 13px;
        }

        th, td {
            border: 1px solid #999;
            padding: 8px;
            text-align: left;
        }

        tfoot {
            font-weight: bold;
            background: #f4f4f4;
        }

        .btn-group {
            text-align: center;
            margin-bottom: 20px;
        }

        .btn-group a, .btn-group button {
            background-color: #444;
            color: white;
            padding: 8px 15px;
            border: none;
            margin: 5px;
            text-decoration: none;
            font-size: 13px;
            border-radius: 4px;
            cursor: pointer;
        }

        @media print {
            .btn-group {
                display: none;
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
    <div id="reportArea" class="report-wrapper zoomable">

    <h2>{{ getPreference('business_name', 'My Business') }}</h2>
    <h4>Expense Report</h4>
    <h5>
        From: {{ $request->from_date }} To: {{ $request->to_date }}<br>
        @if($request->expense_type === 'specific' && $request->category)
            Category: {{ $request->category }}
        @else
            All Categories
        @endif
    </h5>

    <!-- Export & Print Buttons -->
    <div class="btn-group no-print">
        <button onclick="window.print()">🖨️ Print</button>
        <a href="{{ route('expense.report.export', array_merge(request()->all(), ['type' => 'pdf'])) }}">📄 Export PDF</a>
        <a href="{{ route('expense.report.export', array_merge(request()->all(), ['type' => 'excel'])) }}">📊 Export Excel</a>
    </div>

    <!-- Expense Table -->
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Date</th>
                <th>Description</th>
                <th>Category</th>
                <th>Amount (₦)</th>
            </tr>
        </thead>
        <tbody>
            @php $i = 1; @endphp
            @foreach($expenses as $expense)
                <tr>
                    <td>{{ $i++ }}</td>
                    <td>{{ \Carbon\Carbon::parse($expense->date)->format('Y-m-d') }}</td>
                    <td>{{ $expense->description }}</td>
                    <td>{{ $expense->category }}</td>
                    <td>{{ number_format($expense->amount, 2) }}</td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td colspan="4" style="text-align:right;">TOTAL</td>
                <td>₦{{ number_format($total, 2) }}</td>
            </tr>
        </tfoot>
    </table>

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





