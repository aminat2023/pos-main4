@extends('layouts.app')

@section('content')
<div class="container">
    <h4>📄 Apply for a Loan</h4>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form action="{{ route('loans.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <!-- Personal Information -->
        <div class="form-group">
            <label>Full Name</label>
            <input type="text" name="full_name" class="form-control" required>
        </div>

        <div class="form-group">
            <label>Date of Birth</label>
            <input type="date" name="dob" class="form-control" required>
        </div>

        <div class="form-group">
            <label>Gender</label>
            <select name="gender" class="form-control" required>
                <option value="">-- Select --</option>
                <option value="male">Male</option>
                <option value="female">Female</option>
            </select>
        </div>

        <div class="form-group">
            <label>Marital Status</label>
            <input type="text" name="marital_status" class="form-control" required>
        </div>

        <div class="form-group">
            <label>Address</label>
            <textarea name="address" class="form-control" required></textarea>
        </div>

        <div class="form-group">
            <label>Phone</label>
            <input type="text" name="phone" class="form-control" required>
        </div>

        <div class="form-group">
            <label>Email</label>
            <input type="email" name="email" class="form-control" required>
        </div>

        <!-- Identification -->
        <div class="form-group">
            <label>NIN</label>
            <input type="text" name="nin" class="form-control" required>
        </div>

        <div class="form-group">
            <label>Government Issued ID</label>
            <input type="file" name="gov_id" class="form-control" required>
        </div>

        <div class="form-group">
            <label>Utility Bill</label>
            <input type="file" name="utility_bill" class="form-control" required>
        </div>

        <!-- Employment Info -->
        <div class="form-group">
            <label>Employment Status</label>
            <input type="text" name="employment_status" class="form-control" required>
        </div>

        <div class="form-group">
            <label>Employer Name</label>
            <input type="text" name="employer_name" class="form-control">
        </div>

        <div class="form-group">
            <label>Employer Address</label>
            <input type="text" name="employer_address" class="form-control">
        </div>

        <div class="form-group">
            <label>Job Title</label>
            <input type="text" name="job_title" class="form-control">
        </div>

        <div class="form-group">
            <label>Monthly Income</label>
            <input type="number" name="monthly_income" class="form-control" required>
        </div>

        <div class="form-group">
            <label>Bank Statements</label>
            <input type="file" name="bank_statements" class="form-control" required>
        </div>

        <div class="form-group">
            <label>Credit History</label>
            <textarea name="credit_history" class="form-control"></textarea>
        </div>

        <div class="form-group">
            <label>Existing Debts</label>
            <textarea name="existing_debts" class="form-control"></textarea>
        </div>

        <!-- Loan Details -->
        <div class="form-group">
            <label>Loan Amount</label>
            <input type="number" name="loan_amount" class="form-control" required>
        </div>

        <div class="form-group">
            <label>Loan Purpose</label>
            <textarea name="loan_purpose" class="form-control" required></textarea>
        </div>

        <div class="form-group">
            <label>Repayment Plan</label>
            <textarea name="repayment_plan" class="form-control" required></textarea>
        </div>

        <!-- Optional -->
        <div class="form-group">
            <label>Collateral Documents</label>
            <input type="file" name="collateral_docs" class="form-control">
        </div>

        <div class="form-group">
            <label>Guarantor Information</label>
            <textarea name="guarantor_info" class="form-control"></textarea>
        </div>

        <button type="submit" class="btn btn-primary mt-3">Submit Loan Application</button>
    </form>
</div>
@endsection
