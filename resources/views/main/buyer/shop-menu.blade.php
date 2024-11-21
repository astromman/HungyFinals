@extends('layouts.buyer.buyermaster')

@section('content')
<div class="container my-4">
    <div class="row">
        <div class="mb-2">
            <a href="javascript:history.back()">
                <i class="fa fa-angle-left" style="font-size: large;"></i>
            </a>
        </div>

        <div class="container position-relative" style="height: 350px; overflow: hidden;">
            <!-- Blurred Background Image -->
            @if ($shops->shop_image == 'Not Available')
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
                style="background: linear-gradient(to bottom, rgba(0, 0, 0, 0.3), rgba(0, 0, 0, 0.5)); 
                z-index: 1;">
            </div>

            <!-- Content -->
            <div class="position-absolute bottom-0 w-100 p-5"
                style="z-index: 1; color: white; text-shadow: 2px 2px 4px rgba(0, 0, 0, 1);">
                <table>
                    <tbody>
                        <tr>
                            <td>
                                <h1 class="text-white">{{ $shops->shop_name }}</h1>
                            </td>
                            <td class="px-2 canteen-badge">
                                <div class="px-1 rounded-2 shadow bg-success text-white">
                                    <span>{{ $shops->designated_canteen }}</span>
                                </div>
                                ‎
                            </td>
                        </tr>
                    </tbody>
                </table>
                <p class="text-white"><strong>Contact:</strong> <span>{{ $shops->contact_num }}</span></p>
                <p class="highlight-text">{{ $shops->shop_bio }}</p>
                <p class="text-white"> Rating: <span class="text-warning">({{ $totalNoRating }}) {{ $shops->rating }}</span><i class="bi bi-star-fill text-warning ps-1"></i> </p>
            </div>
        </div>
    </div>

    <!-- Product Listing -->
    @forelse($groupedProducts as $categoryName => $products)
    <div class="category-section my-5">
        <h2 class="text-secondary">
            {{ $categoryName }}
            <hr>
        </h2>

        <div class="row">
            @foreach ($products as $product)
            <!-- Product Card -->
            <div class="col-md-6 col-lg-3 mb-4">
                <div class="product-wrapper">
                    <div class="product-card position-relative border shadow"
                        {{ !$product->is_deleted ? 'data-bs-toggle=modal data-bs-target=#productModal' : '' }}
                        data-id="{{ $product->id }}"
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
                            <!-- if wala pang ma provide na image si seller then -->
                            <!-- set the shop_image as the image of the product -->
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

    @empty
    <h3 class="text-secondary text-center pt-5">
        <strong>No products yet.</strong>
    </h3>
    @endforelse

    <!-- Include product modal outside of the loop -->
    @include('main.buyer.product-modal')

</div>

@if(session('addToCart'))
<script>
    Swal.fire({
        position: "center",
        icon: "success",
        title: "{{ session('qty') > 1 ? 'Items' : 'Item' }} added to cart!",
        showConfirmButton: true,
        allowOutsideClick: true
    });
</script>
@endif

<!-- JavaScript for handling modal and favorites -->
<script>
    document.addEventListener('DOMContentLoaded', function() {

        // Success Modal
        document.addEventListener('DOMContentLoaded', function() {
            var successModal = new bootstrap.Modal(document.getElementById('successModal'));
            successModal.show();
        });

        const productModal = document.getElementById('productModal');
        const productForm = document.getElementById('productForm');
        const qtyInput = productForm.querySelector('.qty-input');

        // Handle "Add to Favorites" form submission with AJAX
        document.querySelectorAll('.favorite-form').forEach(function(form) {
            form.addEventListener('submit', function(event) {
                event.preventDefault(); // Prevent the default form submission
                const formData = new FormData(this);
                const url = this.action;

                // Perform AJAX request
                fetch(url, {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector(
                                'meta[name="csrf-token"]').getAttribute('content')
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            // Optionally, display a success message or update the UI dynamically
                            alert('Added to favorites successfully!');
                        } else {
                            alert('Error adding to favorites!');
                        }
                    })
                    .catch(error => console.error('Error:', error));
            });
        });

        // Event listener for when the modal is shown
        productModal.addEventListener('show.bs.modal', function(event) {
            const button = event.relatedTarget;

            const productId = button.getAttribute('data-id');
            const productName = button.getAttribute('data-name');
            const productDescription = button.getAttribute('data-description');
            const productPrice = button.getAttribute('data-price');
            const productCategory = button.getAttribute('data-category');
            const productImage = button.getAttribute('data-image');

            // Update the modal's content
            productModal.querySelector('.modal-title').textContent = productName;
            productModal.querySelector('.price').textContent = '₱' + productPrice;
            productModal.querySelector('.description').textContent = productDescription;
            productModal.querySelector('.category').textContent = productCategory;
            productModal.querySelector('img').setAttribute('src', productImage);
            productModal.querySelector('img').setAttribute('alt', productName);

            // Update the hidden input fields in the form
            productForm.querySelector('.product_id').value = productId;

            // Reset the quantity input to 1
            qtyInput.value = 1;
        });

        // Event listener for when the modal is hidden
        productModal.addEventListener('hidden.bs.modal', function() {
            qtyInput.value = 1;
        });

        // Handle quantity increase
        document.querySelector('.btn-increase').addEventListener('click', function() {
            let qty = parseInt(qtyInput.value);
            qty = isNaN(qty) ? 1 : qty;
            if (qty < 10) {
                qtyInput.value = qty + 1;
            }
        });

        // Handle quantity decrease
        document.querySelector('.btn-decrease').addEventListener('click', function() {
            let qty = parseInt(qtyInput.value);
            qty = isNaN(qty) ? 1 : qty;
            if (qty > 1) {
                qtyInput.value = qty - 1;
            }
        });
    });
</script>

<!-- Basic CSS for button styling -->
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