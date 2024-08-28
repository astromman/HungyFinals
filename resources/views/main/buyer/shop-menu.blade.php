@extends('layouts.buyer.buyermaster')

@section('content')
<div class="container my-4 ">
    <div class="row">
        <div class="mb-2">
            <a href="javascript:history.back()">
                <i class="fa fa-angle-left" style="font-size: large;"></i>
            </a>
        </div>

        <div class="container position-relative" style="height: 350px; overflow: hidden;">
            <!-- Blurred Background Image -->
            @if($shops->shop_image == "Not Available")
            <div class="position-absolute w-100 h-100"
                style="background-image: url('{{ asset('images/bg/default_shop_image.png') }}'); 
                background-size: cover; 
                background-repeat: no-repeat; 
                background-position: center; 
                z-index: 0;">
            </div>
            @else
            <div class="position-absolute w-100 h-100"
                style="background-image: url('{{ asset('storage/shop/' . $shops->shop_image) }}'); 
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
                <table>
                    <tbody>
                        <tr>
                            <td>
                                <h1>{{ $shops->shop_name }}</h1>
                            </td>
                            <td class="px-2">
                                <div class="px-1 rounded-2 shadow bg-success">
                                    <span>{{ $shops->designated_canteen }}</span>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <p><strong>Contact:</strong> <span>{{ $shops->contact_num }}</span></p>
                <p class="highlight-text">{{ $shops->shop_bio }}</p>
            </div>
        </div>
    </div>
    <!-- <h3 class="pt-2 highlight-text">Available Foods</h3> -->
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
                <div class="product-card h-100 position-relative border shadow" data-bs-toggle="modal" data-bs-target="#productModal"
                    data-id="{{ $product->id }}"
                    data-name="{{ $product->product_name }}"
                    data-description="{{ $product->product_description }}"
                    data-price="{{ $product->price }}"
                    data-category="{{ $product->category_name }}"
                    data-status="{{ $product->status }}"
                    data-image="{{ asset('storage/products/' . $product->image) }}">

                    @if(!$product->is_deleted)
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
                        <img src="{{ asset('storage/products/' . $product->image) }}" alt="{{ $product->product_name }}" class="img-fluid w-100 h-100" style="object-fit: cover;">
                    </div>

                    <!-- Product Details -->
                    <div class="product-details p-3">
                        <span class="product-catagory d-block">{{ $product->category_name }}</span>
                        <h4 class="mt-2">{{ $product->product_name }}</h4>
                        <p>{{ $product->product_description }}</p>
                        <div class="product-bottom-details d-flex justify-content-between align-items-center">
                            <div class="product-price">₱{{ $product->price }}</div>
                            <div class="product-links">
                                <a href="javascript:void(0);" class="toggle-favorite"><i class="fa fa-heart"></i></a>
                            </div>
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

@include('main.buyer.product-modal')

<script>
    
</script>

@endsection