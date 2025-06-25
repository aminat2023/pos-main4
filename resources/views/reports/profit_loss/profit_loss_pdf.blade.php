<!DOCTYPE html>
<html>
<head>
    <title>Profit & Loss Report - PDF</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { padding: 8px; border: 1px solid #ccc; text-align: left; }
        th { background-color: #000; color: #fff; }
        .text-success { color: green; }
        .text-danger { color: red; }
        .text-right { text-align: right; }
    </style>
</head>
<body>
    <h2 style="text-align: center;">{{ getPreference('business_name', 'My Business') }}</h2>
    <h3 style="text-align: center;">Profit & Loss Report</h3>
    <p><strong>From:</strong> {{ $from }} &nbsp; <strong>To:</strong> {{ $to }}</p>

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
            @php $totalProfit = 0; $totalExpense = 0; @endphp
            @foreach($report as $entry)
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
            @endforeach
        </tbody>
    </table>

    <br><br>
    <table>
        <tr>
            <th>Total Credit</th>
            <td class="text-right text-success">{{ number_format($totalProfit, 2) }}</td>
        </tr>
        <tr>
            <th>Total Debit</th>
            <td class="text-right text-danger">{{ number_format($totalExpense, 2) }}</td>
        </tr>
        <tr>
            <th>Net Profit / Loss</th>
            <td class="text-right {{ $totalProfit - $totalExpense >= 0 ? 'text-success' : 'text-danger' }}">
                {{ number_format($totalProfit - $totalExpense, 2) }}
            </td>
        </tr>
    </table>
</body>
</html>
