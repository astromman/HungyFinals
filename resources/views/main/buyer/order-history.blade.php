<!-- orderhistory.blade.php  -->

@extends('layouts.buyer.buyermaster')

@section('content')
<div class="container mt-5">
    <h4>Order History</h4>
    <p>Check the completed status of your recent orders</p>
    @forelse ($orders as $order)
    <div class="order-progress shadow-sm rounded mb-4" style="border-radius: 10px; background-color: #f8f9fa; border: 1px solid #ddd; padding: 15px; margin-bottom: 5px">
        <div class="mb-2 d-flex justify-content-between align-items center">
            <span>
                {{ $order->shop_name }}
                <br>
                <small class="text-muted">
                    {{ $order->designated_canteen }}
                </small>
            </span>
            <span>Order Ref: <small class="fw-bold">{{ $order->order_reference }}</small></span>
        </div>

        <div class="py-3 text-center text-success">
            <i class="bi bi-check-circle-fill" style="font-size: 100px;"></i>
            <br>
            <span class="fw-bold py-5">Completed!</span>
        </div>

        <!-- Order Items -->
        @php $shopTotal = 0; @endphp
        @foreach($order->products as $product)
        @php $shopTotal += $product->total; @endphp
        <div class="order-items mb-3">
            <div class="order-item p-3 mb-2 shadow-sm rounded">
                <!-- <div class="progress-bar-container mb-5"> -->
                <!-- Empty for now -->
                <!-- </div> -->
                <div class="row align-items-center">
                    <div class="col-4 col-md-2">
                        <img src="{{ asset('storage/products/' . $product->image) }}" alt="{{ $product->product_name }}" class="img-fluid rounded bg-secondary-subtle" style="height: 100px; width: 100px; object-fit: contain; margin-right: 20px;">
                    </div>
                    <div class="col-8 col-md-8">
                        <span class="mb-0">{{ $product->product_name }}</span>
                        <p class="text-muted">{{ $product->type_name }}</p>
                        <p class="text-muted mb-0">Quantity: {{ $product->quantity }}</p>
                    </div>
                    <div class="col-2 col-md-2 text-end mt-2 mt-md-0">
                        <span class="text-primary">₱ {{ number_format($product->total, 2) }}</span>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
        <div class="d-flex justify-content-between align-items center">
            <div>Total </div>
            <div>₱ {{ number_format($shopTotal, 2) }}</div>
        </div>
    </div>
    @empty
    <p>No orders found.</p>
    @endforelse
</div>
@endsection

<style>
    /* Order Card */
    .order-card {
        background-color: #f8f9fa;
        border: 1px solid #ddd;
    }

    /* Order Items */
    .order-item {
        background-color: #e9f5ff;
        /* border: 1px solid #007bff; */
    }
</style>