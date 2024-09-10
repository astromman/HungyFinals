<!-- product-modal.blade.php -->
<form id="productForm" method="POST" action="{{ route('cart.add') }}">
    @csrf
    <input type="hidden" name="product_id" class="product_id">
    <input type="hidden" name="product_price" class="product_price">
    <!-- <input type="hidden" name="shopId" value=" shops->id "> -->

    <div class="modal fade" id="productModal" tabindex="-1" aria-labelledby="productModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 id="productModalLabel">Product Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" onclick="location.reload()"></button>
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
                                <input type="text" name="product_qty" class="form-control mx-2 w-100 text-center qty-input" style="width: 50px;" value="1" max="10">
                                <button type="button" class="btn btn-outline-success btn-increase">+</button>
                            </div>
                            <button type="submit" class="btn btn-primary mt-2 w-100"><i class="fa fa-shopping-cart"></i> Add to cart</button>
                        </div>
                    </div>

                    <div class="container">
                        <ul class="nav nav-tabs mt-4">
                            <li class="nav-item">
                                <a class="nav-link active" data-bs-toggle="tab" href="#description">Description</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-bs-toggle="tab" href="#reviews">Reviews</a>
                            </li>
                        </ul>
                        <div class="tab-content">
                            <div id="description" class="container tab-pane active"><br>
                                <h6>Description</h6>
                                <p class="description"></p>
                            </div>
                            <div id="reviews" class="container tab-pane fade"><br>
                                <h6>Reviews</h6>
                                <div class="row">
                                    <div class="col-md-2">
                                        <img src="path/to/user/image.jpg" alt="User" class="img-fluid rounded-circle">
                                    </div>
                                    <div class="col-md-10">
                                        <p>2024-08-01</p>
                                        <div class="d-flex justify-content-between">
                                            <p>John Doe</p>
                                            <div class="star-rating">
                                                <span class="fa fa-star"></span>
                                                <span class="fa fa-star"></span>
                                                <span class="fa fa-star"></span>
                                                <span class="fa fa-star-o"></span>
                                                <span class="fa fa-star-o"></span>
                                            </div>
                                        </div>
                                        <p>Great product!</p>
                                    </div>
                                </div>
                                <div class="row mt-3">
                                    <div class="col-md-2">
                                        <img src="path/to/user/image.jpg" alt="User" class="img-fluid rounded-circle">
                                    </div>
                                    <div class="col-md-10">
                                        <p>2024-08-02</p>
                                        <div class="d-flex justify-content-between">
                                            <p>Jane Smith</p>
                                            <div class="star-rating">
                                                <span class="fa fa-star"></span>
                                                <span class="fa fa-star"></span>
                                                <span class="fa fa-star"></span>
                                                <span class="fa fa-star"></span>
                                                <span class="fa fa-star-o"></span>
                                            </div>
                                        </div>
                                        <p>Very fresh!</p>
                                    </div>
                                </div>
                                <div class="row mt-3">
                                    <div class="col-md-2">
                                        <img src="path/to/user/image.jpg" alt="User" class="img-fluid rounded-circle">
                                    </div>
                                    <div class="col-md-10">
                                        <p>2024-08-02</p>
                                        <div class="d-flex justify-content-between">
                                            <p>Jane Smith</p>
                                            <div class="star-rating">
                                                <span class="fa fa-star"></span>
                                                <span class="fa fa-star"></span>
                                                <span class="fa fa-star"></span>
                                                <span class="fa fa-star"></span>
                                                <span class="fa fa-star-o"></span>
                                            </div>
                                        </div>
                                        <p>Very fresh!</p>
                                    </div>
                                </div>
                                <div class="row mt-3">
                                    <div class="col-md-2">
                                        <img src="path/to/user/image.jpg" alt="User" class="img-fluid rounded-circle">
                                    </div>
                                    <div class="col-md-10">
                                        <p>2024-08-02</p>
                                        <div class="d-flex justify-content-between">
                                            <p>Jane Smith</p>
                                            <div class="star-rating">
                                                <span class="fa fa-star"></span>
                                                <span class="fa fa-star"></span>
                                                <span class="fa fa-star"></span>
                                                <span class="fa fa-star"></span>
                                                <span class="fa fa-star-o"></span>
                                            </div>
                                        </div>
                                        <p>Very fresh!</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="mt-4">
                            <h6>Leave a Reply</h6>
                            <div class="form-row">
                                <div class="col">
                                    <input type="text" class="form-control input-bottom-border" placeholder="Your Name*">
                                </div>
                                <div class="col">
                                    <input type="email" class="form-control input-bottom-border" placeholder="Your Email*">
                                </div>
                            </div>
                            <div class="form-group mt-3">
                                <textarea class="form-control input-bottom-border" rows="3" placeholder="Your Review*"></textarea>
                            </div>
                            <div class="form-row align-items-center">
                                <div class="col">
                                    <p>Please Rate:</p>
                                    <div class="star-rating">
                                        <span class="fa fa-star-o"></span>
                                        <span class="fa fa-star-o"></span>
                                        <span class="fa fa-star-o"></span>
                                        <span class="fa fa-star-o"></span>
                                        <span class="fa fa-star-o"></span>
                                    </div>
                                </div>
                                <div class="col text-right">
                                    <button class="btn btn-primary">Post Comment</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const productModal = document.getElementById('productModal');
        const productForm = document.getElementById('productForm');
        const qtyInput = productForm.querySelector('.qty-input');

        // Event listener for when the modal is shown
        productModal.addEventListener('show.bs.modal', function(event) {
            // Button that triggered the modal
            const button = event.relatedTarget;

            // Extract info from data-* attributes
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
            productForm.querySelector('.product_price').value = productPrice;

            // Reset the quantity input to 1
            qtyInput.value = 1;
        });

        // Event listener for when the modal is hidden
        productModal.addEventListener('hidden.bs.modal', function() {
            // Reset the quantity input to 1
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