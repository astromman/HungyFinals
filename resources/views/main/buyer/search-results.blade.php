@extends('layouts.buyer.buyermaster')

@section('content')
<!-- Success Modal -->
@if (session('success'))
<div class="modal fade" id="successModal" tabindex="-1" aria-labelledby="successModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="successModalLabel">Success</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                {{ session('message') }}
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
@endif

<div class="container my-5">
    <!-- Back Button -->
    <div class="mb-2">
        <a href="javascript:history.back()">
            <i class="fa fa-angle-left" style="font-size: large;"></i>
        </a>
    </div>

    <!-- Search Results Header -->
    <div class="row">
        <h2 class="text-secondary">Search Results for "{{ $searchTerm }}"</h2>

        <hr>
    </div>

    <!-- Shops Results -->
    @if($shops->isNotEmpty())
    <div class="shops-section my-5">
        <h3 class="text-secondary">Shops</h3>
        <hr>
        <div class="row">
            @foreach ($shops as $shop)
            <div class="col-md-6 col-lg-4 mb-4">
                <div class="card shadow-sm h-100">
                    <div class="card-header p-0">
                        <div class="position-relative" style="height: 200px; overflow: hidden;">
                            @if ($shop->shop_image == 'Not Available')
                            <img src="{{ asset('images/bg/default_shop_image.png') }}"
                                class="w-100 h-100" style="object-fit: cover;" alt="Default Image">
                            @else
                            <img src="{{ asset('storage/shop/' . $shop->shop_image) }}"
                                class="w-100 h-100" style="object-fit: cover;"
                                alt="{{ $shop->shop_name }}">
                            @endif
                        </div>
                    </div>
                    <div class="card-body">
                        <h5 class="card-title">{{ $shop->shop_name }}</h5>
                        <p>{{ $shop->shop_bio }}</p>
                        <p><strong>Contact:</strong> {{ $shop->contact_num }}</p>
                        <a href="{{ route('visit.shop', ['id' => $shop->id, 'shop_name' => Str::slug($shop->shop_name)]) }}"
                            class="btn btn-outline-primary">Visit Shop</a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @else
    <h4 class="text-secondary">No Shops Found</h4>
    @endif

    <!-- Products Results -->
    @if($groupedProducts->isNotEmpty())
    <div class="products-section my-5">
        <h3 class="text-secondary">Products</h3>
        <hr>

        <!-- Loop through product categories -->
        @foreach ($groupedProducts as $categoryName => $products)
        <div class="category-section my-5">
            <h4 class="text-secondary">
                {{ $categoryName }}
                <hr>
            </h4>

            <div class="row">
                @foreach ($products as $product)
                <!-- Product Card -->
                <div class="col-md-6 col-lg-3 mb-4">
                    <div class="product-wrapper">
                        <div class="product-card position-relative border shadow" data-bs-toggle="modal"
                            data-bs-target="#productModal" data-id="{{ $product->id }}"
                            data-name="{{ $product->product_name }}"
                            data-description="{{ $product->product_description }}"
                            data-price="{{ $product->price }}" data-category="{{ $product->category_name }}"
                            data-image="{{ asset('storage/products/' . $product->image) }}">

                            <!-- Badge for product status -->
                            @if (!$product->is_deleted)
                            <div class="badge bg-success position-absolute">
                                {{ $product->status }}
                            </div>
                            @else
                            <div class="badge bg-danger position-absolute">
                                {{ $product->status }}
                            </div>
                            @endif

                            <!-- Image Container -->
                            <div class="product-tumb w-100" style="height: 200px;">
                                <img src="{{ asset('storage/products/' . $product->image) }}"
                                    alt="{{ $product->product_name }}" class="img-fluid w-100 h-100"
                                    style="object-fit: cover;">
                            </div>

                            <!-- Product Details -->
                            <div class="product-details p-3">
                                <span class="product-catagory d-block">{{ $product->category_name }}</span>
                                <h4 class="mt-2">{{ $product->product_name }}</h4>
                                <p>{{ $product->product_description }}</p>
                                <hr class="full-width-line">
                            </div>
                        </div>

                        <!-- Add to Favorites Form -->
                        <!-- Add to Favorites Form -->
                        <div class="add-to-favorites mt-2">
                            <div class="d-flex justify-content-between align-items-center">
                                <!-- Price -->
                                <div class="product-price" style="padding-left: 18px;">₱{{ $product->price }}</div>

                                <!-- Add to Favorites Button -->
                                <form id="favoriteForm" method="POST" action="{{ route('favorites.add') }}"
                                    class="favorite-form" style="padding-right: 20px;">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                                    <button type="submit" class="btn  favorite-btn">
                                        <i class="fa fa-heart"></i>
                                    </button>
                                </form>
                            </div>
                        </div>

                    </div>
                </div>
                @endforeach
            </div>
            <div style="display:none;">
                <meta name="csrf-token" content="{{ csrf_token() }}">
            </div>
        </div>
        @endforeach
    </div>
    @else
    <h4 class="text-secondary">No Products Found</h4>
    @endif

    <!-- Include Product Modal -->
    @include('main.buyer.product-modal')
</div>

<!-- Success Modal Script -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var successModal = new bootstrap.Modal(document.getElementById('successModal'));
        if ('{{ session('
            success ') }}') {
            successModal.show();
        }
    });
</script>

<style>
    .product-wrapper {
        position: relative !important;
        background-color: white !important;
        border-radius: 10px !important;
        overflow: hidden !important;
        box-shadow: none !important;
        /* Remove the shadow from the wrapper */
        padding: 0;
        /* Ensure no padding inside the wrapper */
        margin: 0;
        /* Ensure no margin inside the wrapper */
    }

    .product-card {
        margin: 0 !important;
        padding: 0 !important;
        border: none !important;
        box-shadow: none !important;
        /* Remove any shadow from the product card */
    }

    .product-tumb {
        width: 100% !important;
        height: 180px !important;
        /* Ensure image height */
        margin: 0 !important;
        /* Remove margin */
        padding: 0 !important;
        /* Remove padding */
    }

    .product-details {
        padding: 10px 15px !important;
        box-shadow: none !important;
        /* Ensure no shadow around the product details */
        background-color: white !important;
    }

    img {
        display: block !important;
        width: 100% !important;
        height: auto !important;
        object-fit: cover !important;

        /* Ensure the image covers the space properly */
    }

    .add-to-favorites {
        margin-bottom: 20px;
        /* Add margin at the bottom of the favorites button */
    }

    .favorite-btn {
        padding: 6px 12px;
        padding-left: 10px;
        font-size: 14px;
        color: #3ac2ef;
        /* border-color: #3ac2ef; */
        background-color: transparent;
        border-radius: 15px;
        display: inline-block;
        white-space: nowrap;
        border: none;
    }

    .full-width-line {
        border: 0;
        border-top: 1px solid #ddd;
        /* Define the color and thickness of the line */
        width: 100%;
        /* Ensure the line spans the entire width */
        margin: 0;
        /* Remove default margins */
    }
</style>
@endsection