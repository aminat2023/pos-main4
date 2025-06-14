<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transaction History</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            background: #f9f9f9;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
            font-size: 14px;
        }
        th {
            background-color: #008B8B;
            color: white;
        }
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        h1 {
            color: #008B8B;
        }
    </style>
</head>
<body>
    <h1>Transaction History</h1>
    <table>
        <thead>
            <tr>
                <th>Transaction ID</th>
                <th>Order ID</th>
                <th>User ID</th>
                <th>Paid Amount</th>
                <th>Balance</th>
                <th>Payment Method</th>
                <th>Transaction Amount</th>
                <th>Transaction Date</th>
            </tr>
        </thead>
        <tbody>
            @if($transactions->count())
                @foreach($transactions as $transaction)
                    <tr>
                        <td>{{ $transaction->id }}</td>
                        <td>{{ $transaction->order_id }}</td>
                        <td>{{ $transaction->user_id }}</td>
                        <td>&#8358;{{ number_format($transaction->paid_amount, 2) }}</td>
                        <td>&#8358;{{ number_format($transaction->balance, 2) }}</td>
                        <td>{{ ucfirst($transaction->payment_method) }}</td>
                        <td>&#8358;{{ number_format($transaction->transaction_amount, 2) }}</td>
                        <td>{{ $transaction->transaction_date }}</td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="8" class="text-center">No transaction data available.</td>
                </tr>
            @endif
        </tbody>
    </table>
</body>
</html>