<!-- Bootstrap CSS -->
<!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"> -->

<!-- Modal -->
<div class="modal fade" id="reviewModal" tabindex="-1" aria-labelledby="reviewModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <div class="rating-container">
                    <h5 class="modal-title" id="reviewModalLabel">Overall rating</h5>
                    <div class="star-rating">
                        <!-- New star rating system -->
                        <span class="fa fa-star" data-value="1"></span>
                        <span class="fa fa-star" data-value="2"></span>
                        <span class="fa fa-star" data-value="3"></span>
                        <span class="fa fa-star" data-value="4"></span>
                        <span class="fa fa-star" data-value="5"></span>
                    </div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <!-- Error Message Display -->
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <!-- Form for review submission -->
                <form method="POST" action="{{ route('submit.review') }}" id="reviewForm">
                    @csrf
                    <!-- Hidden input for storing the selected rating -->
                    <input type="hidden" name="rating" id="ratingValue" value="">
                    <input type="hidden" name="order_reference" value="{{ session('orderReference') }}">
                    <p class="form-text">Click to rate</p>

                    <!-- Product Review -->
                    <div class="mb-3">
                        <label for="productReview" class="form-label">Product review</label>
                        <textarea class="form-control" id="productReview" name="review_text" rows="3"
                            placeholder="Send a feedback." required></textarea>
                    </div>

                    <!-- Terms and Conditions -->
                    <div class="mb-3 form-check">
                        <input type="checkbox" class="form-check-input" id="termsCheck" required>
                        <label class="form-check-label terms" for="termsCheck">I accept the <a href="#">terms
                                and conditions</a></label>
                    </div>

                    <!-- Additional Info -->
                    <div class="additional-info">
                        Your feedback and suggestions are invaluable in enhancing our services and products. We
                        deeply appreciate your input, as it empowers us to continuously improve and better meet your
                        needs.
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" class="submit-btn">Submit product review</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<!-- Custom Script for New Star Rating -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        let stars = document.querySelectorAll('.star-rating .fa-star');
        let ratingValueInput = document.getElementById('ratingValue');

        // Star click event to capture rating
        stars.forEach(function (star) {
            star.addEventListener('click', function () {
                let rating = this.getAttribute('data-value');
                ratingValueInput.value = rating;

                // Highlight the selected stars
                stars.forEach(function (s) {
                    s.classList.remove('checked');
                });
                for (let i = 0; i < rating; i++) {
                    stars[i].classList.add('checked');
                }
            });
        });

        // Form submission
        document.getElementById('reviewForm').addEventListener('submit', function (event) {
            if (ratingValueInput.value === '') {
                event.preventDefault();
                alert('Please select a rating before submitting your review.');
            }
        });
    });
</script>

<!-- Styles for the star rating system -->
<style>
    .modal-content {
        border-radius: 15px;
        padding: 30px;
        background-color: #fff9f9;
    }

    .modal-header {
        border-bottom: none;
        position: relative;
    }

    .btn-close {
        position: absolute;
        top: 0;
        right: 0;
        font-size: 20px;
        padding: 10px;
    }

    .star-rating {
        display: flex;
        gap: 5px;
        cursor: pointer;
    }

    .star-rating .fa-star {
        font-size: 2rem;
        color: #e5e5e5;
    }

    .star-rating .fa-star.checked {
        color: #ffc107;
    }

    .form-label {
        font-weight: bold;
        font-size: 14px;
        color: #2c2c2c;
    }

    .form-control,
    .form-check-input {
        border-radius: 8px;
        background-color: #f0f0f0;
        border: 1px solid #ddd;
        padding: 10px;
        font-size: 14px;
        color: #2c2c2c;
    }

    .submit-btn {
        background-color: #1f1f1f;
        color: white;
        border: none;
        padding: 12px 20px;
        border-radius: 5px;
        width: 100%;
        font-size: 16px;
        margin-top: 20px;
    }

    .submit-btn:hover {
        background-color: #131313;
    }

    .terms a {
        color: #2c2c2c;
        text-decoration: underline;
    }

    .terms a:hover {
        color: #1f1f1f;
    }

    .terms {
        margin-bottom: 15px;
    }

    .additional-info {
        font-size: 12px;
        color: #6c6c6c;
    }
</style>