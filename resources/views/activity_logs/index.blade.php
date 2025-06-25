@extends('layouts.app')

@section('content')
<div class="container">
    <h4>User Activity Log</h4>
    
    @if ($logs->count())
        <table class="table table-bordered table-striped" style="color: white">
            <thead class="thead-dark">
                <tr>
                    <th>Date</th>
                    <th>User</th>
                    <th>Activity</th>
                    <th>Description</th>
                </tr>
            </thead>
            <tbody>
                @foreach($logs as $log)
                    <tr>
                        <td>{{ $log->created_at->format('Y-m-d H:i') }}</td>
                        <td>{{ $log->user->name ?? 'System' }}</td>
                        <td>{{ $log->activity }}</td>
                        <td>{{ $log->description }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        {{ $logs->links() }}
    @else
        <div class="alert alert-warning">
            No activity logs available.
        </div>
    @endif
</div>
@endsection
