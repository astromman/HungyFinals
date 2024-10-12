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
    <!-- Search Again Bar -->
    <div class="row justify-content-center mb-5">
        <div class="searchbox-wrap">
            <form action="{{ route('searchItem') }}" method="GET" class="search-bar">
                <input type="text" name="query" placeholder="Search for something..." required>
                <button type="submit"><span>Submit</span></button>
            </form>
        </div>
    </div>
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

    <!-- Filter Section -->
    <div class="row mb-4">
        <div class="col-md-4 col-4">
            <label for="filterType" class="form-label">Filter by Type</label>
            <select id="filterType" class="form-select">
                <option value="all">All</option>
                <option value="shop">Shops</option>
                <option value="product">Products</option>
                {{-- @foreach ($shops as $shop)
                <option value="shop-{{ $shop->id }}">{{ $shop->shop_name }}</option>
                @endforeach --}}
            </select>
        </div>
        <div class="col-md-4 col-4">
            <label for="filterCategory" class="form-label">Filter by Category</label>
            <select id="filterCategory" class="form-select">
                <option value="all">All Categories</option>
                @foreach ($categories as $category)
                <option value="{{ $category->id }}">{{ $category->type_name }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-4 col-4">
            <label for="filterPrice" class="form-label">Filter by Price</label>
            <select id="filterPrice" class="form-select">
                <option value="low_to_high">Low to High</option>
                <option value="high_to_low">High to Low</option>
            </select>
        </div>
    </div>

    <div id="resultsContainer" class="row">
        <!-- Filtered results will be injected here by AJAX -->

        <!-- Shops Results -->
        @if($shops->isNotEmpty())
        <div class="shops-section my-5">
            <h3 class="text-secondary">Shops</h3>
            <hr>
            <div class="row">
                @foreach ($shops as $shop)
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
                        <div class="badge bg-success">
                            {{ $shop->designated_canteen }}
                        </div>
                        <a href="{{ route('visit.shop', ['id' => $shop->id, 'shop_name' => Str::slug($shop->shop_name)]) }}" class="text-dark stretched-link" style="text-decoration: none;">
                            <div class="card-body d-flex flex-column justify-content-between" style="height: 100px;">
                                <h5 class=" card-title">{{ $shop->shop_name }}</h5>
                                <div class="p-2 d-flex justify-content-between align-items-center">
                                    <small class="card-text text-muted"><i class="bi bi-clock-fill text-primary-emphasis pe-1"></i> Prep time: <span class="text-primary-emphasis">{{ $shop->preparation_time }} {{ $shop->preparation_time > 1 ? 'mins' : 'min' }}</span></small>
                                    <small class="card-text text-muted text-left"><i class="bi bi-star-fill text-warning pe-1"></i> Rating: <span class="text-warning">5.4</span></small>
                                </div>
                            </div>
                        </a>
                        @else <!-- unclickable -->
                        <div class="badge bg-success">
                            {{ $shop->designated_canteen }}
                        </div>
                        <div class="card-body d-flex flex-column justify-content-between" style="height: 100px;">
                            <h5 class=" card-title">{{ $shop->shop_name }}</h5>
                            <p class="p-2 card-text text-danger">Closed</p>
                        </div>
                        @endif
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
                <h4 class="text-secondary">{{ $categoryName }}</h4>
                <hr>
                <div class="row">
                    @foreach ($products as $product)
                    <!-- Product Card -->
                    <div class="col-md-6 col-lg-3 mb-4">
                        <div class="product-wrapper">
                            <div class="product-card position-relative border shadow" data-bs-toggle="modal"
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
                                    <img src="{{ asset('storage/products/' . $product->image) }}" alt="{{ $product->product_name }}"
                                        class="img-fluid w-100 h-100" style="object-fit: cover;">
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
                            <div class="add-to-favorites mt-2">
                                <div class="d-flex justify-content-between align-items-center">
                                    <!-- Price -->
                                    <div class="product-price" style="padding-left: 18px;">₱{{ $product->price }}</div>

                                    <!-- Add to Favorites Button -->
                                    <form id="favoriteForm" method="POST" action="{{ route('favorites.add') }}"
                                        class="favorite-form" style="padding-right: 20px;">
                                        @csrf
                                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                                        <button type="submit" class="btn favorite-btn">
                                            <i class="fa fa-heart"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>

                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @else
    <h4 class="text-secondary">No Products Found</h4>
    @endif

    <!-- Include Product Modal -->
    @include('main.buyer.product-modal')
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const filterType = document.getElementById('filterType');
        const filterCategory = document.getElementById('filterCategory');
        const filterPrice = document.getElementById('filterPrice');

        // Listen for changes in any of the filters
        filterType.addEventListener('change', applyFilter);
        filterCategory.addEventListener('change', applyFilter);
        filterPrice.addEventListener('change', applyFilter);

        function applyFilter() {
            const type = filterType.value;
            const category = filterCategory.value;
            const price = filterPrice.value;

            // Send AJAX request to fetch filtered results
            $.ajax({
                url: '/search',
                type: 'GET',
                data: {
                    type: type,
                    category: category,
                    price: price,
                    query: "{{ $searchTerm }}" // Include the search term in the request
                },
                success: function(response) {
                    // Clear current results
                    $('#resultsContainer').html('');

                    // Append shops if type is 'all' or 'shop'
                    if (response.shops.length > 0 && (type === 'all' || type === 'shop')) {
                        $('#resultsContainer').append('<h3 class="text-secondary">Shops</h3><hr>');
                        response.shops.forEach(function(shop) {
                            $('#resultsContainer').append(`
                                <div class="col-md-6 col-lg-4 mb-4">
                                    <div class="card shadow-sm h-100">
                                        <div class="card-header p-0">
                                            <div class="position-relative" style="height: 200px; overflow: hidden;">
                                                <img src="${shop.image}" class="w-100 h-100" style="object-fit: cover;" alt="${shop.shop_name}">
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <h5 class="card-title">${shop.shop_name}</h5>
                                            <p>${shop.shop_bio}</p>
                                            <p><strong>Contact:</strong> ${shop.contact_num}</p>
                                            <a href="/visit-shop/${shop.id}" class="btn btn-outline-primary">Visit Shop</a>
                                        </div>
                                    </div>
                                </div>
                            `);
                        });
                    }

                    // Append products if type is 'all' or 'product'
                    if (response.products.length > 0 && (type === 'all' || type === 'product')) {
                        $('#resultsContainer').append('<h3 class="text-secondary">Products</h3><hr>');
                        response.products.forEach(function(product) {
                            $('#resultsContainer').append(`
                                <div class="col-md-6 col-lg-3 mb-4">
                                    <div class="product-wrapper">
                                        <div class="product-card position-relative border shadow" data-bs-toggle="modal"
                                            data-bs-target="#productModal" data-id="${product.id}"
                                            data-name="${product.product_name}"
                                            data-description="${product.product_description}"
                                            data-price="${product.price}"
                                            data-category="${product.category_name}"
                                            data-image="/storage/products/${product.image}">

                                            <div class="product-tumb w-100" style="height: 200px;">
                                                <img src="/storage/products/${product.image}" alt="${product.product_name}" class="img-fluid w-100 h-100" style="object-fit: cover;">
                                            </div>

                                            <div class="product-details p-3">
                                                <span class="product-catagory d-block">${product.category_name}</span>
                                                <h4 class="mt-2">${product.product_name}</h4>
                                                <hr class="full-width-line">
                                                <div class="product-price">₱${product.price}</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            `);
                        });
                    } else if (response.products.length === 0 && (type === 'all' || type === 'product')) {
                        $('#resultsContainer').append('<h4 class="text-secondary">No Products Found</h4>');
                    }

                    // Handle if both shops and products are empty
                    if (response.shops.length === 0 && response.products.length === 0) {
                        $('#resultsContainer').append('<h4 class="text-secondary">No results found</h4>');
                    }
                },
                error: function() {
                    console.log('Error fetching filtered data');
                }
            });
        }
    });
</script>



<!-- Success Modal Script -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var successModal = new bootstrap.Modal(document.getElementById('successModal'));
        if ('{{ session('
            success ') }}') {
            successModal.show();
        }

        // Apply filtering when dropdown changes
        document.getElementById('filterType').addEventListener('change', applyFilter);
        document.getElementById('filterCategory').addEventListener('change', applyFilter);
        document.getElementById('filterPrice').addEventListener('change', applyFilter);

        function applyFilter() {
            const type = document.getElementById('filterType').value;
            const category = document.getElementById('filterCategory').value;
            const price = document.getElementById('filterPrice').value;

            window.location.href = `?type=${type}&category=${category}&price=${price}`;
        }
    });
</script>

<style>
    .search-bar {
        display: flex;
        align-items: center;
        background-color: #fff;
        /* The entire search bar remains white */
        border-radius: 50px;
        /* Fully rounded corners */
        overflow: hidden;
        width: 100%;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        /* Soft shadow */
    }

    .search-bar input {
        flex-grow: 1;
        padding: 22px 20px;
        border: none;
        outline: none;
        font-size: 16px;
        border-top-left-radius: 50px;
        border-bottom-left-radius: 50px;
        box-shadow: none;
        /* Removes any shadow from input */
    }

    .search-bar button {
        padding: 14px 30px;
        background-color: white;
        /* Button will be fully white */
        color: #5b9bd5;
        /* Text color remains blue */
        border: none;
        /* Removes the border around the button */
        border-top-right-radius: 50px;
        border-bottom-right-radius: 50px;
        cursor: pointer;
        transition: none;
        /* No hover effects */
        outline: none;
        /* Removes default outline */
        box-shadow: none;
        /* Removes shadow from the button */
    }


    .product-wrapper {
        position: relative !important;
        background-color: white !important;
        border-radius: 10px !important;
        overflow: hidden !important;
        box-shadow: none !important;
        padding: 0;
        margin: 0;
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
        box-shadow: none !important;
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
        display: inline-block;
        white-space: nowrap;
        border: none;
    }

    .full-width-line {
        border: 0;
        border-top: 1px solid #ddd;
        width: 100%;
        margin: 0;
    }
</style>
@endsection