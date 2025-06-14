<div id="invoice_pos">
    <div id="top">
        <div class="logo">PM</div>
        <h2>PM POS</h2>
    </div>

    <div id="mid">
        <div class="info">
            <h2>Contact Us</h2>
            <p>
                Address: Baale Animashaun Road, Alakuko<br />
                Email: hamzat@gmail.com<br />
                Phone: +2348115708692
            </p>
        </div>
    </div>

    <div id="bot">
        <div class="table">
            <table>
                <thead>
                    <tr class="table_title">
                        <td class="item"><h2>Item</h2></td>
                        <td class="hours"><h2>QTY</h2></td>
                        <td class="rate"><h2>Unit</h2></td>
                        <td class="rate"><h2>Disc</h2></td>
                        <td class="rate"><h2>Subtotal</h2></td>
                    </tr>
                </thead>
                <tbody>
                    @if(session('lastTransaction'))
                        @foreach(session('lastTransaction')->order->orderDetails as $detail)
                            <tr class="service">
                                <td><p class="itemtext">{{ $detail->product->product_name }}</p></td>
                                <td><p class="itemtext">{{ $detail->quantity }}</p></td>
                                <td class="rate">
                                    <p class="itemtext">&#8358;{{ number_format($detail->unit_price, 2) }}</p>
                                </td>
                                <td class="rate">
                                    <p class="itemtext">&#8358;{{ number_format($detail->discount, 2) }}</p>
                                </td>
                                <td class="rate">
                                    <p class="itemtext">&#8358;{{ number_format($detail->amount, 2) }}</p>
                                </td>
                            </tr>
                        @endforeach

                        <tr class="table_title">
                            <td colspan="3"></td>
                            <td class="rate">Total</td>
                            <td class="payment">
                                <h2>
                                    <p class="itemtext">&#8358;{{ number_format(session('lastTransaction')->transaction_amount, 2) }}</p>
                                </h2>
                            </td>
                        </tr>

                        <!-- Payment Section -->
                        <tr class="table_title">
                            <td colspan="3"></td>
                            <td class="rate">Payment</td>
                            <td class="payment">
                                <h2>
                                    <p class="itemtext">&#8358;{{ number_format(optional(session('lastTransaction'))->payment_amount, 2) }}</p>
                                </h2>
                            </td>
                        </tr>

                        <!-- Remaining Balance Section -->
                        <tr class="table_title">
                            <td colspan="3"></td>
                            <td class="rate">Remaining Balance</td>
                            <td class="payment">
                                <h2>
                                    <p class="itemtext">&#8358;{{ number_format(optional(session('lastTransaction'))->payment_amount - session('lastTransaction')->transaction_amount, 2) }}</p>
                                </h2>
                            </td>
                        </tr>
                    @else
                        <tr>
                            <td colspan="5" class="text-center">No transaction data available.</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>

        <div id="legalcopy">
            <p>
                <strong>**** Thank you for visiting ****</strong><br />
                The goods are subject to prices and tax.
            </p>
        </div>

        <div class="serial-number">
            Serial: <span class="serial">{{ optional(session('lastTransaction'))->id }}</span><br />
        </div>
    </div>
</div>

<style>
    @import url("https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap");

    body {
        font-family: "Roboto", sans-serif;
        background: #f4f4f4;
        padding: 10px;
    }

    #invoice_pos {
        width: 58mm;
        background: #f1eaea;
        padding: 10px;
        margin: 0 auto;
        border-radius: 8px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.3);
    }
    #top {
        text-align: center;
        margin-bottom: 10px;
    }

    .logo {
        font-weight: bold;
        font-size: 24px;
        color: #fff;
        background-color: #007bff;
        width: 50px;
        height: 50px;
        margin: 0 auto 5px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    h2,
    h3 {
        margin: 4px 0;
        color: #222;
    }

    p {
        margin: 2px 0;
        font-size: 11px;
        color: #555;
    }

    .info h2 {
        font-size: 13px;
        margin-bottom: 4px;
    }

    .info p {
        font-size: 10px;
    }

    .table {
        width: 100%;
        margin-top: 10px;
    }

    table {
        width: 100%;
        font-size: 10px;
        border-collapse: collapse;
    }

    .table_title {
        color: #fff;
        display: table-row;
        width: 50%;
        box-sizing: border-box;
    }

    .table_title h2 {
        font-size: 10px;
        margin: 2px;
    }

    td {
        padding: 4px 2px;
        border-bottom: 1px solid #ddd;
    }

    .itemtext {
        font-size: 10px;
        color: #333;
    }

    #legalcopy {
        text-align: center;
        margin-top: 10px;
        font-size: 10px;
        color: #666;
    }

    .serial-number {
        margin-top: 10px;
        text-align: center;
        font-size: 9px;
        color: #888;
    }

    .serial {
        font-weight: bold;
    }

    .text-center {
        text-align: center;
    }

    .rate,
    .hours,
    .payment {
        text-align: right;
    }

    .rate h2,
    .payment h2 {
        margin: 0;
        font-size: 10px;
    }
</style>
