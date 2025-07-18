<!DOCTYPE html>
<html>

<head>
    <style>
        body {
            font-family: monospace;
            font-size: 12px;
            width: 58mm;
            margin: 0 auto;
            background-color: #fff;
        }

        .center {
            text-align: center;
        }

        .receipt {
            padding: 10px;
        }

        img.logo {
            max-width: 50px;
            max-height: 50px;
            margin-bottom: 5px;
        }

        h2 {
            font-size: 14px;
            margin: 2px 0;
        }

        p {
            margin: 2px 0;
            font-size: 11px;
        }

        .item,
        .total {
            display: flex;
            justify-content: space-between;
            margin-bottom: 2px;
            font-size: 11px;
        }

        hr {
            border: none;
            border-top: 1px dashed #000;
            margin: 6px 0;
        }

        .bold {
            font-weight: bold;
        }

        .thankyou {
            margin-top: 8px;
            font-size: 11px;
        }

        .footer {
            margin-top: 6px;
            text-align: center;
            font-size: 10px;
            color: #555;
        }
    </style>
</head>

<body>
    <div class="receipt">
        <!-- Header -->
        <div class="center">
            {{-- @if (!empty($preferences['business_logo']))
            <img src="{{ asset('storage/' . ltrim($preferences['business_logo'], '/')) }}" alt="Logo" style="max-height: 60px; margin-top: 10px;">
        @endif
         --}}


            <hr>
            <h2>{{ getPreference('business_name', 'My Business') }}</h2>
            <hr>
            <p>{{ getPreference('office_address', 'No Address Provided') }}</p>
            <p>{{ now()->format('Y-m-d H:i') }}</p>

        </div>

        <!-- Items -->
        @foreach ($orderItems as $item)
            <div class="item">
                <span>{{ $item['product_name'] }} x{{ $item['quantity'] }}</span>
                <span>₦{{ number_format((float) $item['total_amount'], 1) }}</span>
            </div>
        @endforeach

        <hr>

        <!-- Totals -->
        <div class="total">
            <span>Total:</span>
            <span>₦{{ number_format((float) collect($orderItems)->sum('total_amount'), 1) }}</span>
        </div>

        <div class="total">
            <span>Paid:</span>
            <span>₦{{ number_format((float) $pay_money, 1) }}</span>
        </div>

        <div class="total">
            <span>Change:</span>
            <span>
                ₦{{ number_format((float) collect($orderItems)->sum('total_amount') - (float) $pay_money, 1) }}
            </span>
        </div>


        <hr>

        <!-- Footer -->
        <div class="center thankyou">
            <p>Thank you for your purchase!</p>
        </div>

        <div class="footer">
            Receipt printed by {{ getPreference('business_name', 'POS System') }}
        </div>
    </div>
</body>

</html>
