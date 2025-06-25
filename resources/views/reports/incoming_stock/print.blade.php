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
            background-color: black;
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
            <h3>Incoming stock Report</h3>
            <div class="text-center my-3 no-print">
                <a href="{{ route('incoming_stock.report.pdf', request()->all()) }}" class="styled-btn btn-pdf"
                    target="_blank">
                    📄 Export PDF
                </a>

                <a href="{{ route('incoming_stock.report.excel', request()->all()) }}" class="styled-btn btn-excel">
                    📊 Export Excel
                </a>

                <button onclick="window.print()" class="styled-btn btn-print">
                    🖨️ Print
                </button>
            </div>
        </div>

        <table class="table table-bordered table-striped">
            <thead class="thead-dark">
                <tr>
                    <th>#</th>
                    <th>Product Name</th>
                    <th>Code</th>
                    <th>Description</th>
                    <th>Section</th>
                    <th>Category</th>
                    <th>Qty</th>
                    <th>Cost Price</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($stocks as $index => $stock)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $stock->product_name }}</td>
                        <td>{{ $stock->product_code }}</td>
                        <td>{{ $stock->product->description ?? '-' }}</td>
                        <td>{{ $stock->product->section_name ?? '-' }}</td>
                        <td>{{ $stock->product->category_name ?? '-' }}</td>
                        <td>{{ $stock->quantity }}</td>
                        <td>₦{{ number_format($stock->cost_price, 2) }}</td>
                        <td>{{ $stock->created_at->format('Y-m-d') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>


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
    <style>
        .styled-btn {
            display: inline-block;
            padding: 10px 20px;
            margin: 0 5px;
            font-size: 14px;
            font-weight: 600;
            text-decoration: none;
            border-radius: 5px;
            color: white;
            border: none;
            cursor: pointer;
            transition: background 0.3s ease-in-out, transform 0.2s;
        }

        .styled-btn:hover {
            transform: scale(1.05);
        }

        .btn-pdf {
            background-color: #dc3545;
        }

        .btn-pdf:hover {
            background-color: #c82333;
        }

        .btn-excel {
            background-color: #28a745;
        }

        .btn-excel:hover {
            background-color: #218838;
        }

        .btn-print {
            background-color: #343a40;
        }

        .btn-print:hover {
            background-color: #23272b;
        }
    </style>
</body>

</html>
