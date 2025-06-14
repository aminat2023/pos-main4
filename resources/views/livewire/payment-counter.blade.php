
<div class="col-lg-12">
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header" style="background:#008B8B; color:#fff;">
                    <h4 style="float:left"> PAYMENT</h4>
                </div>
                <div class="card-body">
                    <form wire:submit.prevent="addSelectedProductToCart">
                        <div class="form-group my-2">
                            <select wire:model="selectedProductId" class="form-control" required>
                                <option value="">-- Select Product --</option>
                                @foreach ($products as $product)
                                    @if ($product->quantity > 0) // Only show products with available stock
                                        <option value="{{ $product->product_code }}">
                                            {{ $product->product_name }} (Available: {{ $product->quantity }})
                                        </option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                
                        @if ($selectedProductId)
                        @php
                            $availableQuantity = $this->calculateTotalQuantity($selectedProductId);
                            $cartQuantity = collect($orderItems)->where('product_code', $selectedProductId)->sum('quantity');
                        @endphp
                        <div>
                            Total Quantity: {{ $availableQuantity }}
                        </div>
                        @if ($cartQuantity >= $availableQuantity)
                            <div class="alert alert-danger mt-2">
                                Error: You cannot add more than the available stock ({{ $availableQuantity }}) to the cart.
                            </div>
                        @endif
                    @endif
                        <button type="submit" class="btn btn-primary">Add to Cart</button>
                    </form>
             
                    @if ($message)
                        <div class="alert alert-info mt-2">{{ $message }}</div>
                    @endif

                    <table class="table table-bordered mt-3">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Product Name</th>
                                <th>Quantity</th>
                                <th>Price</th>
                                <th>Discount(%)</th>
                                <th>Total</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($orderItems as $index => $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $item['product_name'] }}</td>
                                    <td>
                                        <button class="btn btn-sm btn-success" wire:click.prevent="incrementQty({{ $index }})">+</button>
                                        {{ $item['quantity'] }}
                                        <button class="btn btn-sm btn-danger" wire:click.prevent="decrementQty({{ $index }})">-</button>
                                    </td>
                                    <td>{{ number_format($item['selling_price'], 2) }}</td>
                                    <td>
                                        <input type="number" wire:model.lazy="orderItems.{{ $index }}.discount" class="form-control" wire:change="updateTotalAmount({{ $index }})" />
                                    </td>
                                    <td>{{ number_format($item['total_amount'], 2) }}</td>
                                    <td>
                                        <button type="button" class="btn btn-sm btn-danger" wire:click="removeRow({{ $index }})">
                                            <i class="fa fa-times-circle"></i>
                                        </button>
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
                <div class="card-header" style="background:#008B8B; color:#fff;">
                    <h1>Total <b class="total">{{ number_format(collect($orderItems)->sum('total_amount'), 2) }}</b></h1>
                </div>
                <div class="card-body" style="text-align: center;">
                    <div class="payment-section" style="display: inline-block; text-align: left;">
                        <h5>Payment</h5>
                        <div class="radio-item">
                            <input type="radio" id="payment_method_cash" name="payment_method" value="cash" checked>
                            <label for="payment_method_cash"><i class="fa fa-money-bill text-success"></i> Cash</label>
                        </div>
                        <div class="radio-item">
                            <input type="radio" id="payment_method_bank" name="payment_method" value="bank_transfer">
                            <label for="payment_method_bank"><i class="fa fa-university text-danger"></i> Bank Transfer</label>
                        </div>
                        <div class="radio-item">
                            <input type="radio" id="payment_method_card" name="payment_method" value="credit_card">
                            <label for="payment_method_card"><i class="fa fa-credit-card text-success"></i> Credit Card</label>
                        </div>
                        <div class="form-group">
                            <label for="paid_amount">Payment</label>
                            <input type="number" wire:model="pay_money" id="paid_amount" class="form-control" required>
                        </div>
                        <label for="balance">Returning Change</label>
                        <input type="number" wire:model="balance" readonly name="balance" id="balance" class="form-control">
                        <div class="card-footer">
                            <button type="button" class="btn btn-primary btn-lg btn-block mb-2" wire:click.prevent="savePayment">Save</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>