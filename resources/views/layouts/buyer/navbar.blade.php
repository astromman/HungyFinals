<nav class="navbar navbar-expand-lg navbar-dark">
    <div class="container">
        <a class="navbar-brand" href="{{ route('landing.page') }}">HUNGRY FALCONS</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav mx-auto">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('landing.page') }}">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('shops.list') }}">Shops</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('about.us.page') }}">About Us</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        More
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <li><a class="dropdown-item" href="{{ route('buyer.order.history') }}">Order History</a></li>
                        <li><a class="dropdown-item" href="{{ route('my.favorites') }}">Favorites</a></li>
                    </ul>
                </li>
            </ul>
            <div class="three-buttons d-flex align-items-center nav-icons">
                @php
                $userId = session()->get('loginId');
                $ordersInCart = App\Models\Order::where('user_id', $userId)
                ->where('at_cart', true)
                ->get();
                $sumInCart = $ordersInCart->count();
                $submittedOrders = App\Models\Order::where('user_id', $userId)
                ->where('order_status', '!=', 'Completed')
                ->where('order_status', '!=', 'At Cart')
                ->where('at_cart', false)
                ->groupBy('order_reference')
                ->get();
                $sumOfOrders = $submittedOrders->count();
                @endphp
                <a class="nav-link position-relative" href="{{ route('shop.cart') }}">
                    <i class="fas fa-shopping-cart"></i>
                    @if($sumInCart >= 1)
                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                        {{ $sumInCart }}
                    </span>
                    @endif
                </a>
                <a href="#" class="nav-link position-relative" data-bs-toggle="offcanvas" data-bs-target="#shoppingCartCanvas" aria-controls="shoppingCartCanvas">
                    <i class="fa fa-list" aria-hidden="true"></i>
                    @if($sumOfOrders >= 1)
                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                        {{ $sumOfOrders }}
                    </span>
                    @endif
                </a>
                <!-- Profile Icon with Dropdown -->
                <div class="dropdown">
                    <a href="#" class="nav-link dropdown-toggle" id="profileDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fas fa-user"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="profileDropdown">
                        <li><a class="dropdown-item" href="{{ route('buyer.my.profile') }}">My profile</a></li>
                        <li><a class="dropdown-item" href="{{ route('user.logout') }}">Logout</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</nav>

<!-- Include the Offcanvas -->
@include('layouts.buyer.cart-offcanvas')

@php
$userId = session()->get('loginId');

if (!$userId) {
return redirect()->route('user.logout')->with('error', 'Invalid request!');
}

// Fetch all orders in cart, using LEFT JOIN to handle orders without payment info
$orders = App\Models\Order::leftJoin('products', 'orders.product_id', 'products.id')
->leftJoin('payments', 'orders.payment_id', 'payments.id')
->leftJoin('categories', 'products.category_id', 'categories.id')
->leftJoin('shops', 'products.shop_id', 'shops.id')
->leftJoin('buildings', 'shops.building_id', 'buildings.id')
->select(
'orders.*',
'products.product_name',
'products.product_description',
'products.image',
'products.price',
'products.category_id',
'products.shop_id',
'products.status',
'products.is_deleted',
'categories.type_name',
'shops.shop_name',
'buildings.building_name as designated_canteen',
'payments.payment_status', // Include payment details if exists
'payments.feedback',
)
->where('products.status', 'Available')
->where('products.is_deleted', false)
->where('orders.user_id', $userId)
->where('orders.at_cart', true) // Only get orders still in the cart
->where('orders.order_status', 'At Cart') // Orders that are in cart state
->orderBy('orders.updated_at', 'desc')
->get();
if (!$orders) {
return redirect()->route('landing.page')->with([
'paymentRejected' => 'Submitted screen shot was rejected. Please checkout your order again with the correct screen shot.'
]);
}
@endphp

@if(session('paymentRejected'))
<script>
    Swal.fire({
        icon: "error",
        title: "Oops...",
        text: "{{ session('paymentRejected') }}",
        showCancelButton: false,
        confirmButtonText: 'OK'
    }).then((result) => {
        if (result.isConfirmed) {
            // Redirect to the 'my.cart' route when OK is clicked
            window.location.href = "{{ route('shop.cart') }}";
        }
    });
</script>
@endif

@if(session('shopClosed'))
<script>
    Swal.fire({
        icon: "error",
        title: "Oops...",
        text: "{{ session('shopClosed') }}",
        showCancelButton: false,
        confirmButtonText: 'OK'
    });
</script>
@endif

@if(session('shopIdError'))
<script>
    Swal.fire({
        icon: "error",
        title: "Oops...",
        text: "{{ session('shopIdError') }}",
        showCancelButton: false,
        confirmButtonText: 'OK'
    }).then((result) => {
        if (result.isConfirmed) {
            // Redirect to the 'my.cart' route when OK is clicked
            window.location.href = "{{ route('shop.cart') }}";
        }
    });
</script>
@endif

@if(session('orderCompleted'))
@include('main.buyer.review-modal')
<script>
    setTimeout(function() {
        var reviewModal = new bootstrap.Modal(document.getElementById('reviewModal'));
        reviewModal.show();
    }, 500); // Add delay to allow redirection and modal trigger
</script>
@endif

@if(session('reviewSubmitted'))
<script>
    Swal.fire({
        position: "center",
        icon: "success",
        title: "{{ session('reviewSubmitted') }}",
        showConfirmButton: false,
        timer: 1500
    });
</script>
@endif

<!-- Pusher -->
<script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
<!-- Pusher -->
<script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        let userId = {{ session()->get('loginId') }}; // Fetch logged-in buyer's ID

        var pusher = new Pusher('32acbce4969b2fe50044', {
            cluster: 'mt1'
        });

        var orderChannel = pusher.subscribe('orders.' + userId);

        // Listen for order status updates
        orderChannel.bind('order.status.updated', function(event) {
            // Customize the message based on order status
            let message = `Your order with reference ${event.order.order_reference} is now ${event.order.order_status}.`;

            // If the order status is 'Preparing', add preparation message
            if (event.order.order_status === 'Preparing') {
                message = `Your order with reference ${event.order.order_reference} is being prepared in the kitchen.`;
            }

            // If the order status is 'Ready', add pick-up message
            if (event.order.order_status === 'Ready') {
                message += ' Please pick up your order.';
            }

            // If the order status is 'Completed', add thank you message and request for a rating
            if (event.order.order_status === 'Completed') {
                message += ` Thank you for ordering, please rate the product.`;
            }

            // Show a Toastr notification
            toastr.options = {
                "closeButton": true,
                "progressBar": true,
                "positionClass": "toast-top-right",
                "timeOut": 0,
                "onclick": function() {
                    // Redirect to the track order page when clicked
                    window.location.href = `{{ url('/track-order') }}/${event.encryptedId}`;
                }
            };

            toastr.info(message, 'Order Status Updated');
        });

        // Subscribe to the payment status update channel
        var paymentChannel = pusher.subscribe('payment.' + userId);

        // Listen for payment status updates
        paymentChannel.bind('payment.status.updated', function(event) {
            let message = `Your payment for order reference ${event.order.order_reference} is now ${event.paymentStatus}.`;

            if (event.paymentStatus === 'Completed') {
                message = `Your payment for order reference ${event.order.order_reference} has been confirmed.`;
            } else if (event.paymentStatus === 'Rejected') {
                message = `Your payment for order reference ${event.order.order_reference} has been rejected. Feedback: ${event.feedback}`;
            }

            // Show a Toastr notification
            toastr.options = {
                "closeButton": true,
                "progressBar": true,
                "positionClass": "toast-top-right",
                "timeOut": 0,
            };

            toastr.info(message, 'Payment Status Updated');
        });
    });
</script>