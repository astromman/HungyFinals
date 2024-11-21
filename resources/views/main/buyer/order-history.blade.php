@extends('layouts.buyer.buyermaster')

@section('content')
<div class="container mt-5">
    <h4>Order History</h4>
    <p>Check the completed status of your recent orders</p>
    <!-- Pagination Links -->
    <div class="d-flex justify-content-center mt-4">
        {{$orders->links('pagination::bootstrap-4')}}
    </div>

    @forelse ($orders as $order)
    <div class="order-progress shadow-sm rounded mb-4 p-3" style="background-color: #f8f9fa;">
        <div class="mb-2 d-flex justify-content-between align-items-center flex-wrap">
            <div>
                <strong>{{ $order->shop_name }}</strong>
                <br>
                <small class="text-muted">{{ $order->designated_canteen }}</small>
            </div>
            <div class="text-end mt-2 mt-sm-0">
                <span>Order Reference<br>
                    <small class="fw-bold">{{ $order->order_reference }}</small>
                </span>
            </div>
        </div>

        <div class="py-3 text-center text-success">
            <i class="bi bi-check-circle-fill" style="font-size: 3rem;"></i>
            <br>
            <span class="fw-bold py-3">Completed!</span>
        </div>

        <!-- Order Items -->
        @php $shopTotal = 0; @endphp
        @foreach ($order->products as $product)
        @php $shopTotal += $product->total; @endphp
        <div class="order-items mb-3">
            <div class="order-item p-3 mb-2 shadow-sm rounded">
                <div class="row align-items-center">
                    <div class="col-4 col-md-2">
                        <img src="{{ asset('storage/products/' . $product->image) }}" alt="{{ $product->product_name }}"
                            class="img-fluid rounded bg-secondary-subtle" style="height: 100px; width: 100px; object-fit: contain;">
                    </div>
                    <div class="col-8 col-md-7">
                        <span class="mb-0">{{ $product->product_name }}</span>
                        <p class="text-muted">{{ $product->type_name }}</p>
                        <p class="text-muted mb-0">Quantity: {{ $product->quantity }}</p>
                    </div>
                    <div class="col-12 col-md-3 text-end mt-2 mt-md-0">
                        <span class="text-primary fs-5">₱ {{ number_format($product->total, 2) }}</span>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
        <div class="d-flex justify-content-between align-items-center mt-3">
            <div class="fw-bold">Total </div>
            <div class="text-primary fs-5 fw-bold">₱ {{ number_format($shopTotal, 2) }}</div>
        </div>

        <div class="d-flex justify-content-between align-items-center">
            <!-- Re-Order Again Button based on encrypted order_reference -->
            <a href="{{ route('visit.shop', ['id' => $order->shop_id, 'shop_name' => Str::slug($order->shop_name)]) }}" class="btn btn-primary mx-1 mt-3 w-100 w-md-auto">
                Rate
            </a>
            <!-- Re-Order Again Button based on encrypted order_reference -->
            <a href="{{ route('visit.shop', ['id' => $order->shop_id, 'shop_name' => Str::slug($order->shop_name)]) }}" class="btn btn-primary mx-1 mt-3 w-100 w-md-auto">
                Re-Order Again
            </a>
        </div>

        @include('main.buyer.review-modal')

    </div>
    @empty
    <p>No orders found.</p>
    @endforelse

    <!-- Pagination Links -->
    <div class="d-flex justify-content-center mt-4">
        {{$orders->links('pagination::bootstrap-4')}}
    </div>
</div>
@endsection

<style>
    /* Order Card */
    .order-progress {
        background-color: #f8f9fa;
        border: 1px solid #ddd;
        padding: 15px;
    }

    /* Order Items */
    .order-item {
        background-color: #e9f5ff;
    }

    /* Responsive Styling */
    @media (max-width: 768px) {
        .order-progress {
            padding: 10px;
        }

        .order-item .row>div {
            text-align: left;
        }

        .order-item img {
            height: 80px;
            width: 80px;
        }

        .order-item .text-end {
            text-align: right;
        }
    }

    @media (max-width: 576px) {
        .order-item img {
            height: 60px;
            width: 60px;
        }

        .order-item .text-end {
            text-align: left;
        }

        .text-primary {
            font-size: 1rem;
        }
    }

    /* Pagination Styling */
    .pagination {
        justify-content: center;
    }

    .pagination .page-link {
        color: #007bff;
        border: 1px solid #dee2e6;
        border-radius: 0.25rem;
    }

    .pagination .page-item.active .page-link {
        background-color: #007bff;
        border-color: #007bff;
        color: white;
    }

    .pagination .page-link:hover {
        background-color: #e9f5ff;
    }
</style>