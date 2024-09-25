@extends('layouts.buyer.buyermaster')

@section('content')
<h5>Klasmeyt's Favorites</h5>
<div class="container my-4">
    <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 mt-4 mb-4 gy-5 justify-content-center">
        @forelse($favorites as $product)
        <div class="col d-flex flex-column align-items-center">
            <div class="product-wrapper">
                <div class="product-card position-relative border" data-bs-toggle="modal"
                    data-bs-target="#productModal" data-id="{{ $product->id }}"
                    data-name="{{ $product->product_name }}" data-description="{{ $product->product_description }}"
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

                <!-- Remove from Favorites Button -->
                <div class="add-to-favorites mt-2">
                    <div class="d-flex justify-content-between align-items-center">
                        <!-- Price -->
                        <div class="product-price" style="padding-left: 18px;">₱{{ $product->price }}</div>

                        <!-- Remove from Favorites Button -->
                        <form id="removeFavoriteForm" method="POST" action="{{ route('favorites.remove', $product->id) }}"
                            class="remove-favorite-form" style="padding-right: 20px;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn favorite-btn">
                                <i class="fa fa-heart-broken"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        @empty
        <h5>No favorite products found. 🍟🍔🍕🍽🍳</h5>
        <a href="{{ route('shops.list') }}"><button class="btn btn-primary mt-2">Let's find some favourites</button></a>
        @endforelse

        <!-- Include product modal outside of the loop -->
        @include('main.buyer.product-modal')

    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Handle "Remove from Favorites" form submission using AJAX
        document.querySelectorAll('.remove-favorite-btn').forEach(function(button) {
            button.addEventListener('click', function(event) {
                event.preventDefault(); // Prevent default form submission

                const form = button.closest('form');
                const url = form.getAttribute('action'); // Get form action

                fetch(url, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                            'Content-Type': 'application/json',
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            // Remove the product from the DOM
                            button.closest('.col').remove();
                        } else {
                            console.error('Error:', data.message);
                        }
                    })
                    .catch(error => console.error('Error:', error));
            });
        });

        // Handle product modal
        document.querySelectorAll('.product-card').forEach(function(card) {
            card.addEventListener('click', function() {
                const productId = this.getAttribute('data-id');
                const productName = this.getAttribute('data-name');
                const productDescription = this.getAttribute('data-description');
                const productPrice = this.getAttribute('data-price');
                const productCategory = this.getAttribute('data-category');
                const productImage = this.getAttribute('data-image');

                const modal = document.getElementById('productModal');

                // Update the modal's content
                modal.querySelector('.modal-title').textContent = productName;
                modal.querySelector('.price').textContent = '₱' + productPrice;
                modal.querySelector('.description').textContent = productDescription;
                modal.querySelector('.category').textContent = productCategory;
                modal.querySelector('img').setAttribute('src', productImage);
                modal.querySelector('img').setAttribute('alt', productName);
            });
        });
    });
</script>

<!-- CSS for product card styling and responsiveness -->
<style>
    .product-wrapper {
        position: relative !important;
        background-color: white !important;
        border-radius: 10px !important;
        overflow: hidden !important;
        box-shadow: none !important;
        padding: 0 !important;
        margin: 0 !important;
    }

    .product-card {
        margin: 0 !important;
        padding: 0 !important;
        border: none !important;
        box-shadow: none !important;
    }

    .product-tumb {
        width: 100% !important;
        height: 180px !important;
        margin: 0 !important;
        padding: 0 !important;
    }

    .product-details {
        padding: 10px 15px !important;
        background-color: white !important;
    }

    img {
        display: block !important;
        width: 100% !important;
        height: auto !important;
        object-fit: cover !important;
    }

    .add-to-favorites {
        margin-bottom: 20px;
    }

    .favorite-btn {
        padding: 6px 12px;
        padding-left: 10px;
        font-size: 14px;
        color: #3ac2ef;
        background-color: transparent;
        border-radius: 15px;
        border: none;
    }

    .full-width-line {
        border: 0;
        border-top: 1px solid #ddd;
        width: 100%;
        margin: 0;
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .product-wrapper {
            max-width: 100%;
        }

        .product-details h4 {
            font-size: 16px;
        }

        .product-price {
            font-size: 16px;
        }

        .favorite-btn {
            font-size: 14px;
        }
    }

    @media (max-width: 576px) {
        .product-wrapper {
            max-width: 100%;
        }

        .product-details h4 {
            font-size: 14px;
        }

        .product-price {
            font-size: 14px;
        }

        .favorite-btn {
            font-size: 12px;
        }
    }
</style>

@endsection