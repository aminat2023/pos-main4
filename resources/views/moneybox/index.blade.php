@extends('layouts.app')

@section('content')
<div class="container">
    <h4 class="mb-4 text-center text-white" style="font: 900; font-size: 2rem;">💰 Money Box Balances</h4>

    {{-- TOTAL BALANCE --}}
    @php
        $totalBankBalance = array_sum($bankBalances);
        $grandTotal = $vaultBalance + $totalBankBalance;
    @endphp

    <div class="alert alert-info text-center fw-bold fs-5 shadow-sm">
        🧾 Total Available Balance: <span class="text-success">₦{{ number_format($grandTotal, 2) }}</span>
    </div>

    <div class="card mx-auto shadow" style="max-width: 500px; border-radius: 16px;">
        <div class="card-body p-4">

            {{-- Vault Balance --}}
            <a href="{{ route('vault.report') }}" class="text-decoration-none">
                <div class="mb-4 p-3 text-white rounded shadow-sm" style="background: linear-gradient(135deg, #1e3c72, #2a5298);">
                    <h5 class="mb-1">💼 Vault (Cash)</h5>
                    <p class="fw-bold display-6 m-0">₦{{ number_format($vaultBalance, 2) }}</p>
                </div>
            </a>

            {{-- Bank Balances --}}
            @php
                $colors = [
                    '#ff7e5f,#feb47b',
                    '#6a11cb,#2575fc',
                    '#00c6ff,#0072ff',
                    '#43cea2,#185a9d',
                    '#f7971e,#ffd200',
                ];

                $icons = [
                    'opal' => '💎',
                    'palmpay' => '🌴',
                    'gtbank' => '🏦',
                    'access' => '🔐',
                    'kuda' => '💜',
                    'moniepoint' => '📲',
                    'zenith' => '🏛️',
                    'uba' => '💳',
                    'fidelity' => '🔵',
                    'firstbank' => '👑',
                    'wema' => '💟',
                    'providus' => '💰',
                ];
            @endphp

            @forelse ($bankBalances as $bank => $balance)
                @php
                    $color = $colors[$loop->index % count($colors)];
                    $icon = $icons[strtolower($bank)] ?? '🏦';
                    $formattedBank = ucwords(str_replace('_', ' ', $bank));
                @endphp

                <a href="{{ route('journal.ledger', ['account' => 'bank', 'bank_name' => $bank]) }}" class="text-decoration-none">
                    <div class="mb-4 p-3 text-white rounded shadow-sm" style="background: linear-gradient(135deg, {{ $color }});">
                        <h5 class="mb-1">{{ $icon }} {{ $formattedBank }} Bank</h5>
                        <p class="fw-bold display-6 m-0">₦{{ number_format($balance, 2) }}</p>
                    </div>
                </a>
            @empty
                <div class="alert alert-warning">
                    No bank balances available. Please set banks in preferences.
                </div>
            @endforelse

        </div>
    </div>
</div>
@endsection
