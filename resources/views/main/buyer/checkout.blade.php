@extends('layouts.buyer.buyermaster')

@section('content')
<style>
    body {
        background-color: white !important;
        /* Override master body background */
    }

    .parent-div {
        background-color: white;
    }

    .first-div {
        width: 100%;
        /* Make sure the div spans the entire width of the screen */
        background-color: white;
    }

    .content-div {
        background-color: lightgray;
        /* Container for 2nd - 8th div */
    }

    .content-div .child-div {
        background-color: white;
        border: 1px solid #ccc;
        border-radius: 5px;
        margin-bottom: 1rem;
    }
</style>

<div class="container">
    <!-- 1st Div -->
    <div class="d-flex justify-content-between align-items-center py-3">
        <div class="col-auto me-3">
            <a href="#" class="text-decoration-none">
                <i class="fa-solid fa-circle-chevron-left" style="color: #0B1E59; font-size: 30px;"></i>
            </a>
        </div>
        <div class="col">
            <div class="row">
                <div class="col-12 text-left fw-bold fs-4">Last Step - Checkout</div>
                <div class="col-12 text-left fs-6">Your Orders</div>
            </div>
        </div>
    </div>

    <!-- Progress Bar -->
    @include('main.buyer.protobar')

    <!-- Content Div with Gray Background -->
    <div style="background-color: lightgray; width: 100%; padding: 15px;">
        <!-- 2nd Div -->
        <div class="border rounded p-3 my-3 bg-white" style="border: 1px solid #ccc; border-radius: 5px;">
            <div class="fw-bold fs-4">Pick-Up Order at</div>
        </div>

        <!-- 3rd Div -->
        <div class="border rounded p-3 my-3 bg-white" style="border: 1px solid #ccc; border-radius: 5px;">
            <div class="row">
                <div class="col-12">{{ $canteen->building_name }}</div>
                <div class="col-12">20 mins</div>
            </div>
        </div>

        <!-- 4th Div -->
        <div class="d-flex justify-content-between align-items-center border rounded p-3 my-3 bg-white" style="border: 1px solid #ccc; border-radius: 5px;">
            <div class="fw-bold fs-4">Order Summary</div>
            <span><a href="{{ route('visit.shop', ['id' => $shop->id, 'shop_name' => Str::slug($shop->shop_name)]) }}" class="href">Add items</a></span>
        </div>

        <!-- 5th Div -->
        @php $shopTotal = 0; @endphp
        @foreach($orders as $order)
        @php $shopTotal += $order->total; @endphp
        <div class="border rounded p-3 my-3 bg-white" style="border: 1px solid #ccc; border-radius: 5px;">
            <div class="row mb-3">
                <div class="col-1 d-flex justify-content-center align-items-center p-3 bg-secondary-subtle">
                    <span class="mx-2">{{ $order->quantity . 'x' }}</span>
                </div>
                <div class="col-3">
                    <img src="{{ asset('storage/products/' . $order->image) }}" alt="{{ $order->name }}" class="img-fluid rounded bg-secondary-subtle" style="height: 100px; width: 100px; object-fit: contain; margin-right: 20px;">
                </div>
                <div class="col-6 d-flex align-items-center text-uppercase">
                    {{ $order->product_name }}
                </div>
                <!-- <div class="col-3 d-flex align-items-center">
                    Canteen
                </div> -->
                <div class="col-2 d-flex align-items-center justify-content-end">
                    {{ '₱ ' . $order->price }}
                </div>
            </div>
            <div class="row border-top pt-2">
                <div class="col-6">Subtotal</div>
                <div class="col-6 text-end">{{ '₱ ' . $order->total }}</div>
            </div>
        </div>
        @endforeach

        <!-- 6th Div -->
        <div class="border rounded p-3 my-3 bg-white" style="border: 1px solid #ccc; border-radius: 5px;">
            <div class="fw-bold fs-4">Payment Details</div>
        </div>

        <!-- 7th Div -->
        <div class="border rounded p-3 my-3 bg-white" style="border: 1px solid #ccc; border-radius: 5px;">
            <div class="row mb-2">
                <div class="col-12">Payment method</div>
            </div>
            <div class="row">
                <select class="form-select">
                    <option value="cash">💵 Cash</option>
                    <option value="paypal">💳 Cashless</option>
                </select>
            </div>
        </div>

        <!-- 8th Div -->
        <div class="border rounded p-3 my-3 bg-white d-flex justify-content-between align-items-center" style="border: 1px solid #ccc; border-radius: 5px;">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items center mb-3">
                    <div>Total</div>
                    <div class="fw-bold">{{ '₱ ' . number_format($shopTotal, 2) }}</div>
                </div>
                <form action="{{ route('place.order', Crypt::encrypt($shop->id)) }}" method="POST">
                    @csrf
                    <input type="hidden" name="payment_method" value="cashless">
                    <button type="submit" class="btn btn-primary w-100">Place Order</button>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection