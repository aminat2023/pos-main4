@extends('layouts.app')

@section('content')
<div class="container">
    <h4>Create Journal Entry (Two)</h4>

    <form method="POST" action="#">
        @csrf
        <div class="mb-3">
            <label>Reference</label>
            <input type="text" class="form-control" value="{{ $reference }}" readonly>
        </div>

        <div class="mb-3">
            <label>Bank</label>
            <select name="bank_name" class="form-select">
                <option value="">-- Select Bank --</option>
                @foreach($banks as $bank)
                    <option value="{{ $bank }}">{{ $bank }}</option>
                @endforeach
            </select>
        </div>
    </form>
</div>
@endsection
