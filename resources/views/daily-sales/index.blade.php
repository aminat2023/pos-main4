@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Daily Sales History</h2>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Transaction Date</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($sales as $sale)
                <tr>
                    <td >{{ $sale->date }}</td>
                    <td>
                        <a href="{{ route('daily_sales.show', $sale->date) }}" class="btn btn-primary btn-sm">View Details</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
