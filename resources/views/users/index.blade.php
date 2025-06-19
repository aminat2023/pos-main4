@extends('layouts.app')

@section('content')
<div class="container">
    {{-- Flash Messages --}}
    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
    @endif

    @if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ session('error') }}
        <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
    @endif

    {{-- Validation Errors --}}
    @if ($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <div class="col-lg-12">
        <div class="row">
            {{-- User Table --}}
            <div class="col-md-9">
                <div class="card">
                    <div class="card-header">
                        <h4 style="float:left">User Management</h4>
                        <a href="#" style="float:right" class="btn btn-dark" data-toggle="modal" data-target="#addUser">
                            <i class="fa fa-plus"></i> Add new user
                        </a>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered table-left">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Role</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($users as $key => $user)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>
                                        <span class="badge {{ $user->is_admin == 1 ? 'badge-primary' : 'badge-secondary' }}">
                                            {{ $user->is_admin == 1 ? 'Admin' : 'Cashier' }}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="btn-group">
                                            <a href="{{ route('users.index', ['view' => $user->id]) }}" class="btn btn-warning btn-sm">
                                                <i class="fa fa-eye"></i> 
                                            </a>
                                            
                                            <a href="#" class="btn btn-info btn-sm" data-toggle="modal" data-target="#editUser{{ $user->id }}">
                                                <i class="fa fa-edit"></i> 
                                            </a>
                                            <form action="{{ route('users.destroy', $user->id) }}" method="POST" style="display:inline-block;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this user?');">
                                                    <i class="fa fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>

                                {{-- Edit User Modal --}}
                                <div class="modal fade" id="editUser{{ $user->id }}" tabindex="-1">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title">Edit User</h4>
                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                            </div>
                                            <div class="modal-body">
                                                <form action="{{ route('users.update', $user->id) }}" method="post">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="form-group">
                                                        <label>Name</label>
                                                        <input type="text" name="name" value="{{ $user->name }}" class="form-control">
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Email</label>
                                                        <input type="email" name="email" value="{{ $user->email }}" class="form-control">
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Phone</label>
                                                        <input type="text" name="phone" value="{{ $user->phone }}" class="form-control">
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Role</label>
                                                        <select name="is_admin" class="form-control">
                                                            <option value="1" {{ $user->is_admin == 1 ? 'selected' : '' }}>Admin</option>
                                                            <option value="0" {{ $user->is_admin == 0 ? 'selected' : '' }}>Cashier</option>
                                                        </select>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button class="btn btn-primary btn-block">Save</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            {{-- Search Sidebar --}}
           {{-- Search Sidebar --}}
<div class="col-md-3">
    <div class="card">
        <div class="card-header"><h5>User Details</h5></div>
        <div class="card-body">
            @if($selectedUser)
                <p><strong>Name:</strong> {{ $selectedUser->name }}</p>
                <p><strong>Email:</strong> {{ $selectedUser->email }}</p>
                <p><strong>Phone:</strong> {{ $selectedUser->phone }}</p>
                <p><strong>Role:</strong> 
                    <span class="badge {{ $selectedUser->is_admin == 1 ? 'badge-primary' : 'badge-secondary' }}">
                        {{ $selectedUser->is_admin == 1 ? 'Admin' : 'Cashier' }}
                    </span>
                </p>
                <a href="{{ route('users.index') }}" class="btn btn-sm btn-danger mt-2">Close View</a>
            @else
                <p>Select a user to view details.</p>
            @endif
        </div>
    </div>
</div>

        </div>
    </div>
</div>

{{-- Add User Modal --}}
<div class="modal right fade" id="addUser" data-backdrop="static" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Add User</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <form action="{{ route('users.store') }}" method="post">
                    @csrf
                    <div class="form-group">
                        <label>Name</label>
                        <input type="text" name="name" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Email</label>
                        <input type="email" name="email" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Phone</label>
                        <input type="text" name="phone" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Password</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Confirm Password</label>
                        <input type="password" name="confirm_password" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Role</label>
                        <select name="is_admin" class="form-control">
                            <option value="1">Admin</option>
                            <option value="0">Cashier</option>
                        </select>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-primary btn-block">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

{{-- Custom Styles --}}
<style>
    .modal.right .modal-dialog {
        top: 0;
        right: 0;
        margin-right: 19vh;
    }
    .modal.fade:not(.in).right .modal-dialog {
        transform: translate3d(25%, 0, 0);
    }

    .card {
        box-shadow: 0 4px 8px rgba(0, 0, 0, 10);
        border-radius: 5px;
    }

    .card-header {
        box-shadow: 0 4px 8px rgba(20, 20, 20, 0.9);
        border-radius: 20px;
        background-color: #008B8B;
        color: white;
    }

    .card:hover {
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.9);
    }
</style>
@endsection
