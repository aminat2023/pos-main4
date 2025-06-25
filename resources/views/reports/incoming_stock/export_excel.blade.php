<table>
    <thead>
        <tr>
            <th>#</th>
            <th>Product</th>
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
                <td>{{ $index + 1 }}</td>
                <td>{{ $stock->product_name }}</td>
                <td>{{ $stock->product_code }}</td>
                <td>{{ $stock->product->description ?? '-' }}</td>
                <td>{{ $stock->product->section_name ?? '-' }}</td>
                <td>{{ $stock->product->category_name ?? '-' }}</td>
                <td>{{ $stock->quantity }}</td>
                <td>{{ $stock->cost_price }}</td>
                <td>{{ $stock->created_at->format('Y-m-d') }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
