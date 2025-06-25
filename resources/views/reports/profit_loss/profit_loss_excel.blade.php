<table>
    <thead>
        <tr>
            <th colspan="4" style="text-align:center; font-size:16px;">
                {{ getPreference('business_name', 'My Business') }} - Profit & Loss Report
            </th>
        </tr>
        <tr>
            <th>Date</th>
            <th>Description</th>
            <th>Type</th>
            <th>Amount (₦)</th>
        </tr>
    </thead>
    <tbody>
        @php $totalProfit = 0; $totalExpense = 0; @endphp
        @foreach($report as $entry)
            <tr>
                <td>{{ $entry['date'] }}</td>
                <td>{{ $entry['description'] }}</td>
                <td>{{ $entry['type'] }}</td>
                <td>{{ number_format($entry['amount'], 2) }}</td>
                @if ($entry['type'] === 'Credit')
                    @php $totalProfit += $entry['amount']; @endphp
                @else
                    @php $totalExpense += $entry['amount']; @endphp
                @endif
            </tr>
        @endforeach
    </tbody>
    <tfoot>
        <tr>
            <td colspan="3"><strong>Total Credit</strong></td>
            <td>{{ number_format($totalProfit, 2) }}</td>
        </tr>
        <tr>
            <td colspan="3"><strong>Total Debit</strong></td>
            <td>{{ number_format($totalExpense, 2) }}</td>
        </tr>
        <tr>
            <td colspan="3"><strong>Net Profit / Loss</strong></td>
            <td>{{ number_format($totalProfit - $totalExpense, 2) }}</td>
        </tr>
    </tfoot>
</table>


