<div class="col-lg-12">
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header" style="background:#008B8B; color:#ffff;">
                    <h4 style="float:left"> PAYMENT</h4>
                </div>
              
             <div class="card-body">
                    <form wire:submit.prevent="addSelectedProductToCart">
                        <div class="form-group my-2">
                            <select wire:model="selectedProductId" class="form-control" 
                                    onkeydown="if(event.key === 'Enter') { event.preventDefault(); this.form.dispatchEvent(new Event('submit')); }">
                                <option value="">-- Select Product --</option>
                                @foreach ($products as $product)
                                    <option value="{{ $product->id }}">{{ $product->product_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <button type="submit" style="background:#008B8B; color:#fff;" class="btn btn">Add to Cart</button>
                    </form>
                    
                    @if ($message)
                        <div class="alert alert-info mt-2">{{ $message }}</div>
                    @endif
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Product Name</th>
                                <th>Quantity</th>
                                <th>Price</th>
                                <th>Discount(%)</th>
                                <th>Total</th>
                                <th>Action</th>
                                <th><a href="#" class="btn btn-sm btn-success add_more"><i class="fa fa-plus-circle"></i></a></th>
                            </tr>
                        </thead>
                        <tbody class="addMoreProduct">
                            @foreach($orderItems as $index => $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>
                                    <input type="text" value="{{ optional(\App\Models\Products::find($item['product_id']))->product_name ?? 'Select a product' }}" name="product_name" class="form-control" readonly>
                                </td>
                                <td width="15%">
                                    <div class="d-flex align-items-center justify-content-between">
                                        <button class="btn btn-sm btn-success quantity-btn" wire:click.prevent="IncreamentQty({{ $index }})">+</button>
                                        <label for="" class="mx-2">{{ $item['quantity'] ?? 0 }}</label>
                                        <button class="btn btn-sm btn-danger quantity-btn" wire:click.prevent="DecrementQty({{ $index }})">-</button>
                                    </div>
                                </td>
                                <td>
                                    <input type="number" name="selling_price[]" wire:model.lazy="orderItems.{{ $index }}.selling_price" class="form-control" readonly />
                                </td>
                                <td>
                                    <input type="number" name="discount[]" wire:model.lazy="orderItems.{{ $index }}.discount" class="form-control" />
                                </td>
                                <td>
                                    <input type="number" name="total_amount" value="{{ $item['total_amount'] }}" class="form-control" readonly />
                                </td>
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
                <div class="card-header" style="background:#008B8B; color:#ffff;">
                    <h1>Total <b class="total">{{ collect($orderItems)->sum('total_amount') }}</b></h1>
                </div>
                <form action="{{ route('orders.store') }}" method="POST">
                    @csrf
                    @foreach($orderItems as $index => $item)
                        <div class="row mb-3">
                            <input type="hidden" value="{{ optional(\App\Models\Products::find($item['product_id']))->id }}" name="product_id[]"> 
                            <input type="hidden" value="{{ $item['quantity'] }}" name="quantity[]">
                            <input type="hidden" value="{{ $item['selling_price'] }}" name="selling_price[]">
                        </div>
                    @endforeach
                
                    <div class="card-body" style="text-align: center;">
                        <div class="btn-group mb-3" style="display: inline-block;">
                            <button type="button" onclick="PrintReceiptContent('print')" class="btn btn-dark">
                                <i class="fa fa-print"></i> Print
                            </button>
                            <button type="button" onclick="PrintTransactionHistory()" class="btn btn-primary">
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
                                            <input type="text" name="customer_name" class="form-control" required>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group">
                                            <label for="customer_phone">Customer Phone</label>
                                            <input type="number" name="customer_phone" class="form-control" required>
                                        </div>
                                    </td>
                                </tr>
                            </table>
                
                            <!-- Payment Section -->
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
                            </div>
                
                            <div class="payment-field" style="display: inline-block; width: 100%;">
                                <label for="paid_amount">Payment</label>
                                <input type="number" name="paid_amount" wire:model="pay_money" id="paid_amount" class="form-control">
                            </div>
                            <label for="balance">Returning Change</label>
                            <input type="number" wire:model="balance" readonly name="balance" id="balance" class="form-control">
                        </div>
                    </div> 

                    <!-- Action Buttons -->
                    <div style="display: inline-block; width: 100%;">
                        <button type="submit" class="btn btn-primary btn-lg btn-block mb-2">Save</button>
                        <button type="button" class="btn btn-danger btn-lg btn-block">Calculate</button>
                    </div>
                
                    <div class="text-center mt-3" style="display: inline-block; width: 100%;">
                        <a href="#" class="text-danger"><i class="fa fa-sign-out-alt"></i></a>
                    </div>
                </form>
                
                <div class="modal">
                    <div id="print">
                        @include('reports.receipt')
                    </div>  
                </div>
            </div>
        </div>
    </div>
</div>



<style>

.card {
    box-shadow: 0 4px 8px rgba(0, 0, 0, 10); /* Box shadow effect */
    transition: box-shadow 0.3s ease; /* Smooth transition for hover effect */
    outline: none; /* Remove outline */
    border-radius: 5px;
}
.card-header {
    box-shadow: 0 4px 8px rgba(20, 20, 20, 0.9); /* Box shadow effect */
    transition: box-shadow 0.3s ease; /* Smooth transition for hover effect */
    outline: none; /* Remove outline */
    border-radius: 20px;
}

.card:hover {
    box-shadow: 0 8px 16px rgba(0, 0, 0, 0.9); /* Enhanced shadow on hover */
}



.quantity-btn {
    display: flex; /* Use flexbox for centering */
    align-items: center; /* Center vertically */
    justify-content: center; /* Center horizontally */
    width: 30px; /* Set button width */
    height: 30px; /* Set button height */
    font-size: 18px; /* Increase font size */
    border: none; /* Remove border */
    color: #fff; /* Text color */
    background-color: inherit; /* Keep background color same as parent */
    transition: background-color 0.3s; /* Smooth transition for background color */
    cursor: pointer; /* Change cursor to pointer on hover */
}

.quantity-btn:hover {
    opacity: 0.8; /* Add hover effect */
}

.btn-success {
    background-color: #28a745; /* Green background */
}

.btn-danger {
    background-color: #dc3545; /* Red background */
}

.btn-success:hover {
    background-color: #218838; /* Darker green on hover */
}

.btn-danger:hover {
    background-color: #c82333; /* Darker red on hover */
}

/* Flexbox styles for alignment */
.d-flex {
    display: flex;
}

.align-items-center {
    align-items: center;
}

.justify-content-between {
    justify-content: space-between;
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
    </script>