<form id="productForm" method="POST" action="{{ route('cart.add') }}">
    @csrf
    <input type="hidden" name="product_id" class="product_id">
    <input type="hidden" name="product_price" class="product_price">

    <div class="modal fade" id="productModal" tabindex="-1" aria-labelledby="productModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 id="productModalLabel">Product Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" onclick="location.reload()"></button>
                </div>
                <div class="modal-body">
                    <div class="row align-items-center">
                        <div class="col-md-6">
                            <img src="" alt="" class="img bg-secondary-subtle">
                        </div>
                        <div class="col-md-6">
                            <h6 class="category pt-2"></h6>
                            <h3 class="modal-title text-uppercase"></h3>
                            <br>
                            <h1><strong name="price" class="price highlight-text"></strong></h1>
                            <div class="d-flex">
                                <button type="button" class="btn btn-outline-danger btn-decrease">_</button>
                                <input type="text" name="product_qty" class="form-control mx-2 w-100 text-center qty-input" readonly style="width: 50px;" value="1" max="10">
                                <button type="button" class="btn btn-outline-success btn-increase">+</button>
                            </div>
                            <button type="submit" class="btn btn-primary mt-2 w-100"><i class="fa fa-shopping-cart"></i> Add to cart</button>
                        </div>
                    </div>

                    <div class="container">
                        <ul class="nav nav-tabs mt-4" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="description-tab" data-bs-toggle="tab" href="#description" role="tab">Description</a>
                            </li>
                        </ul>
                        <div class="tab-content mt-2">
                            <div id="description" class="tab-pane fade show active" role="tabpanel" aria-labelledby="description-tab">
                                <h6>Description</h6>
                                <p class="description">Tingin sa burger</p>
                                <hr>
                            </div>

                            <!-- Scrollable Reviews Section -->
                            <div class="reviews-section">
                                <h5 class="mb-3">Customer Reviews</h5>
                                @forelse($reviews as $review)
                                <!-- Single Review -->
                                <div class="review-card p-2 mb-2">
                                    <div class="d-flex justify-content-between">
                                        <!-- Reviewer Details -->
                                        <div class="review-content">
                                            <h6 class="reviewer-name mb-1">kUPAL</h6>
                                        </div>
                                        <!-- Star Rating -->
                                        <div class="star-rating">
                                            <i class="fas fa-star checked"></i>
                                            <i class="fas fa-star checked"></i>
                                            <i class="fas fa-star checked"></i>
                                            <i class="fas fa-star checked"></i>
                                            <i class="fas fa-star-half-alt"></i>
                                        </div>
                                    </div>
                                    <!-- Review Text -->
                                    <p class="mt-1 review-text">
                                        Overall, I'm very satisfied with this product! The quality exceeded my expectations, and the design is exactly what I was looking for. The shipping was fast, and the customer service was excellent.
                                    </p>
                                </div>
                                @empty
                                <p class="text-center">No reviews yet!</p>
                                @endforelse

                                <!-- Additional reviews can follow here -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>

<!-- Custom CSS for Scrollable Review Box Design -->


<!-- Font Awesome for Stars -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">