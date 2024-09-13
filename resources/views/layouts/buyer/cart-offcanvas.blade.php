<!-- resources/views/partials/cart-offcanvas.blade.php -->
<div class="offcanvas offcanvas-end" tabindex="-1" id="shoppingCartCanvas" aria-labelledby="shoppingCartLabel">
    <div class="container py-1">
        <div class="row align-items-center">
            <div class="col-md-2 col-2 py-2">
                <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div class="col-md-8 col-8 py-2 text-center">
                <h5>Orders ni Klasmeyt</h5>
            </div>
            <div class="col-md-2 col-2 py-2"></div>
            <hr class="shadow">
        </div>
    </div>

    <div class="offcanvas-body justify-content-center">
        @php
        $userId = session()->get('loginId');
        $orders = App\Models\Order::where('user_id', $userId)
        ->where('order_status', '!=', 'Completed')
        ->where('order_status', 'Pending')
        ->where('at_cart', false)
        ->groupBy('order_reference')
        ->get();
        @endphp

        @forelse($orders as $order)
        <div class="card w-100 my-2">
            <div class="py-2 justify-content-start align-items-start">
                <h5>Order Ref. <small>{{ $order->order_reference }}</small></h5>
            </div>
            <!-- Responsive Multi-Step Progress Bar -->
            <div class="progress-container my-4">
                <ul class="progressbar">
                    <li class="active">Order</li>
                    <li>Preparing</li>
                    <li>Pick-up</li>
                </ul>
            </div>
        </div>
        @empty

        @endforelse

        <!-- Order Cart Title -->
        <!-- <h4 class="mb-4">Order Cart</h4> -->

        <!-- Cart Items Table -->
        <!-- <table class="table">
            <tbody>
                <tr>
                    <td>
                        <div class="d-flex">
                            <button class="btn btn-outline-secondary">-</button>
                            <span class="mx-2">1</span>
                            <button class="btn btn-outline-secondary">+</button>
                        </div>
                    </td>
                    <td>
                        <div class="d-flex">
                            <img src="path_to_image" alt="Food Image" class="img-fluid me-2" style="width: 50px;">
                            <div>
                                <div>Name: Tapsilog special</div>
                                <div>Category:</div>
                                <div>FRC CANTEEN</div>
                            </div>
                        </div>
                    </td>
                    <td class="text-center">₱55.00</td>
                </tr>

                <tr>
                    <td colspan="2">
                        <div>Subtotal</div>
                        <div class="text-muted">Total Fee will be shown at the counter</div>
                    </td>
                    <td class="text-center border-top">₱55.00</td>
                </tr>
            </tbody>
        </table> -->
    </div>

    <div class="offcanvas-footer p-3">
        <div class="d-flex justify-content-between mb-2">
            <div>Total</div>
            <div>₱115.00</div>
        </div>
        <button class="btn btn-primary w-100">Review Order</button>
    </div>
</div>

<!-- Add the required CSS for the Progress Bar -->
<style>
    /* Offcanvas Styling */
    .offcanvas-header .col-11 h5 {
        margin: 0;
        text-align: left;
    }

    .offcanvas-footer {
        border-top: 1px solid #dee2e6;
    }

    .btn-primary:hover {
        background-color: #003366;
    }

    .table td,
    .table th {
        border-top: none;
    }

    .table .border-top {
        border-top: 2px solid #ccc;
    }

    /* Multi-Step Progress Bar Styling */
    .progress-container {
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .progressbar {
        display: flex;
        justify-content: space-between;
        width: 100%;
        padding: 0;
        margin: 0;
        list-style: none;
        counter-reset: step;
    }

    .progressbar li {
        text-align: center;
        position: relative;
        flex-grow: 1;
        color: #7d7d7d;
        counter-increment: step;
    }

    .progressbar li::before {
        content: counter(step);
        width: 36px;
        height: 36px;
        line-height: 36px;
        display: block;
        font-size: 18px;
        color: #fff;
        background: #7d7d7d;
        border-radius: 50%;
        margin: 0 auto 10px auto;
    }

    .progressbar li::after {
        content: '';
        position: absolute;
        width: 100%;
        height: 4px;
        background: #7d7d7d;
        top: 18px;
        left: -50%;
        z-index: -1;
    }

    .progressbar li:first-child::after {
        content: none;
    }

    .progressbar li.active {
        color: #007bff;
    }

    .progressbar li.active::before {
        background: #007bff;
    }

    .progressbar li.active::after {
        background: #007bff;
    }

    /* Hide Scrollbar */
    .offcanvas-body::-webkit-scrollbar {
        display: none;
    }

    .offcanvas-body {
        -ms-overflow-style: none;
        /* IE and Edge */
        scrollbar-width: none;
        /* Firefox */
    }
</style>


<!-- Add the required JavaScript for the Progress Bar -->
<script>
    let step = 'step1';

    const step1 = document.getElementById('step-1');
    const step2 = document.getElementById('step-2');
    const step3 = document.getElementById('step-3');

    function next() {
        if (step === 'step1') {
            step = 'step2';
            step1.classList.remove("is-active");
            $(step1).find('.progress-bar__bar').css('transform', 'translateX(100%)');
            $(step1).find('.progress-bar__bar').css('-webkit-transform', 'translateX(100%)');
            step2.classList.add("is-active");
        } else if (step === 'step2') {
            step = 'step3';
            step2.classList.remove("is-active");
            $(step2).find('.progress-bar__bar').css('transform', 'translateX(100%)');
            $(step2).find('.progress-bar__bar').css('-webkit-transform', 'translateX(100%)');
            step3.classList.add("is-active");
        } else if (step === 'step3') {
            step = 'complete';
            step3.classList.remove("is-active");
        }
    }
</script>