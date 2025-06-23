@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Withdraw From Till</h5>
        </div>
        <div class="card-body">

            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            @if($errors->has('admin_password'))
                <div class="alert alert-danger">{{ $errors->first('admin_password') }}</div>
            @endif

            <form id="withdrawForm" action="{{ route('till.withdraw.store') }}" method="POST">
                @csrf

                <div class="form-group">
                    <label for="cashier_id">Cashier:</label>
                    <select name="cashier_id" id="cashier_id" class="form-control" onchange="updateTillAmount(this.value)">
                        <option value="">-- Select Cashier --</option>
                        @foreach($cashiers as $cashier)
                            <option value="{{ $cashier->id }}">
                                {{ $cashier->name }} — ₦{{ number_format($tillAmounts[$cashier->id] ?? 0, 2) }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label>Available Till Balance:</label>
                    <input type="text" id="till-amount-display" class="form-control" readonly>
                </div>

                <div class="form-group">
                    <label>Destination:</label>
                    <select name="destination" class="form-control">
                        <option value="bank">Bank</option>
                        <option value="vault">Vault</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Denominations:</label>
                    <input type="number" name="denominations[1000]" placeholder="₦1000 count" class="form-control mb-1">
                    <input type="number" name="denominations[500]" placeholder="₦500 count" class="form-control mb-1">
                    <input type="number" name="denominations[200]" placeholder="₦200 count" class="form-control mb-1">
                    <input type="number" name="denominations[100]" placeholder="₦100 count" class="form-control mb-1">
                    <!-- Add more as needed -->
                </div>

                <div class="form-group">
                    <label>Notes (optional):</label>
                    <textarea name="notes" class="form-control" rows="2"></textarea>
                </div>

                <!-- Hidden admin password field -->
                <input type="hidden" name="admin_password" id="admin_password">

                <button type="button" class="btn btn-success" data-toggle="modal" data-target="#passwordModal">
                    Submit Withdrawal
                </button>
            </form>
        </div>
    </div>
</div>

<!-- Modal for password -->
<div class="modal fade" id="passwordModal" tabindex="-1" aria-labelledby="passwordModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form id="passwordForm" onsubmit="submitWithPassword(event)">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Enter Admin Password</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span>&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="password" id="passwordInput" class="form-control" placeholder="Enter password" required>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Confirm Withdrawal</button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    const tillAmounts = @json($tillAmounts);

    function updateTillAmount(cashierId) {
        const amount = tillAmounts[cashierId] ?? 0;
        document.getElementById('till-amount-display').value = '₦' + Number(amount).toLocaleString();
    }

    function submitWithPassword(e) {
        e.preventDefault();
        const password = document.getElementById('passwordInput').value;
        if (password.trim() === '') {
            alert("Password is required");
            return;
        }

        document.getElementById('admin_password').value = password;
        $('#passwordModal').modal('hide');
        document.getElementById('withdrawForm').submit();
    }
</script>
@endsection
