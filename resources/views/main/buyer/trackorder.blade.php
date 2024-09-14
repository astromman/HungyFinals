<!-- resources/views/track-order.blade.php -->

@extends('layouts.buyer.buyermaster')

@section('content')
<div class="container mt-5">
    <h2 class="text-center">Track your orders klasmeyt</h2>
    <p class="text-center">This will help to manage your time and observe your order</p>

    <!-- Order Card -->
    <div class="order-card p-4 shadow-sm rounded mb-5">
        <h5>We were processing your order klasmeyt</h5>
        <p>Thank you for being patient, we appreciated it</p>
        <p>Pick-up klasmeyt: <strong class="text-uppercase">{{ $user->first_name . ' ' . $user->last_name }}</strong></p>
    </div>

    @foreach($orders as $order)
    <div class="order-progress shadow-sm rounded" style="border-radius: 10px; background-color: #f8f9fa; border: 1px solid #ddd; padding: 15px; margin-bottom: 5px">
        <div class="mb-2 d-flex justify-content-between align-items center">
            <h5>
                {{ $order->shop_name }}
                <br>
                <small class="text-muted">
                    {{ $order->designated_canteen }}
                </small>
            </h5>
            <h5>Order Ref: <strong>{{ $order->order_reference }}</strong></h5>
        </div>

        <div class="py-3">
            @include('main.buyer.protobar', ['order' => $order])
        </div>

        <!-- Order Items -->
        @foreach($order->products as $product)
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
                        <h5 class="mb-0">{{ $product->product_name }}</h5>
                        <p class="text-muted mb-0">Quantity: {{ $product->quantity }}</p>
                    </div>
                    <div class="col-2 col-md-2 text-end mt-2 mt-md-0">
                        <h4 class="text-primary">₱ {{ number_format($product->total, 2) }}</h4>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    @endforeach
    <!-- <div class="text-end">
        <h4 class="btn btn-primary">TOTAL AMOUNT : ₱ 55.00</h4>
    </div> -->
</div>

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

    /* Progress Bar Container */
    .progress-bar-container {
        position: relative;
        padding: 20px;
        overflow: visible;
        /* Ensure pseudo-elements are visible */
    }

    /* Progress Bar Styles */
    .progress-bar__bar {
        background-color: #007bff;
        /* Ensure visibility */
        position: absolute;
        top: 50%;
        left: 0;
        right: 0;
        height: 5px;
        z-index: 1;
        /* Ensure it's on top of the background */
        transform: translateY(-50%);
    }

    .progress-bar__step {
        position: relative;
        z-index: 2;
        /* Ensure step numbers are above the line */
    }
</style>
@endsection