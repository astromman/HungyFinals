@extends('layouts.buyer.buyermaster')

@section('content')
<div class="container my-4 flex-grow-1">
    <div class="row">
        <div class="mb-2">
            <a href="{{ route('landing.page') }}">
                <i class="fa fa-angle-left" style="font-size: large;"></i>
            </a>
        </div>

        <div class="container position-relative" style="height: 350px; overflow: hidden;">
            <!-- Blurred Background Image -->
            @if(is_null($canteen->building_image))
            <div class="position-absolute w-100 h-100"
                style="background-image: url('{{ asset('images/bg/default_shop_image.png') }}'); 
                background-size: cover; 
                background-repeat: no-repeat; 
                background-position: center; 
                z-index: 0;">
            </div>
            @else
            <div class="position-absolute w-100 h-100"
                style="background-image: url('{{ asset('storage/canteen/' . $canteen->building_image) }}'); 
                background-size: cover; 
                background-repeat: no-repeat; 
                background-position: center; 
                z-index: 0;">
            </div>
            @endif

            <!-- Gradient Overlay -->
            <div class="position-absolute w-100 h-100"
                style="background: linear-gradient(to bottom, rgba(0, 0, 0, 0.3), rgba(0, 0, 0, 0.5)); 
                z-index: 1;">
            </div>

            <div class="position-absolute bottom-0 w-100 p-5" style="z-index: 1; color: white; text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.7);">
                <!-- <p class="highlight-text">100% Masarap</p> -->
                <h1 class="custom-font text-white">{{ $canteen->building_name }}</h1>
                <br>
                <p class="text-white">{{ $canteen->building_description }}</p>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <h4 class="highlight-text">Available Shops</h4>
        @forelse($shops as $shop)
        <div class="col-md-3 mb-4">
            <div class="card h-100 shadow" style="width: 100%;">
                <!-- Background Image Container -->
                @if($shop->shop_image == 'Not Available')
                <div class="position-relative" style="height: 150px; overflow: hidden;">
                    <div class="position-absolute w-100 h-100"
                        style="background-image: url('{{ asset('images/bg/default_shop_image.png') }}'); 
                    background-size: cover; 
                    background-repeat: no-repeat; 
                    background-position: center;">
                    </div>
                    <!-- Gradient Overlay -->
                    <div class="position-absolute w-100 h-100"
                        style="background: linear-gradient(to bottom, rgba(0, 0, 0, 0.3), rgba(0, 0, 0, 0.3));">
                    </div>
                </div>
                @else
                <div class="position-relative" style="height: 150px; overflow: hidden;">
                    <div class="position-absolute w-100 h-100"
                        style="background-image: url('{{ asset('storage/shop/' . $shop->shop_image) }}'); 
                    background-size: cover; 
                    background-repeat: no-repeat; 
                    background-position: center;">
                    </div>
                    <!-- Gradient Overlay -->
                    <div class="position-absolute w-100 h-100"
                        style="background: linear-gradient(to bottom, rgba(0, 0, 0, 0.3), rgba(0, 0, 0, 0.3));">
                    </div>
                </div>
                @endif

                @if($shop->is_reopen)
                <a href="{{ route('visit.shop', ['id' => $shop->id, 'shop_name' => Str::slug($shop->shop_name)]) }}" class="text-dark stretched-link" style="text-decoration: none;">
                    <div class="card-body d-flex flex-column justify-content-between" style="height: 100px;">
                        <h5 class=" card-title">{{ $shop->shop_name }}</h5>
                        <div class="p-1 d-flex justify-content-between align-items-center">
                            <small class="card-text text-muted"><i class="bi bi-clock-fill text-primary-emphasis"></i> Prep time: <span class="text-primary-emphasis">{{ $shop->preparation_time }} {{ $shop->preparation_time > 1 ? 'mins' : 'min' }}</span></small>
                            <small class="card-text text-muted text-left">Rating: <span class="text-warning">{{ $shop->rating > 5 ? '5.0' : $shop->rating }}</span><i class="bi bi-star-fill text-warning ps-1"></i> </small>
                        </div>
                    </div>
                </a>
                @else <!-- unclickable -->
                <div class="card-body d-flex flex-column justify-content-between" style="height: 100px;">
                    <h5 class=" card-title">{{ $shop->shop_name }}</h5>
                    <p class="p-2 card-text text-danger">Closed</p>
                </div>
                @endif
            </div>
        </div>
        @empty
        <div class="container no-result">
            <!-- Updated icon-wrapper to contain only the image without the circular background -->
            <div class="icon-wrapper">
                <img src="/images/bg/search3.png">
            </div>
            <div class="title" style="font-weight: bold;">No available shops yet.</div>
            <div class="description">Thank you for visiting! There is no available shop, but we look forward to welcoming you back soon.</div>
        </div>
        @endforelse
    </div>
</div>

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

    .title {
        font-size: 18px;
        color: #333;
        font-weight: 500;
        margin-bottom: 10px;
    }

    .description {
        font-size: 15px;
        color: #888;
        margin-bottom: 20px;
    }

    .container .no-result {
        text-align: center;
        max-width: 300px;
    }

    .icon-wrapper img {
        width: 200px;
        /* Increased image size */
        height: auto;
        margin-bottom: 20px;
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

    /* Mobile adjustments */
    @media (max-width: 768px) {

        .col-12,
        .col-md-6,
        .col-lg-3 {
            width: 100% !important;
            padding-left: 80px !important;
            margin-bottom: 10px !important;
        }

        /* Ensure full-width for the product wrapper on mobile */
        .product-wrapper {
            width: 74.2% !important;
            padding: 10px !important;
        }

        /* Adjust the image container */
        .product-tumb {
            height: 150px !important;
        }

        .product-details h4 {
            font-size: 1.1rem !important;
        }

        .product-details p {
            font-size: 0.9rem !important;
        }

        .product-price {
            font-size: 1rem !important;
        }

        .favorite-btn {
            font-size: 12px !important;
            padding: 4px 8px !important;
        }

        .full-width-line {
            width: 100% !important;
        }
    }

    /* Media query for mobile devices */
    @media (max-width: 768px) {

        /* Shop banner adjustments */
        .container.position-relative {
            width: 94% !important;
            height: 220px !important;
            /* Reduce height for mobile */
            overflow: hidden;
            padding: 0 !important;
            /* Remove padding */
            margin: 10 !important;
            /* Remove margin */
        }

        .position-absolute.bottom-0.w-100.p-5 {
            padding: 10px !important;
            text-align: left !important;
            /* Ensure text is left-aligned */
            padding-left: 15px !important;
            /* Remove left padding */
            margin-left: 0px !important;
            /* Ensure no margin is causing spacing */
        }
    }

    /* h1 {
        font-size: 1.3rem !important;
    } */

    .highlight-text {
        font-size: 0.8rem !important;
        /* Smaller font size for bio text */
    }

    /* Adjust padding for product cards on mobile */
    .product-wrapper {
        padding: 10px !important;
        margin: 0 !important;
        /* Ensure no extra margins between cards */
    }

    /* Image container inside product cards */
    .product-tumb {
        height: 150px !important;
        /* Reduce height for mobile */
    }

    /* Adjust product details for mobile */
    .product-details h4 {
        font-size: 1.1rem !important;
        /* Adjust product name size */
    }

    .product-details p {
        font-size: 0.9rem !important;
        /* Adjust product description size */
    }

    /* Product price adjustment */
    .product-price {
        font-size: 1rem !important;
        /* Adjust price size */
    }

    /* Favorite button adjustments for mobile */
    .favorite-btn {
        font-size: 12px !important;
        padding: 4px 8px !important;
    }

    /* Category title size */
    .category-section h2 {
        font-size: 1.3rem !important;
        /* Adjust category title size */
    }

    /* Horizontal line adjustments */
    .category-section hr {
        margin: 5px 0 !important;
    }


    /* Additional adjustments for extra small screens */
    @media (max-width: 576px) {
        .container.position-relative {
            height: 180px !important;
            /* Further reduce height for smaller screens */
        }

        .position-absolute.bottom-0.w-100.p-5 {
            padding: 5px !important;
            /* Further reduce padding */
        }

        /* h1 {
            font-size: 1rem !important;
        } */

        .text-white {
            font-size: 0.8rem !important;
        }

        .highlight-text {
            font-size: 0.7rem !important;
        }

        /* Adjustments for product image height */
        .product-tumb {
            height: 120px !important;
        }

        /* Product details adjustments */
        .product-details h4 {
            font-size: 0.9rem !important;
        }

        .product-details p {
            font-size: 0.8rem !important;
        }

        /* Adjustments for favorite button and price */
        .favorite-btn {
            font-size: 10px !important;
            padding: 3px 6px !important;
        }

        .product-price {
            font-size: 0.9rem !important;
        }

        .canteen-badge {
            font-size: 0.7rem !important;
        }
    }
</style>
@endsection