@extends('layouts.buyer.buyermaster')

@section('content')

<div class="content">
    <div class="container">
        <div class="row align-items-center mt-4">
            <div class="col-md-4 col-4">
                <a href="{{ route('shops.list') }}" class="text-secondary text-decoration-none"><i class="fa fa-angle-left"></i> Continue Shopping</a>
            </div>
            <div class="col-md-4 col-4 text-center">
                <h3 class="py-3">Cart ni Klasmeyt</h3>
            </div>
            <div class="col-md-4 col-4"></div>
            <hr class="shadow">
        </div>

        @if($orders->isEmpty())
        <div class="cart-wrapper text-center pt-5">
            <h3>Your cart is empty.</h3>
        </div>

        @else
        <div class="accordion" id="shopAccordion">
            @foreach($groupedOrders as $shopId => $orders)
            <div class="cart-wrapper" data-shop-id="{{ $shopId }}">
                <div class="d-flex justify-content-between align-items-center" data-bs-toggle="collapse" data-bs-target="#collapseShop{{ $shopId }}" role="button" aria-expanded="false" aria-controls="collapseShop{{ $shopId }}">
                    <div class="p-3">
                        <h5 class="m-0">{{ $orders->first()->shop_name }}</h5>
                        <span>{{ $orders->first()->designated_canteen }}</span>
                    </div>
                    <div class="p-3 d-flex align-items-center total-item-perShop" data-total-item="{{ count($orders) }}">
                        {{ count($orders) }} {{ count($orders) > 1 ? 'Items' : 'Item' }}
                        <div class="ms-3">
                            <form action="{{ route('remove.items', $shopId) }}" class="remove-shop-form" data-shop-id="{{ $shopId }}">
                                @csrf
                                @method('DELETE')
                                <button type="button" class="btn btn-outline-danger btn-sm remove-shop-btn">
                                    <i class="bi bi-trash3"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                <hr>
            </div>

            <div class="cart-wrapper collapse" id="collapseShop{{ $shopId }}" data-bs-parent="#shopAccordion">
                <div class="table-responsive">
                    <table id="cart" class="table table-hover">
                        <thead class="bg-light">
                            <tr>
                                <th style="width:50%">Product</th>
                                <th style="width:10%" class="text-center">Price</th>
                                <th style="width:10%" class="text-center">Quantity</th>
                                <th style="width:10%" class="text-center">Subtotal</th>
                                <th style="width:10%" class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody class="borderless">
                            @php $shopTotal = 0; @endphp
                            @foreach($orders as $order)
                            @php $shopTotal += $order->total; @endphp
                            <tr>
                                <td class="align-middle">
                                    <div class="d-flex align-items-center">
                                        <img src="{{ asset('storage/products/' . $order->image) }}" alt="{{ $order->name }}" class="img-fluid rounded" style="height: 100px; width: 100px; object-fit: cover; margin-right: 20px;">
                                        <div>
                                            <h6 class="mb-1 text-uppercase">{{ $order->product_name }}</h6>
                                            <small class="text-muted text-uppercase">{{ $order->type_name }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td class="text-center align-middle">₱{{ number_format($order->price, 2) }}</td>
                                <td class="text-center align-middle">
                                    <form action="{{ route('update.quantity', $order->id) }}" method="POST" class="d-flex justify-content-center align-items-center">
                                        @csrf
                                        @method('PATCH')
                                        <button type="button" class="btn btn-outline-danger btn-sm btn-decrease-cart">_</button>
                                        <input type="text" name="product_qty" class="form-control mx-2 text-center qty-input-cart" readonly style="width: 50px;" value="{{ $order->quantity }}" max="10">
                                        <button type="button" class="btn btn-outline-success btn-sm btn-increase-cart">+</button>
                                    </form>
                                </td>
                                <td class="text-center align-middle subtotal">₱{{ number_format($order->total, 2) }}</td>
                                <td class="text-center align-middle">
                                    <form action="{{ route('remove.item', $order->id) }}" class="remove-item-form" data-item-id="{{ $order->id }}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="btn btn-outline-danger btn-sm remove-item-btn">
                                            <i class="bi bi-trash3"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="d-flex justify-content-end my-4">
                    <div class="d-flex align-items-center">
                        <h5 class="mx-2 mb-0"><strong>Total: <span class="overall-total">₱170.00</span></strong></h5>
                        <a href="{{ route('checkout.orders', ['shopId' => Crypt::encrypt($shopId)]) }}" class="btn btn-success"><i class="fa fa-shopping-cart"></i> Checkout</a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        @endif
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Handle item removal using AJAX
        document.querySelectorAll('.remove-item-btn').forEach(function(button) {
            button.addEventListener('click', function(event) {
                event.preventDefault(); // Prevent the default form submission

                const form = button.closest('form');
                const itemId = form.getAttribute('data-item-id');

                const noItemPerShop = document.querySelector('.total-item-perShop');
                let totalItems = parseInt(noItemPerShop.getAttribute('data-total-item'));

                fetch(form.getAttribute('action'), {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        },
                    })
                    .then((response) => response.json())
                    .then((data) => {
                        if (data.success) {
                            button.closest('tr').remove();

                            totalItems -= 1;
                            noItemPerShop.setAttribute('data-total-item', totalItems);

                            const shopWrapper = form.closest(`.cart-wrapper`);
                            const itemsPerShop = document.querySelector(`#collapseShop${shopWrapper.getAttribute('data-shop-id')}`);

                            if (totalItems < 1) {
                                shopWrapper.remove();
                                itemsPerShop.remove();
                            } else {
                                recalculateShopTotal(button);
                            }
                        }
                    });
            });
        });

        // Handle shop removal
        document.querySelectorAll('.remove-shop-btn').forEach(function(button) {
            button.addEventListener('click', function(event) {
                event.preventDefault();

                const form = button.closest('form');
                const shopId = form.getAttribute('data-shop-id');

                fetch(form.getAttribute('action'), {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        },
                    })
                    .then((response) => response.json())
                    .then((data) => {
                        if (data.success) {
                            const shopWrapper = document.querySelector(`.cart-wrapper[data-shop-id="${shopId}"]`);
                            const itemsPerShop = document.querySelector(`#collapseShop${shopId}`);

                            if (shopWrapper) {
                                shopWrapper.remove();
                                itemsPerShop.remove();
                            }
                        }
                    });
            });
        });

        // Recalculate shop total after an item is removed
        function recalculateShopTotal(button) {
            let shopTotal = 0;
            const shopSection = button.closest('.collapse');

            shopSection.querySelectorAll('.subtotal').forEach(function(subtotalElement) {
                let subtotal = parseFloat(subtotalElement.textContent.replace(/[₱,]/g, ''));
                shopTotal += subtotal;
            });

            // Update the shop total on the page
            shopSection.querySelector('.shop-total').textContent = '₱' + shopTotal.toFixed(2);
        }

        // Handle quantity increase and decrease
        document.querySelectorAll('.btn-increase-cart, .btn-decrease-cart').forEach(function(button) {
            button.addEventListener('click', function() {
                const change = button.classList.contains('btn-increase-cart') ? 1 : -1;
                updateQuantity(button, change);
            });
        });

        function updateQuantity(button, change) {
            const form = button.closest('form');
            const qtyInput = form.querySelector('.qty-input-cart');
            let newQty = parseInt(qtyInput.value) + change;

            if (newQty > 0 && newQty <= 10) {
                qtyInput.value = newQty;

                const url = form.getAttribute('action');
                const formData = new FormData(form);
                formData.set('product_qty', newQty);

                fetch(url, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        },
                        body: formData,
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            // Update the subtotal for this row
                            const subtotalElement = button.closest('tr').querySelector('.subtotal');
                            subtotalElement.textContent = '₱' + data.newSubtotal.toFixed(2);

                            // Recalculate the shop total after the quantity is changed
                            recalculateShopTotal(button);
                        }
                    });
            }
        }
    });
</script>
@endsection