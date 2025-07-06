@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        {{-- Flash Messages --}}
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="close" data-dismiss="alert">&times;</button>
            </div>
        @endif
        @if (session('error'))
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

        <div class="row">
            {{-- Main Table --}}
            <div class="col-lg-9 col-md-8 col-12 mb-3">
                <div class="card h-100">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4 class="mb-0">User Management</h4>
                        <a href="#" class="btn btn-dark" data-toggle="modal" data-target="#addUser">
                            <i class="fa fa-plus"></i> Add new user
                        </a>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover table-sm m-0">
                                <thead class="thead-light">
                                    <tr>
                                        <th>#</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Role</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($users as $key => $user)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $user->name }}</td>
                                            <td>{{ $user->email }}</td>
                                            <td>
                                                <span
                                                    class="badge {{ $user->is_admin ? 'badge-primary' : 'badge-secondary' }}">
                                                    {{ $user->is_admin ? 'Admin' : 'Cashier' }}
                                                </span>
                                            </td>
                                            <td>
                                                <div class="btn-group">
                                                    <a href="{{ route('users.index', ['view' => $user->id]) }}"
                                                        class="btn btn-warning btn-sm">
                                                        <i class="fa fa-eye"></i>
                                                    </a>
                                                    <button class="btn btn-info btn-sm" data-toggle="modal"
                                                        data-target="#editUser{{ $user->id }}">
                                                        <i class="fa fa-edit"></i>
                                                    </button>
                                                    <form action="{{ route('users.destroy', $user->id) }}" method="POST"
                                                        onsubmit="return confirm('Delete this user?');">
                                                        @csrf @method('DELETE')
                                                        <button type="submit" class="btn btn-danger btn-sm">
                                                            <i class="fa fa-trash"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>

                                        {{-- Edit Modal --}}
                                        <div class="modal fade" id="editUser{{ $user->id }}" tabindex="-1">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header"
                                                        style="background-color: #008B8B;color:white;">

                                                        <h4>Edit User</h4><button class="close"
                                                            data-dismiss="modal">&times;</button>
                                                    </div>
                                                    <form action="{{ route('users.update', $user->id) }}" method="POST">
                                                        @csrf @method('PUT')
                                                        <div class="modal-body">
                                                            <div class="form-group"><label>Name</label><input type="text"
                                                                    name="name" value="{{ $user->name }}"
                                                                    class="form-control"></div>
                                                            <div class="form-group"><label>Email</label><input
                                                                    type="email" name="email"
                                                                    value="{{ $user->email }}" class="form-control"></div>
                                                            <div class="form-group"><label>Phone</label><input
                                                                    type="text" name="phone"
                                                                    value="{{ $user->phone }}" class="form-control"></div>
                                                            <div class="form-group">
                                                                <label>Role</label>
                                                                <select name="is_admin" class="form-control">
                                                                    <option value="1"
                                                                        {{ $user->is_admin ? 'selected' : '' }}>Admin
                                                                    </option>
                                                                    <option value="0"
                                                                        {{ !$user->is_admin ? 'selected' : '' }}>Cashier
                                                                    </option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer"><button class="btn btn-block"
                                                                style="background-color: #008B8B;color:white;">
                                                                Save
                                                            </button></div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Sidebar Detail --}}
            <div class="col-lg-3 col-md-4 col-12 mb-3">
                <div class="card h-100">
                    <div class="card-header">
                        <h5>User Details</h5>
                    </div>
                    <div class="card-body">
                        @if ($selectedUser)
                            <p><strong>Name:</strong> {{ $selectedUser->name }}</p>
                            <p><strong>Email:</strong> {{ $selectedUser->email }}</p>
                            <p><strong>Phone:</strong> {{ $selectedUser->phone }}</p>
                            <p><strong>Role:</strong> <span
                                    class="badge {{ $selectedUser->is_admin ? 'badge-primary' : 'badge-secondary' }}">{{ $selectedUser->is_admin ? 'Admin' : 'Cashier' }}</span>
                            </p>
                            <a href="{{ route('users.index') }}" class="btn btn-danger btn-sm mt-2">Close View</a>
                        @else
                            <p>Select a user to view details.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Add User Modal --}}
    <div class="modal fade" id="addUser" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header" style="background-color: #008B8B;color:white;">
                    <h4>Add User</h4><button class="close" data-dismiss="modal">&times;</button>
                </div>
                <form action="{{ route('users.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group"><label>Name</label><input type="text" name="name" class="form-control"
                                required></div>
                        <div class="form-group"><label>Email</label><input type="email" name="email"
                                class="form-control" required></div>
                        <div class="form-group"><label>Phone</label><input type="text" name="phone"
                                class="form-control"></div>
                        <div class="form-group"><label>Password</label><input type="password" name="password"
                                class="form-control" required></div>
                        <div class="form-group"><label>Confirm Password</label><input type="password"
                                name="confirm_password" class="form-control" required></div>
                        <div class="form-group">
                            <label>Role</label>
                            <select name="is_admin" class="form-control">
                                <option value="1">Admin</option>
                                <option value="0">Cashier</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer"><button style="background-color: #008B8B;color:white;"
                            class="btn btn-block">Save</button></div>
                </form>
            </div>
        </div>
    </div>

    <style>
        .card-header {
            background-color: #008B8B;
            color: white;
            font-weight: bold;
            border-radius: .25rem .25rem 0 0;
        }

        .card {
            border-radius: 5px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.08);
            margin-bottom: 20px;
        }

        .btn-group form {
            display: inline-block;
        }

        .table td,
        .table th {
            vertical-align: middle;
            font-size: 14px;
            padding: .5rem;
        }

        .table-responsive {
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }

        @media (max-width: 768px) {

            .table th,
            .table td {
                font-size: 12px;
                padding: .4rem;
            }

            .card-header h4,
            .card-header h5 {
                font-size: 16px;
            }

            .btn {
                font-size: 12px;
                padding: 6px 10px;
            }

            .modal-dialog {
                max-width: 90%;
                margin: 1.75rem auto;
            }
        }

        @media (max-width: 576px) {
            .btn {
                font-size: 11px;
                padding: 5px 8px;
            }

            .table td,
            .table th {
                font-size: 11px;
            }

            .form-control {
                font-size: 13px;
            }
        }
    </style>
@endsection
