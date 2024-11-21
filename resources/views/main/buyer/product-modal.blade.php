<form id="productForm" method="POST" action="{{ route('cart.add') }}">
    @csrf
    <input type="hidden" name="product_id" class="product_id">
    <input type="hidden" name="product_price" class="product_price">

    <div class="modal fade" id="productModal" tabindex="-1" aria-labelledby="productModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 id="productModalLabel">Product Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
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
                                <input type="text" name="product_qty"
                                    class="form-control mx-2 w-100 text-center qty-input" style="width: 50px;"
                                    value="1" max="10">
                                <button type="button" class="btn btn-outline-success btn-increase">+</button>
                            </div>
                            <button type="submit" class="btn btn-primary mt-2 w-100"><i
                                    class="fa fa-shopping-cart"></i> Add to cart</button>
                        </div>
                    </div>

                    <div class="container">
                        <ul class="nav nav-tabs mt-4" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="description-tab" data-bs-toggle="tab" href="#description"
                                    role="tab">Description</a>
                            </li>
                        </ul>
                        <div class="tab-content mt-2">
                            <div id="description" class="tab-pane fade show active" role="tabpanel"
                                aria-labelledby="description-tab">
                                <h6>Description</h6>
                                <p class="description">Tingin sa burger</p>
                                <hr>
                            </div>

                            <!-- Scrollable Reviews Section -->
                            <div class="reviews-section">
                                <h5 class="mb-3">Customer Reviews</h5>

                                <div id="reviewsContainer">
                                    <!-- Reviews will be dynamically populated here -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</form>

<!-- Custom CSS for Scrollable Review Box Design -->
<style>
    .star-rating .checked {
        color: #ffbf00;
        /* Gold color for stars */
    }

    .star-rating i {
        font-size: 14px;
        margin-right: 2px;
    }

    .reviews-section {
        background-color: #f8f9fa;
        border-radius: 6px;
        padding: 8px;
        max-height: 200px;
        /* Fixed height */
        overflow-y: auto;
        /* Makes the section scrollable */
        border: 1px solid #ddd;
    }

    .review-card {
        background-color: #fff;
        border: 1px solid #ddd;
        border-radius: 6px;
        padding: 10px;
    }

    .review-card .reviewer-name {
        font-weight: bold;
        color: #333;
        font-size: 14px;
    }

    .review-card .review-text {
        font-size: 12px;
        color: #555;
        margin-top: 5px;
    }
</style>

<!-- Font Awesome for Stars -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const productModal = document.getElementById('productModal');
        const reviewsContainer = document.getElementById('reviewsContainer');

        productModal.addEventListener('show.bs.modal', function(event) {
            const button = event.relatedTarget;
            const productId = button.getAttribute('data-id');

            // Fetch product reviews from the backend
            fetch(`/get-reviews/${productId}`)
                .then(response => response.json())
                .then(data => {
                    reviewsContainer.innerHTML = ''; // Clear existing reviews
                    if (data.length > 0) {
                        data.forEach(review => {
                            reviewsContainer.innerHTML += `
                            <div class="review-card p-2 mb-2">
                                <div class="d-flex justify-content-between">
                                    <div class="review-content">
                                        <h6 class="reviewer-name mb-1">${review.username}</h6>
                                    </div>
                                    <div class="star-rating">${generateStarRating(review.rating)}</div>
                                </div>
                                <p class="mt-1 review-text">${review.review_text}</p>
                            </div>
                            `;
                        });
                    } else {
                        reviewsContainer.innerHTML = '<p>No reviews found for this product.</p>';
                    }
                })
                .catch(error => {
                    console.error('Error fetching reviews:', error);
                });
        });

        // Function to generate star icons based on rating
        function generateStarRating(rating) {
            let stars = '';

            // Add filled stars based on the rating
            for (let i = 1; i <= 5; i++) {
                if (i <= rating) {
                    stars += '<i class="fas fa-star" style="color: #ffbf00;"></i>'; // Gold color for filled stars
                } else {
                    stars += '<i class="far fa-star" style="color: #ffbf00;"></i>'; // Outline star for empty stars
                }
            }

            return stars;
        }
    });
</script>