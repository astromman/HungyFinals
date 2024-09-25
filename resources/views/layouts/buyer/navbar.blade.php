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
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" data-bs-target="more-items" aria-expanded="false">
                        More
                    </a>
                    <ul id="more-items" class="dropdown-menu" aria-labelledby="navbarDropdown">
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