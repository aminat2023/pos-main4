@extends('layouts.app')

@section('content')
<div class="container">
    <h4 class="mb-3">📋 Apply for a Loan</h4>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form action="{{ route('loans.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        {{-- Personal Info --}}
        <h5 style="color:white; font-size:1.5rem;font-style:italic;">Personal Information :</h5>
        <div class="card shadow-sm p-3 mb-4">
           
            <div class="row">
                <div class="col-md-6 mb-2">
                    <label>Full Name</label>
                    <input type="text" name="full_name" class="form-control" required>
                </div>
                <div class="col-md-3 mb-2">
                    <label>Date of Birth</label>
                    <input type="date" name="dob" class="form-control" required>
                </div>
                <div class="col-md-3 mb-2">
                    <label>Gender</label>
                    <select name="gender" class="form-control" required>
                        <option value="">--Select--</option>
                        <option>Male</option>
                        <option>Female</option>
                    </select>
                </div>
                <div class="col-md-3 mb-2">
                    <label>Marital Status</label>
                    <select name="marital_status" class="form-control" required>
                        <option value="">--Select--</option>
                        <option>Single</option>
                        <option>Married</option>
                        <option>Divorced</option>
                    </select>
                </div>
                <div class="col-md-9 mb-2">
                    <label>Residential Address</label>
                    <input type="text" name="address" class="form-control" required>
                </div>
                <div class="col-md-6 mb-2">
                    <label>Phone</label>
                    <input type="text" name="phone" class="form-control" required>
                </div>
                <div class="col-md-6 mb-2">
                    <label>Email</label>
                    <input type="email" name="email" class="form-control" required>
                </div>
            </div>
        </div>

        {{-- Identification --}}
        <h5 style="color:white; font-size:1.5rem;font-style:italic;">Identification Documents:</h5>
        <div class="card shadow-sm p-3 mb-4">
            <div class="mb-2">
                <label>NIN</label>
                <input type="text" name="nin" class="form-control" required>
            </div>
            <div class="mb-2">
                <label>Government-Issued ID</label>
                <input type="file" name="gov_id" class="form-control-file" required>
            </div>
            <div class="mb-2">
                <label>Utility Bill</label>
                <input type="file" name="utility_bill" class="form-control-file" required>
            </div>
        </div>



        {{-- Employment --}}
        <h5  style="color:white; font-size:1.5rem;font-style:italic;" >Employment Information:</h5>
        <div class="card shadow-sm p-3 mb-4">
            <div class="row">
                <div class="col-md-4 mb-2">
                    <label>Status</label>
                    <select name="employment_status" class="form-control" required>
                        <option>Employed</option>
                        <option>Self-employed</option>
                        <option>Unemployed</option>
                    </select>
                </div>
                <div class="col-md-4 mb-2">
                    <label>Employer Name</label>
                    <input type="text" name="employer_name" class="form-control">
                </div>
                <div class="col-md-4 mb-2">
                    <label>Employer Address</label>
                    <input type="text" name="employer_address" class="form-control">
                </div>
                <div class="col-md-6 mb-2">
                    <label>Job Title</label>
                    <input type="text" name="job_title" class="form-control">
                </div>
                <div class="col-md-6 mb-2">
                    <label>Monthly Income (₦)</label>
                    <input type="number" step="0.01" name="monthly_income" class="form-control" required>
                </div>
            </div>
        </div>

        {{-- Financial Info --}}
        <div class="card shadow-sm p-3 mb-4">
            <h5  style="color:white; font-size:1.5rem;font-style:italic;">Financial Information:</h5>
            <div class="mb-2">
                <label>Bank Statements (PDF/JPG)</label>
                <input type="file" name="bank_statements" class="form-control-file" required>
            </div>
            <div class="mb-2">
                <label>Credit History</label>
                <textarea name="credit_history" class="form-control"></textarea>
            </div>
            <div class="mb-2">
                <label>Existing Debts</label>
                <textarea name="existing_debts" class="form-control"></textarea>
            </div>
        </div>

        {{-- Loan Request --}}
        <div class="card shadow-sm p-3 mb-4">
            <h5>Loan Details</h5>
            <div class="row">
                <div class="col-md-4 mb-2">
                    <label>Loan Amount (₦)</label>
                    <input type="number" name="loan_amount" class="form-control" required>
                </div>
                <div class="col-md-4 mb-2">
                    <label>Purpose</label>
                    <input type="text" name="loan_purpose" class="form-control" required>
                </div>
                <div class="col-md-4 mb-2">
                    <label>Repayment Plan</label>
                    <input type="text" name="repayment_plan" class="form-control" required>
                </div>
            </div>
        </div>

        {{-- Extras --}}
        <div class="card shadow-sm p-3 mb-4">
            <h5>Additional Documents</h5>
            <div class="mb-2">
                <label>Collateral Documents (Optional)</label>
                <input type="file" name="collateral_docs" class="form-control-file">
            </div>
            <div class="mb-2">
                <label>Guarantor Information (Optional)</label>
                <textarea name="guarantor_info" class="form-control"></textarea>
            </div>
        </div>

        <button type="submit" class="btn btn-success btn-lg">📩 Submit Application</button>
    </form>
</div>
@endsection
