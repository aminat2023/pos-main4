<table>
    <thead>
        <tr>
            <th>#</th>
            <th>Date</th>
            <th>Product</th>
            <th>Cashier</th>
            <th>Qty</th>
            <th>Profit (₦)</th>
        </tr>
    </thead>
    <tbody>
        @php $total = 0; @endphp
        @foreach($profits as $index => $profit)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $profit['date'] }}</td>
                <td>{{ $profit['product'] }}</td>
                <td>{{ $profit['cashier'] }}</td>
                <td>{{ $profit['quantity'] }}</td>
                <td>{{ $profit['profit'] }}</td>
            </tr>
            @php $total += $profit['profit']; @endphp
        @endforeach
        <tr>
            <td colspan="5" style="text-align:right"><strong>TOTAL</strong></td>
            <td><strong>{{ number_format($total, 2) }}</strong></td>
        </tr>
    </tbody>
</table>
