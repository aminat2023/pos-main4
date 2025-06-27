@extends('layouts.app')

@section('content')
<div class="container">
    <h4 class="mb-4 text-center text-white" style="font: 900;font-size:2rem;">💰 Money Box Balances</h4>
    <div class="card mx-auto shadow" style="max-width: 500px; border-radius: 16px;">
        <div class="card-body p-4">

            {{-- Vault Balance Purse --}}
            <div class="mb-4 p-3 text-white rounded shadow-sm" style="background: linear-gradient(135deg, #1e3c72, #2a5298);">
                <h5 class="mb-1">💼 Vault (Cash)</h5>
                <p class="fw-bold display-6 m-0">
                    ₦{{ number_format($vaultBalance, 2) }}
                </p>
            </div>

            {{-- Bank Balances --}}
            @php
                $colors = [
                    '#ff7e5f,#feb47b',  // orange-pink
                    '#6a11cb,#2575fc',  // purple-blue
                    '#00c6ff,#0072ff',  // blue gradients
                    '#43cea2,#185a9d',  // teal-blue
                    '#f7971e,#ffd200',  // orange-yellow
                ];
            @endphp

            @forelse ($bankBalances as $bank => $balance)
                @php $color = $colors[$loop->index % count($colors)]; @endphp
                <div class="mb-4 p-3 text-white rounded shadow-sm" style="background: linear-gradient(135deg, {{ $color }});">
                    <h5 class="mb-1">🏦 {{ ucfirst($bank) }} Bank</h5>
                    <p class="fw-bold display-6 m-0">
                        ₦{{ number_format($balance, 2) }}
                    </p>
                </div>
            @empty
                <div class="alert alert-warning">
                    No bank balances available. Please set banks in preferences.
                </div>
            @endforelse

        </div>
    </div>
</div>
@endsection
