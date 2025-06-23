<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        body {
            font-family: Arial, sans-serif;
        }
    
        h3 {
            text-align: center;
            font-size: 20px;
            margin-bottom: 10px;
        }
    
        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 12px;
        }
    
        th, td {
            border: 1px solid #333;
            padding: 6px 8px;
            text-align: left;
        }
    
        th {
            background-color: #008B8B;
            color: white;
            font-weight: bold;
            text-transform: uppercase;
            font-size: 23px;
            letter-spacing: 0.5px;
        }
    
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
    </style>
    
</head>
<body>
    <h3>Counter Sales Report</h3>
    <table>
        <thead>
            <tr style="font-size: 2rem;">
                <th>#</th>
                <th>Date</th>
                <th>Product</th>
                <th>Qty</th>
                <th>Total</th>
                <th>Cashier</th>
                <th>Payment Method</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($sales as $index => $sale)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ \Carbon\Carbon::parse($sale->created_at)->format('Y-m-d H:i') }}</td>
                <td>{{ $sale->product->product_name ?? 'N/A' }}</td>
                <td>{{ $sale->quantity }}</td>
                <td>{{ number_format($sale->total_amount, 2) }}</td>
                <td>{{ $sale->user->name ?? 'N/A' }}</td>
                <td>{{ ucfirst($sale->method_of_payment ?? 'N/A') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
