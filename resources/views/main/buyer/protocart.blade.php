<!-- protocart.blade.php -->

@extends('layouts.buyer.buyermaster')

@section('content')
<div class="content">
    <div class="container">
        <div class="row align-items-center mt-4">
            <div class="col-md-4 col-4">
                <a href="{{ route('shops.list') }}" class="continue-shopping text-secondary text-decoration-none">
                    <i class="fa fa-angle-left"></i>
                </a>
            </div>
            <div class="col-md-4 col-4 text-center">
                <h3 class="py-3 cart-ni-klasmeyt">Cart ni Klasmeyt</h3>
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
                                <button type="button" class="btn btn-outline-danger btn-sm remove-shop-btn" title="Remove shop">
                                    <i class="bi bi-trash3"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                <hr>
            </div>

            <div class="cart-wrapper collapse" id="collapseShop{{ $shopId }}" data-bs-parent="#shopAccordion">
                <div class="products-list">
                    @php $shopTotal = 0; @endphp
                    @foreach($orders as $order)
                    @php $shopTotal += $order->total; @endphp
                    <div class="product-item d-flex justify-content-center align-items-center">
                        <div class="product-img d-flex align-items-center">
                            <img src="{{ asset('storage/products/' . $order->image) }}" alt="{{ $order->product_name }}" class="img-fluid bg-secondary-subtle rounded">
                        </div>
                        <div class="product-details">
                            <h6 class="text-uppercase">{{ $order->product_name }}</h6>
                            <small class="text-muted">{{ $order->type_name }}</small>
                            <p class="price">₱ {{ number_format($order->price, 2) }}</p>
                            <div class="row d-flex align-items-center">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <form action="{{ route('update.quantity', $order->id) }}" method="POST" class="d-flex align-items-center update-quantity-form">
                                            @csrf
                                            @method('PATCH')
                                            <button type="button" class="btn btn-outline-danger btn-sm btn-decrease-cart">-</button>
                                            <input type="text" name="product_qty" class="form-control text-center qty-input-cart mx-2" readonly style="width: 50px;" value="{{ $order->quantity }}" max="10">
                                            <button type="button" class="btn btn-outline-success btn-sm btn-increase-cart">+</button>
                                        </form>
                                    </div>
                                    <div class="me-3">
                                        <form action="{{ route('remove.item', $order->id) }}" method="DELETE" class="remove-item-form" data-item-id="{{ $order->id }}">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="btn btn-outline-danger btn-sm remove-item-btn" title="Remove item">
                                                <i class="bi bi-trash3"></i>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                                <small class="pt-3 mb-0 text-secondary">Sub Total:</small>
                                <p class="subtotal"> ₱ {{ number_format($order->total, 2) }}</p>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                <div class="d-flex justify-content-end my-4">
                    <div class="d-flex align-items-center">
                        <h5 class="mx-2 mb-0"><strong>Total: <span class="overall-total">₱ {{ number_format($shopTotal, 2) }}</span></strong></h5>
                        <a href="{{ route('checkout.orders', ['shopId' => Crypt::encrypt($shopId)]) }}" class="btn btn-success">
                            <i class="fa fa-shopping-cart"></i> Checkout
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        @endif
    </div>
</div>

<!-- Script for protocart -->
<script>
    document.addEventListener('DOMContentLoaded', function() {

        // Handle item removal using AJAX
        document.querySelectorAll('.remove-item-btn').forEach(function(button) {
            button.addEventListener('click', function(event) {
                event.preventDefault();
                event.stopPropagation(); // Prevent accordion activation

                const form = button.closest('form');
                const itemId = form.getAttribute('data-item-id');

                fetch(form.getAttribute('action'), {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        },
                    })
                    .then((response) => response.json())
                    .then((data) => {
                        if (data.success) {
                            // Remove the item from the cart UI
                            const productItem = button.closest('.product-item');
                            productItem.remove();

                            // Recalculate totals
                            recalculateShopTotal(button);
                            recalculateOverallTotal();
                        }
                    });
            });
        });

        // Recalculate shop total after an item is removed or updated
        function recalculateShopTotal(button) {
            let shopTotal = 0;
            const shopSection = button.closest('.collapse');

            shopSection.querySelectorAll('.subtotal').forEach(function(subtotalElement) {
                let subtotal = parseFloat(subtotalElement.textContent.replace(/[₱,]/g, ''));
                shopTotal += subtotal;
            });

            // Update the shop total on the page
            shopSection.querySelector('.overall-total').textContent = '₱' + shopTotal.toFixed(2);
        }

        // Function to recalculate the overall cart total (for all shops)
        function recalculateOverallTotal() {
            let overallTotal = 0;

            document.querySelectorAll('.overall-total').forEach(function(shopTotalElement) {
                let shopTotal = parseFloat(shopTotalElement.textContent.replace(/[₱,]/g, ''));
                overallTotal += shopTotal;
            });

            // Update the grand total near the checkout button
            document.querySelector('.checkout .overall-total').textContent = '₱' + overallTotal.toFixed(2);
        }

        // Handle shop removal
        document.querySelectorAll('.remove-shop-btn').forEach(function(button) {
            button.addEventListener('click', function(event) {
                event.preventDefault();
                event.stopPropagation(); // Prevent accordion activation

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

                            // Optionally, recalculate the overall total after removing the shop
                            recalculateOverallTotal();
                        }
                    });
            });
        });

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
                            const subtotalElement = button.closest('.product-item').querySelector('.subtotal');
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