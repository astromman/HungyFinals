@extends('layouts.buyer.buyermaster')

@section('content')
<style>
    body {
        background-color: white !important;
    }

    .parent-div {
        background-color: white;
    }

    .first-div {
        width: 100%;
        background-color: white;
    }

    .content-div {
        background-color: lightgray;
    }

    .content-div .child-div {
        background-color: white;
        border: 1px solid #ccc;
        border-radius: 5px;
        margin-bottom: 1rem;
    }
</style>

<!-- Success Modal -->
@if(session('error'))
<div class="modal fade" id="successModal" tabindex="-1" aria-labelledby="successModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="successModalLabel">Unable to checkout!</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                {{ session('error')}}
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
@endif

<div class="container">
    <!-- 1st Div -->
    <div class="d-flex justify-content-between align-items-center py-3">
        <div class="col-auto me-3">
            <a href="{{ route('shop.cart') }}" class="text-decoration-none">
                <i class="fa-solid fa-circle-chevron-left" style="color: #0B1E59; font-size: 30px;"></i>
            </a>
        </div>
        <div class="col">
            <div class="row">
                <div class="col-12 text-left fw-bold fs-4">Last Step - Checkout</div>
                <div class="col-12 text-left fs-6">Your Orders</div>
            </div>
        </div>
    </div>

    <!-- Progress Bar for Checkout -->
    @if($orders->isNotEmpty())
    @include('main.buyer.protobar', ['order' => $orders->first()])
    @endif

    <!-- Content Div with Gray Background -->
    <div style="background-color: lightgray; width: 100%; padding: 15px;">
        <!-- 2nd Div -->
        <div class="border rounded p-3 my-3 bg-white" style="border: 1px solid #ccc; border-radius: 5px;">
            <div class="fw-bold fs-4">Pick-Up Order at</div>
        </div>

        <!-- 3rd Div -->
        <div class="border rounded p-3 my-3 bg-white" style="border: 1px solid #ccc; border-radius: 5px;">
            <div class="row">
                <div class="col-12">{{ $canteen->building_name }}</div>
                <div class="col-12">{{ $shop->preparation_time . ' mins'}}</div>
            </div>
        </div>

        <!-- 4th Div -->
        <div class="d-flex justify-content-between align-items-center border rounded p-3 my-3 bg-white" style="border: 1px solid #ccc; border-radius: 5px;">
            <div class="fw-bold fs-4">Order Summary</div>
            <span><a href="{{ route('visit.shop', ['id' => $shop->id, 'shop_name' => Str::slug($shop->shop_name)]) }}" class="href">Add items</a></span>
        </div>

        <!-- 5th Div -->
        @php $shopTotal = 0; @endphp
        @foreach($orders as $order)
        @php $shopTotal += $order->total; @endphp
        <div class="border rounded p-3 my-3 bg-white" style="border: 1px solid #ccc; border-radius: 5px;">
            <div class="row mb-3">
                <div class="col-1 d-flex justify-content-center align-items-center p-3 bg-secondary-subtle">
                    <span class="mx-2">{{ $order->quantity . 'x' }}</span>
                </div>
                <div class="col-3">
                    <img src="{{ asset('storage/products/' . $order->image) }}" alt="{{ $order->name }}" class="img-fluid rounded bg-secondary-subtle" style="height: 100px; width: 100px; object-fit: contain; margin-right: 20px;">
                </div>
                <div class="col-6 d-flex align-items-center text-uppercase">
                    <div class="row">
                        <span class="mb-0">
                            {{ $order->product_name }}
                        </span>
                        <small class="text-muted">
                            {{ $order->category_name}}
                        </small>

                    </div>
                </div>
                <div class="col-2 d-flex align-items-center justify-content-end">
                    {{ '₱ ' . number_format($order->price, 2) }}
                </div>
            </div>
            <div class="row border-top pt-2">
                <div class="col-6">Subtotal</div>
                <div class="col-6 text-end">{{ '₱ ' . number_format($order->total, 2) }}</div>
            </div>
        </div>
        @endforeach

        <!-- 6th Div -->
        <div class="border rounded p-3 my-3 bg-white" style="border: 1px solid #ccc; border-radius: 5px;">
            <div class="fw-bold fs-4">Payment Details</div>
        </div>

        <!-- 7th Div -->
        <div class="border rounded p-3 my-3 bg-white" style="border: 1px solid #ccc; border-radius: 5px;">
            <div class="d-flex justify-content-between align-items-center mb-2">
                <div>Proof of Payment</div>
                @if(session('screenshot_uploaded'))
                <div id="checkmark" class="text-success">
                    <i class="fa fa-check-circle" aria-hidden="true"></i>
                </div>
                @else
                <div id="checkmark" class="text-success" style="display: none;">
                    <i class="fa fa-check-circle" aria-hidden="true"></i>
                </div>
                @endif
            </div>
            <!-- Trigger the QR Modal -->
            <button id="uploadProofBtn" class="btn btn-primary w-100">Upload Proof of Payment</button>
            <!-- <div class="row">
                <select id="payment-method" name="payment_method" class="form-select">
                    <option value="gcash">💵 GCash</option>
                    <option value="paypal">💳 Paypal</option>
                    <option value="qr"> QR</option>
                </select>
            </div> -->
        </div>

        <!-- 8th Div -->
        <div class="border rounded p-3 my-3 bg-white d-flex justify-content-between align-items-center" style="border: 1px solid #ccc; border-radius: 5px;">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div>Total</div>
                    <div class="fw-bold">{{ '₱ ' . number_format($shopTotal, 2) }}</div>
                </div>
                @if($orders->isNotEmpty())
                <form action="{{ route('place.order', Crypt::encrypt($shop->id)) }}" method="POST">
                    @csrf
                    <!-- Hidden input for payment_method -->
                    <button type="submit" id="place-order-btn" class="btn btn-primary w-100">Place Order</button>
                </form>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- QR Code Modal -->
<div class="modal fade" id="qrModal" tabindex="-1" aria-labelledby="qrModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="qrModalLabel">Scan QR Code to Pay</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center">
                <img src="{{ asset('storage/shop/' . $shop->shop_qr) }}" alt="QR Code" class="img-fluid">
                <p class="mt-3">Scan the code to pay using your preferred QR app.</p>

                <!-- Upload screenshot of payment -->
                <form id="screenshotForm" action="{{ route('submit.payment.screenshot', Crypt::encrypt($shop->id)) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label for="paymentScreenshot" class="form-label">Upload Payment Screenshot</label>
                        <input class="form-control" type="file" id="paymentScreenshot" name="payment_screenshot" accept="image/*" required>
                    </div>
                    <button type="submit" class="btn btn-primary w-100" id="submit-screenshot-btn">Submit Screenshot</button>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const placeOrderBtn = document.getElementById('place-order-btn');
        const uploadProofBtn = document.getElementById('uploadProofBtn');
        const qrModal = new bootstrap.Modal(document.getElementById('qrModal'));
        const checkmark = document.getElementById('checkmark');

        placeOrderBtn.disabled = true;

        // Show QR modal when 'Upload Proof of Payment' button is clicked
        uploadProofBtn.addEventListener('click', function() {
            qrModal.show();
        });

        // Handle screenshot submission
        document.getElementById('screenshotForm').addEventListener('submit', function(e) {
            e.preventDefault(); // Prevent form submission

            const formData = new FormData(this);
            fetch(this.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                },
            }).then(response => {
                if (response.ok) {
                    // Enable place order after successful upload
                    placeOrderBtn.disabled = false;
                    qrModal.hide(); // Close the modal

                    // Show the green checkmark
                    checkmark.style.display = 'block';
                } else {
                    alert('Failed to upload screenshot, please try again.');
                }
            }).catch(error => {
                console.error('Error:', error);
            });
        });
    });
</script>

@endsection