<!-- resources/views/reports/pos_report.blade.php -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>POS Report</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .header h1 {
            margin: 0;
            font-size: 24px;
        }
        .header p {
            margin: 5px;
        }
        .table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        .table th, .table td {
            padding: 8px;
            text-align: left;
            border: 1px solid #ddd;
        }
        .table th {
            background-color: #f4f4f4;
        }
        .footer {
            margin-top: 40px;
            text-align: center;
        }
    </style>
</head>
<body>

    <div class="header">
        <h1>POS Order Report</h1>
        <p>Order ID: {{ $order->id }}</p>
        <p>Date: {{ $order->created_at->format('F d, Y') }}</p>
        <p>Customer: {{ $order->name }} ({{ $order->phone }})</p>
    </div>

    <table class="table">
        <thead>
            <tr>
                <th>Product</th>
                <th>Quantity</th>
                <th>Unit Price</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($orderDetails as $detail)
                <tr>
                    <td>{{ $detail->product->product_name }}</td>
                    <td>{{ $detail->quantity }}</td>
                    <td>&#8358;{{ number_format($detail->unit_price, 2) }}</td>
                    <td>&#8358;{{ number_format($detail->amount, 2) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <table class="table">
        <tfoot>
            <tr>
                <th>Total Amount</th>
                <td>&#8358;{{ number_format($totalAmount, 2) }}</td>
            </tr>
            <tr>
                <th>Discount</th>
                <td>&#8358;{{ number_format($orderDetails->sum('discount'), 2) }}</td>
            </tr>
            <tr>
                <th>Amount Paid</th>
                <td>&#8358;{{ number_format($transaction->paid_amount, 2) }}</td>
            </tr>
            <tr>
                <th>Balance</th>
                <td>&#8358;{{ number_format($transaction->balance, 2) }}</td>
            </tr>
        </tfoot>
    </table>

    <div class="footer">
        <p>Thank you for your business!</p>
    </div>

</body>
</html>
