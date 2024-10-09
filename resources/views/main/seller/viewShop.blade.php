@extends('layouts.seller.sellerMaster')

@section('content')
<div class="container py-3">
    <div class="alert alert-primary my-2">
        <i class="bi bi-info-circle"></i> <strong>You are in View Mode! This feature allows you to experience your shop exactly as your buyers see it. You can browse through your shop's products and categories.</strong>
    </div>
    <div class="row">
        <div class="container position-relative" style="height: 350px; overflow: hidden;">
            <!-- Blurred Background Image -->
            @if($shopDetails->shop_image == "Not Available")
            <div class="position-absolute w-100 h-100"
                style="background-image: url('{{ asset('images/bg/default_shop_image.png') }}'); 
                background-size: cover; 
                background-repeat: no-repeat; 
                background-position: center; 
                z-index: 0;">
            </div>
            @else
            <div class="position-absolute w-100 h-100"
                style="background-image: url('{{ asset('storage/shop/' . $shopDetails->shop_image) }}'); 
                background-size: cover; 
                background-repeat: no-repeat; 
                background-position: center; 
                z-index: 0;">
            </div>
            @endif

            <!-- Gradient Overlay -->
            <div class="position-absolute w-100 h-100"
                style="background: linear-gradient(to bottom, rgba(0, 0, 0, 0.3), rgba(0, 0, 0, 0.3)); 
                z-index: 1;">
            </div>

            <!-- Content -->
            <div class="position-absolute bottom-0 w-100 p-5" style="z-index: 1; color: white; text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.7);">
                <h1>{{ $shopDetails->shop_name }}</h1>
                <p><strong>Contact:</strong> <span>{{ $shopDetails->contact_num }}</span></p>
                <p class="highlight-text">{{ $shopDetails->shop_bio }}</p>
            </div>
        </div>
    </div>

    @forelse($groupedProducts as $categoryName => $products)
    <div class="category-section mt-5">
        <h2 class="text-secondary">
            {{ $categoryName }}
            <hr>
        </h2>

        <div class="row">
            @foreach($products as $product)
            <!--PRODUCT CARD PART--->
            <div class="col-md-6 col-lg-3 mb-4">
                <div class="product-card h-100 position-relative border shadow-sm">
                    @if(!$product->is_deleted)
                    <div class="badge bg-success position-absolute">
                        {{ $product->status }}
                    </div>
                    @else
                    <div class="badge bg-danger position-absolute">
                        {{ $product->status }}
                    </div>
                    @endif

                    @if(is_null($product->image))
                    <!-- Image Container -->
                    <div class="product-tumb w-100" style="height: 200px;">
                        <img src="{{ asset('images/bg/default_shop_image.png') }}" alt="{{ $product->product_name }}" class="img-fluid w-100 h-100" style="object-fit: cover;">
                    </div>
                    @else
                    <!-- Image Container -->
                    <div class="product-tumb w-100" style="height: 200px;">
                        <img src="{{ asset('storage/products/' . $product->image) }}" alt="{{ $product->product_name }}" class="img-fluid w-100 h-100" style="object-fit: cover;">
                    </div>
                    @endif

                    <div class="product-details p-3">
                        <span class="product-catagory d-block">{{ $product->category_name }}</span>
                        <h4 class="mt-2">{{ $product->product_name }}</h4>
                        <p>{{ $product->product_description }}</p>
                        <div class="product-bottom-details d-flex justify-content-between align-items-center">
                            <div class="product-price">₱{{ $product->price }}</div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @empty
    <h3 class="text-secondary text-center pt-5">
        <strong>No products yet.</strong>
    </h3>
    @endforelse
</div>
@endsection