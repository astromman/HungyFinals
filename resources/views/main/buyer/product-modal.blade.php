<!-- product-modal.blade.php -->
<form id="productForm" method="POST" action="{{ route('cart.add') }}">
    @csrf
    <input type="hidden" name="product_id" class="product_id">
    <input type="hidden" name="product_price" class="product_price">
    <input type="hidden" name="product_qty" class="product_qty">

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
                            <h6 class="category"></h6>
                            <h3 class="modal-title"></h3>
                            <br>
                            <h4><strong class="price highlight-text"></strong></h4>
                            <div class="d-flex">
                                <button type="button" class="btn btn-outline-danger btn-decrease">_</button>
                                <input type="text" class="form-control mx-2 w-100 text-center qty-input" style="width: 50px;" value="1" max="10">
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
        const modalElement = document.getElementById('productModal');
        const qtyInput = modalElement.querySelector('.qty-input');
        const decreaseBtn = modalElement.querySelector('.btn-decrease');
        const increaseBtn = modalElement.querySelector('.btn-increase');
        const productQtyInput = modalElement.querySelector('.product_qty');

        decreaseBtn.addEventListener('click', function() {
            let currentQty = parseInt(qtyInput.value);
            if (currentQty > 1) {
                qtyInput.value = currentQty - 1;
                productQtyInput.value = qtyInput.value; // Update hidden field
            }
        });

        increaseBtn.addEventListener('click', function() {
            let currentQty = parseInt(qtyInput.value);
            qtyInput.value = currentQty + 1;
            productQtyInput.value = qtyInput.value; // Update hidden field
        });

        modalElement.addEventListener('hidden.bs.modal', function() {
            qtyInput.value = 1;
            productQtyInput.value = 1; // Reset hidden field to 1 when modal is closed
        });

        // Update the hidden qty field before submitting the form
        const form = document.getElementById('productForm');
        form.addEventListener('submit', function() {
            productQtyInput.value = qtyInput.value;
        });

        // Populate Modal with Product Data
        document.querySelectorAll('.product-card').forEach(card => {
            card.addEventListener('click', function() {
                const modal = document.querySelector('#productModal');

                // Populate the visible modal content
                modal.querySelector('.modal-title').textContent = this.getAttribute('data-name');
                modal.querySelector('.modal-body .img').src = this.getAttribute('data-image');
                modal.querySelector('.modal-body .category').textContent = this.getAttribute('data-category');
                modal.querySelector('.modal-body .description').textContent = this.getAttribute('data-description');
                modal.querySelector('.modal-body .price').textContent = '₱' + this.getAttribute('data-price');

                modal.querySelector('.product_id').value = this.getAttribute('data-id');
                modal.querySelector('.product_price').value = this.getAttribute('data-price');
                productQtyInput.value = qtyInput.value; // Initialize hidden qty input
            });
        });
    });
</script>