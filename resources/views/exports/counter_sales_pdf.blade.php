<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Counter Sales Report</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #000; padding: 1px; text-align: left; }
        th { background-color: #f2f2f2; }
        h2 { text-align: center; }
    </style>
</head>
<body>
    <h2>Counter Sales Report</h2>
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Cashier</th>
                <th>Product</th>
                <th>Qty</th>
                <th>Total</th>
                <th>Payment Method</th>
                <th>Date</th>
            </tr>
        </thead>
        <tbody>
            @foreach($sales as $index => $sale)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $sale->user->name ?? 'N/A' }}</td>
                <td>{{ $sale->product->product_name ?? 'N/A' }}</td>
                <td>{{ $sale->quantity }}</td>
                <td>{{ number_format($sale->total_amount, 2) }}</td>
                <td>{{ $sale->method_of_payment?? 'N/A' }}</td>
                <td>{{ $sale->created_at->format('Y-m-d H:i') }}</td>
            </tr>
            
            @endforeach
        </tbody>
    </table>
</body>
</html>
