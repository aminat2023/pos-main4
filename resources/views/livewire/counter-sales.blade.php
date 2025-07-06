<div class="container-fuild">
    <div class="col-lg-12">
        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center"
                        style="background:#008B8B; color:#ffff;">
                        <h4 class="mb-0">CASHIER</h4>

                        <div>
                            <div>
                                <h5 class="mb-0" style="font-weight: bold;">
                                    TILL: ₦{{ number_format($this->tillTotal, 2) }}
                                </h5>
                                <h5 class="mb-0" style="font-weight: bold;">
                                    BANK: ₦{{ number_format($this->bankTotal, 2) }}
                                </h5>
                            </div>

                        </div>
                    </div>

                    <div class="card-body">
                        <form wire:submit.prevent="addSelectedProductToCart">
                            <div class="form-group my-2">
                                <select wire:model="selectedProductId" class="form-control">
                                    <option value="">-- Select Product --</option>
                                    @foreach ($products as $product)
                                        <option value="{{ $product->id }}">{{ $product->product_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </form>

                        @if ($message)
                            <div class="alert alert-info mt-2">{{ $message }}</div>
                        @endif
                        <table class="table table-bordered table-hover table-sm m-0">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Product Name</th>
                                    <th>Quantity</th>
                                    <th>Total Stock</th> {{-- New Column --}}
                                    <th>Price</th>
                                    <th>Discount(%)</th>
                                    <th>Total</th>
                                    <th>Action</th>
                                    <th>
                                        {{-- <a href="#" class="btn btn-sm btn-success add_more" wire:click="add_moreRow">
                                        <i class="fa fa-plus-circle"></i>
                                       </a>
                                        
                                        </th> --}}
                                </tr>
                            </thead>
                            <tbody class="addMoreProduct">
                                @foreach ($orderItems as $index => $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>

                                        <td>{{ $item['product_name'] }}</td>

                                        <td width="15%">
                                            <div class="d-flex align-items-center justify-content-between">
                                                <button class="btn btn-sm btn-success quantity-btn"
                                                    wire:click.prevent="incrementQty({{ $index }})"
                                                    @if ($item['quantity'] >= $item['max_quantity']) disabled @endif>
                                                    +
                                                </button>

                                                <label for=""
                                                    class="mx-2">{{ $item['quantity'] ?? 0 }}</label>
                                                <button class="btn btn-sm btn-danger quantity-btn"
                                                    wire:click.prevent="decrementQty({{ $index }})">-</button>
                                            </div>

                                        </td>
                                        <td>
                                            <input type="number" name="selling_price[]"
                                                wire:model.lazy="orderItems.{{ $index }}.selling_price"
                                                class="form-control" readonly />
                                        </td>
                                        <td>
                                            <input type="number" name="discount[]"
                                                wire:model.lazy="orderItems.{{ $index }}.discount"
                                                class="form-control" />
                                        </td>
                                        <td>
                                            <input type="number" name="total_amount"
                                                value="{{ $item['total_amount'] }}" class="form-control" readonly />
                                        </td>
                                        <td>
                                            <button type="button" class="btn btn-sm btn-danger"
                                                wire:click="removeRow({{ $index }})">
                                                <i class="fa fa-times-circle"></i>
                                            </button>
                                        </td>
                                        <td>
                                            <small class="text-muted">{{ $item['total_stock'] ?? 0 }}</small>
                                        </td>

                                    </tr>
                                @endforeach
                            </tbody>

                        </table>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card">
                    <div class="card-header" style="background:#008B8B; color:#ffff;">
                        <h1>Total <b class="total">{{ collect($orderItems)->sum('total_amount') }}</b></h1>
                    </div>
                    <form action="{{ route('counter_sales.store') }}" method="POST">
                        @csrf
                        @foreach ($orderItems as $index => $item)
                            <div class="row mb-3">
                                <input type="hidden"
                                    value="{{ optional(\App\Models\Products::find($item['product_id']))->id }}"
                                    name="product_id[]">
                                <input type="hidden" value="{{ $item['quantity'] }}" name="quantity[]">
                                <input type="hidden" value="{{ $item['selling_price'] }}" name="selling_price[]">
                            </div>
                        @endforeach

                        <div class="card-body" style="text-align: center;">
                            <div class="btn-group mb-3" style="display: inline-block;">
                                <button type="button" onclick="PrintReceiptContent('print')" class="btn btn-dark">
                                    <i class="fa fa-print"></i> Print
                                </button>
                                <button type="button" onclick="showReceiptHistoryModal()" class="btn btn-primary">
                                    <i class="fa fa-history"></i> History
                                </button>
                                <button type="button" class="btn btn-danger">
                                    <i class="fa fa-chart-line"></i> Report
                                </button>
                            </div>

                            <!-- Customer Information -->
                            <div class="panel" style="display: inline-block; text-align: left;">
                                <table class="table" style="display: inline-block;">
                                    <tr>
                                        <td>
                                            <div class="form-group">
                                                <label for="customer_name">Customer Name</label>
                                                <input type="text" name="customer_name" class="form-control"
                                                    required>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-group">
                                                <label for="customer_phone">Customer Phone</label>
                                                <input type="number" name="customer_phone" class="form-control"
                                                    required>
                                            </div>
                                        </td>
                                    </tr>
                                </table>

                                <!-- Payment Section -->
                                <div class="payment-section" style="display: inline-block; text-align: left;">
                                    <h5>Payment</h5>

                                    <!-- Cash -->
                                    <div class="radio-item">
                                        <input type="radio" id="payment_method_cash" value="cash"
                                            wire:model="payment_method">
                                        <label for="payment_method_cash">
                                            <i class="fa fa-money-bill text-success"></i> Cash
                                        </label>
                                    </div>

                                    <!-- Bank Transfer -->
                                    <div class="radio-item">
                                        <input type="radio" id="payment_method_bank" value="bank_transfer"
                                            wire:model="payment_method">
                                        <label for="payment_method_bank">
                                            <i class="fa fa-university text-danger"></i> Bank Transfer
                                        </label>

                                        {{-- Show select only when bank_transfer is selected --}}
                                        @if ($payment_method === 'bank_transfer')
                                            <select id="bank_select" wire:model="selected_bank"
                                                class="form-control mt-2">
                                                <option value="">Select a bank</option>
                                                @php
                                                $banks = getPreference('banks', []); @endphp
                                                @foreach ($banks as $bank)
                                                    <option value="{{ $bank }}">{{ $bank }}</option>
                                                @endforeach
                                            </select>
                                        @endif
                                    </div>

                                    <!-- Credit Card -->
                                    <div class="radio-item">
                                        <input type="radio" id="payment_method_card" value="credit_card"
                                            wire:model="payment_method">
                                        <label for="payment_method_card">
                                            <i class="fa fa-credit-card text-success"></i> Credit Card
                                        </label>
                                    </div>
                                </div>


                                <div class="payment-field" style="display: inline-block; width: 100%;">
                                    <label for="paid_amount">Payment</label>
                                    <input type="number" name="paid_amount" wire:model="pay_money" id="paid_amount"
                                        class="form-control">
                                </div>
                                <label for="balance">Returning Change</label>
                                <input type="number" wire:model="balance" readonly name="balance" id="balance"
                                    class="form-control">
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div style="display: inline-block; width: 100%;">
                            @if ($errorMessage)
                                <div class="alert alert-danger">
                                    {{ $errorMessage }}
                                </div>
                            @endif
                            <button wire:click.prevent="save" onclick="if (!preventUnderpayment()) return false;"
                                class="btn btn-primary btn-lg btn-block mb-2">Save</button>

                            <button type="button" class="btn btn-danger btn-lg btn-block">Calculate</button>
                        </div>
                        <div>


                            <div class="text-center mt-3" style="display: inline-block; width: 100%;">
                                <a href="#" class="text-danger"><i class="fa fa-sign-out-alt"></i></a>
                            </div>
                    </form>

                    <div class="modal">
                        <div id="print">
                            @includeIf('receipts.' . $receiptTemplate, [
                                'orderItems' => $lastReceiptItems,
                                'pay_money' => $lastPaymentAmount,
                                'balance' => $lastChange,
                            ]);

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- All Receipts History Modal -->
    <div class="modal fade" id="receiptHistoryModal" tabindex="-1" role="dialog"
        aria-labelledby="receiptHistoryModalLabel" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content" style="border-radius: 8px;">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="receiptHistoryModalLabel">Transaction History</h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close"
                        style="font-size: 1.5rem;">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <div class="row">
                        <!-- Left: Recent Receipts List -->
                        <div class="col-md-5" style="max-height: 500px; overflow-y: auto;">
                            <h6 class="text-muted">Recent Receipts</h6>
                            <ul class="list-group">
                                @foreach ($recentReceipts as $receipt)
                                    <li class="list-group-item list-group-item-action"
                                        wire:click="showReceiptDetails({{ $receipt['id'] }})"
                                        style="cursor: pointer;">
                                        <strong>#{{ $receipt['id'] }}</strong> |
                                        ₦{{ number_format($receipt['paid_amount'], 2) }} |
                                        {{ \Carbon\Carbon::parse($receipt['created_at'])->format('d M Y, h:i A') }}
                                    </li>
                                @endforeach
                            </ul>
                        </div>

                        <!-- Right: Selected Receipt Detail -->
                        <div class="col-md-7">
                            @if ($selectedReceiptItems && count($selectedReceiptItems))
                                <h6>Receipt Details</h6>
                                <table class="table table-sm table-bordered">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Product</th>
                                            <th>Qty</th>
                                            <th>Price</th>
                                            <th>Discount</th>
                                            <th>Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($selectedReceiptItems as $item)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $item['product_name'] }}</td>
                                                <td>{{ $item['quantity'] }}</td>
                                                <td>₦{{ number_format($item['selling_price'], 2) }}</td>
                                                <td>{{ $item['discount'] }}%</td>
                                                <td>₦{{ number_format($item['total_amount'], 2) }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                <p><strong>Amount Paid:</strong> ₦{{ number_format($selectedReceiptAmount, 2) }}</p>
                                <p><strong>Change Returned:</strong> ₦{{ number_format($selectedReceiptChange, 2) }}
                                </p>
                            @else
                                <p>Select a receipt to view details.</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .card {
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        transition: box-shadow 0.3s ease;
        border-radius: 6px;
        margin-bottom: 20px;
        border: none;
    }

    .card:hover {
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.15);
    }

    .card-header {
        background-color: #008B8B;
        color: #ffffff;
        font-weight: bold;
        border-radius: 6px 6px 0 0;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        padding: 1rem 1.25rem;
    }

    .table-responsive {
        overflow-x: auto;
    }

    .table th,
    .table td {
        vertical-align: middle;
        white-space: nowrap;
    }

    .quantity-btn {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 32px;
        height: 32px;
        font-size: 18px;
        border: none;
        color: #fff;
        background-color: #008B8B;
        border-radius: 4px;
        transition: background-color 0.3s;
        cursor: pointer;
    }

    .quantity-btn:hover {
        opacity: 0.85;
    }

    .btn-success {
        background-color: #28a745;
    }

    .btn-success:hover {
        background-color: #218838;
    }

    .btn-danger {
        background-color: #dc3545;
    }

    .btn-danger:hover {
        background-color: #c82333;
    }

    .btn-group .btn {
        margin-right: 4px;
    }

    .total {
        font-size: 26px;
        font-weight: bold;
        color: #ffffff;
    }

    .form-control {
        font-size: 14px;
    }

    .radio-item {
        display: inline-block;
        margin-right: 15px;
    }

    .modal-content {
        border-radius: 8px;
    }

    @media (max-width: 768px) {

        .card-header h4,
        .card-header h5,
        .total {
            font-size: 18px;
        }

        .btn {
            font-size: 12px;
            padding: 6px 10px;
        }

        .form-control {
            font-size: 13px;
        }

        .table th,
        .table td {
            font-size: 12px;
            padding: 0.4rem;
        }

        .quantity-btn {
            width: 28px;
            height: 28px;
            font-size: 16px;
        }
    }
</style>


<script>
    function PrintReceiptContent(el) {
        var buttonHTML = `
            <button id="printPageButton"
                    style="display:block; width:100%; border:none; background-color:#008b8b; color:#fff; padding:14px 28px; font-size:16px; cursor:pointer; text-align:center;"
                    onclick="window.print()">
                Print Receipt
            </button>
        `;

        var content = document.getElementById(el).innerHTML;
        var data = buttonHTML + content;

        // Open a new print window
        var myReceipt = window.open("", "myWin", "left=150,top=130,width=400,height=600");

        myReceipt.document.write('<html><head><title>Print Receipt</title></head><body>');
        myReceipt.document.write(data);
        myReceipt.document.write('</body></html>');
        myReceipt.document.close(); // Important for printing
        myReceipt.focus();

        // Optional: Auto-close after 8 seconds
        setTimeout(() => {
            myReceipt.close();
        }, 8000);
    }
    $(document).on('click', '.add_more', function() {
        alert('1');
    });


    function preventUnderpayment() {
        let total = parseFloat(document.querySelector('.total b').textContent || 0);
        let paid = parseFloat(document.querySelector('#paid_amount').value || 0);

        if (paid < total) {
            alert('Amount paid is less than total. Please enter the full amount.');
            return false;
        }

        return true;
    }

    window.addEventListener('toast', event => {
        Swal.fire({
            toast: true,
            position: 'top-end',
            icon: event.detail.type || 'info',
            title: event.detail.message || 'Action completed',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
        });
    });

    window.addEventListener('printReceipt', () => PrintReceiptContent('print'));

    function PrintReceiptContent(el) {
        const content = document.getElementById(el).innerHTML;
        const btn =
            `<button onclick="window.print()" style="display:block;width:100%;padding:10px;background:#008B8B;color:#fff;border:none;margin-bottom:10px;">Print</button>`;
        const w = window.open('', '_blank', 'width=400,height=600');
        w.document.write(`<html><body>${btn}${content}</body></html>`);
        w.document.close();
        w.focus();
        setTimeout(() => w.close(), 8000);
    }
</script>
